<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/config/connect.php");
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["product__sumit"])) {
    $tensanpham = test_input($_POST["tensanpham"]);
    $dongia = test_input($_POST["dongia"]);
    $mota = test_input($_POST["mota"]);

    $trangthai = $_POST["trangthai"];
    $idNhaCungCap = $_POST["idNhaCungCap"];
    $idDanhMuc = $_POST["idDanhMuc"];

    // soluongconlai idKichThuoc idMauSac
    $soluongconlai = test_input($_POST["soluongconlai"]);

    // Chỉ lấy tên hình ảnh để gửi lên database
    $image = $_FILES["urlhinhanh"]["name"];

    // Lấy đường dẫn của ảnh
    $image_tmp_name = $_FILES["urlhinhanh"]["tmp_name"];

    $idKichThuoc = $_POST["idKichThuoc"];
    $idMauSac = $_POST["idMauSac"];



    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // 1. Thêm dữ liệu vào bảng `SanPham`
        $stmt1 = $conn->prepare("INSERT INTO sanpham (tensanpham, dongia, mota, trangthai, ngaytao, idNhaCungCap, idDanhMuc) VALUES (?, ?, ?, ?, current_timestamp(), ?, ?)");
        $stmt1->bind_param("sisiii", $tensanpham, $dongia, $mota, $trangthai, $idNhaCungCap, $idDanhMuc);

        // Thực hiện câu lệnh
        $stmt1->execute();

        // 2. Lấy idSanPham vừa tạo
        $new_idSanPham = $conn->insert_id;
        $idSanPham = $new_idSanPham;  // Sử dụng idSanPham vừa lấy

        // 3. Thêm dữ liệu vào bảng `ChiTietSanPham` với idSanPham vừa lấy
        $stmt2 = $conn->prepare("INSERT INTO ChiTietSanPham (soluongconlai, idSanPham, idKichThuoc, idMauSac) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("iiii", $soluongconlai, $idSanPham, $idKichThuoc, $idMauSac);
        $stmt2->execute();

        $stmt3 = $conn->prepare("INSERT INTO hinhanhsanpham (urlhinhanh, idSanPham) VALUES (?, ?)");
        $stmt3->bind_param("si", $image, $idSanPham);
        $stmt3->execute();

        // Commit giao dịch
        $conn->commit();

        // Thêm nhiều ảnh
        $uploaded_files = $_FILES['hinhanhurl'];

        // Đường dẫn thư mục lưu trữ ảnh
        $image_path = 'C:/xampp/htdocs/CHDDTTHKN/assets/img/products/';

        // Kiểm tra nếu có tệp được tải lên
        if (!empty($uploaded_files['name'][0])) {
            foreach ($uploaded_files['name'] as $key => $image_name) {
                $image_tmp_name = $uploaded_files['tmp_name'][$key];
                $final_image_path = $image_path . $image_name;

                // Di chuyển từng tệp vào thư mục lưu trữ
                if (move_uploaded_file($image_tmp_name, $final_image_path)) {
                    // Lưu tên ảnh vào cơ sở dữ liệu
                    $stmt = $conn->prepare("INSERT INTO hinhanhsanpham (urlhinhanh, idSanPham) VALUES (?, ?)");
                    $stmt->bind_param("si", $image_name, $idSanPham);
                    $stmt->execute();
                } else {
                    echo "Không thể lưu tệp: " . $image_name;
                    exit;
                }
            }
        }
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();
        echo "<script>
            alert('Không thể thêm sản phẩm.');
            window.location.href = '/CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham';
            </script>";
    }
    // end
    move_uploaded_file($image_tmp_name, 'C:/xampp/htdocs/CHDDTTHKN/assets/img/product/' . $image);

    header("location: /CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham");
}

// search sản phẩm
$search_sanpham = isset($_GET["search_sanpham"]) ? $_GET["search_sanpham"] : "";
// search giá 
$search_gia_from = isset($_GET["search_gia_from"]) ? $_GET["search_gia_from"] : "";
$search_gia_to = isset($_GET["search_gia_to"]) ? $_GET["search_gia_to"] : "";

$item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 4;
$current_page = !empty($_GET["pages"]) ? $_GET["pages"] : 1;
$offset = ($current_page - 1) * $item_per_page;

if ($search_sanpham) {
        include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/header.php");
    $sql_sp_ctsp = "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham 
                    WHERE sp.tensanpham LIKE '%" . $search_sanpham . "%'
                    ORDER BY sp.idSanPham ASC LIMIT $item_per_page OFFSET $offset";
    $result_sp_ctsp = mysqli_query($conn, $sql_sp_ctsp);
    $totalRecords = mysqli_query($conn, "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham 
                    WHERE sp.tensanpham LIKE '%" . $search_sanpham . "%' OR sp.dongia LIKE '%" . $search_sanpham . "%'");
} else if ($search_gia_from && $search_gia_to) {
        include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/header.php");
    $sql_sp_ctsp = "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham 
                    WHERE (sp.dongia BETWEEN $search_gia_from AND $search_gia_to) OR (sp.dongia = 0 AND sp.dongia = 0)
                    ORDER BY sp.idSanPham ASC LIMIT $item_per_page OFFSET $offset";
    $result_sp_ctsp = mysqli_query($conn, $sql_sp_ctsp);
    $totalRecords = mysqli_query($conn, "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham 
                    WHERE (sp.dongia BETWEEN $search_gia_from AND $search_gia_to) OR (sp.dongia = 0 AND sp.dongia = 0)");
} else {
    $sql_sp_ctsp = "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham ORDER BY sp.idSanPham ASC LIMIT $item_per_page OFFSET $offset";
    $result_sp_ctsp = mysqli_query($conn, $sql_sp_ctsp);
    $totalRecords = mysqli_query($conn, "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham");
}

$totalNumber = $totalRecords->num_rows;
$totalPages = ceil($totalNumber / $item_per_page);
?>

<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Quản lý sản phẩm
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>

            <button class="content__header-btn js-product__header-btn">
                Thêm sản phẩm
            </button>

            <div class="content__header-form">
                <form action="/CuaHangDungCu/app/views/manager/sanpham.php" class="content__header-form-search" method="GET">
                    <input name="search_sanpham" type="text" class="content__header-form-search-text" required placeholder="Tìm kiếm tên sản phẩm">

                    <button type="submit" class="content__header-form-search-submit">
                        Tìm kiếm
                        <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                    </button>
                </form>

                <form action="/CuaHangDungCu/app/views/manager/sanpham.php" class="content__header-form-search-cost" method="GET">
                    <label for="" class="content__header-form-search-cost-label">giá từ: </label>
                    <input type="number" class="content__header-form-search-cost-input" required min="1" name="search_gia_from" id="" placeholder="Nhập giá từ">
                    <label for="" class="content__header-form-search-cost-label">đến: </label>
                    <input type="number" class="content__header-form-search-cost-input" required min="1" name="search_gia_to" id="" placeholder="Nhập giá đến">
                    <button type="submit" class="content__header-form-search-submit-cost">
                        Tìm kiếm
                        <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                    </button>
                </form>
            </div>

        </div>

        <div class="content__body">
            <h2 class="content__body-heading-text">Danh sách sản phẩm</h2>


            <table class="content__body-table" cellspacing="0">
                <thead class="content__body-thead">
                    <tr class="content__body-tr">
                        <th class="content__body-th">ID</th>
                        <th class="content__body-th">Tên sản phẩm</th>
                        <th class="content__body-th">Hình ảnh</th>
                        <th class="content__body-th">Đơn giá</th>
                        <th class="content__body-th">Trạng thái</th>
                        <th class="content__body-th">Số lượng còn lại</th>
                        <th class="content__body-th">Kích thước</th>
                        <th class="content__body-th">Màu sắc</th>
                        <th class="content__body-th">Chức năng</th>
                    </tr>
                </thead>

                <tbody class="content__body-tbody">

                    <?php

                    if ($result_sp_ctsp->num_rows > 0) {
                        while ($row_sp_ctsp = mysqli_fetch_assoc($result_sp_ctsp)) {
                    ?>

                            <tr class="content__body-tr">
                                <td class="content__body-td"><?php echo $row_sp_ctsp["idSanPham"] ?></td>
                                <td class="content__body-td"><?php echo $row_sp_ctsp["tensanpham"] ?></td>

                                <td class="content__body-td">
                                    <?php
                                    $sql_hinhanhsp = "SELECT * FROM sanpham sp JOIN hinhanhsanpham hasp ON sp.idSanPham = hasp.idSanPham WHERE sp.idSanPham = ?";
                                    $stmt_hinhanhsp = $conn->prepare($sql_hinhanhsp);
                                    $stmt_hinhanhsp->bind_param("i", $row_sp_ctsp["idSanPham"]);
                                    $stmt_hinhanhsp->execute();
                                    $result_hinhanhsp = $stmt_hinhanhsp->get_result();
                                    $row__hinhanhsp = $result_hinhanhsp->fetch_assoc();
                                    ?>
                                    <img class="content__body-td-img" width="40" height="50" src="/CuaHangDungCu/public/assets/images/products/<?php echo $row__hinhanhsp["urlhinhanh"]; ?>" alt="Hình ảnh sản phẩm">
                                </td>

                                <td class="content__body-td"><?php echo number_format($row_sp_ctsp["dongia"], 0, ',', '.') ?></td>
                                <td class="content__body-td">
                                    <?php
                                    if ($row_sp_ctsp["trangthai"] == 1) {
                                        echo "Còn bán";
                                    } else if ($row_sp_ctsp["trangthai"] == 0) {
                                        echo "Hết hàng";
                                    }
                                    ?>
                                </td>
                                <td class="content__body-td"><?php echo $row_sp_ctsp["soluongconlai"] ?></td>
                                <td class="content__body-td">

                                    <?php

                                    $sql_kichthuoc = "SELECT kichthuoc FROM kichthuocsanpham WHERE idKichThuoc = " . $row_sp_ctsp["idKichThuoc"];
                                    $result_kichthuoc = mysqli_query($conn, $sql_kichthuoc);

                                    while ($row_kichthuoc = mysqli_fetch_array($result_kichthuoc)) {
                                        echo $row_kichthuoc["kichthuoc"];
                                        break;
                                    }

                                    ?>

                                </td>
                                <td class="content__body-td">
                                    <?php
                                    $sql_mausac = "SELECT * FROM mausacsanpham WHERE idMauSac = " . $row_sp_ctsp["idMauSac"];
                                    $result_mausac = mysqli_query($conn, $sql_mausac);

                                    while ($row_mausac = mysqli_fetch_array($result_mausac)) {
                                        echo $row_mausac["mausac"];
                                        break;
                                    }
                                    ?>
                                </td>
                                <td class="content__body-td">

                                    <button class="content__body-td__btn-see view-details js_content__body-td__btn-see" data-id="<?php echo $row_sp_ctsp['idSanPham'] ?>">xem</button>

                                    <form action='/CHDDTTHKN/assets/controller/deleteSanPham.php' class="content__body-td-form" method='POST'>
                                        <input type='hidden' name='idSanPham' value="<?php echo $row_sp_ctsp["idSanPham"] ?>">
                                        <input type='submit' class="content__body-td__btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" value="xóa">
                                    </form>

                                    <form action="/CHDDTTHKN/assets/controller/editSanPham.php" class="content__body-td-form" method="POST">
                                        <input type="hidden" name="idSanPham" value="<?php echo $row_sp_ctsp["idSanPham"] ?>">
                                        <input type="hidden" name="idChiTietSanPham" value="<?php echo $row_sp_ctsp["idChiTietSanPham"] ?>">
                                        <input type="submit" class="content__body-td__btn-edit" value="sửa">
                                    </form>
                                </td>
                            </tr>

                    <?php
                        }
                    } else {
                        echo "  <tr class='content__body-tr'>
                                            <td class='content__body-td' colspan='9'>Không có sản phẩm nào.</td>
                                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?php include $_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/controllers/manager/paginationSanPham.php" ?>
        </div>
    </div>
</div>
</div>

<!-- Modal Add -->
<div class="content__modal js-product__modal">
    <div class="content__modal-container js-product__modal-container">

        <div class="content__modal-close js-product__modal-close">
            <i class="fa-solid fa-xmark product__modal-icon-close"></i>
        </div>

        <div class="content__modal-header">
            <h2 class="content__modal-header-text-heading">
                <i class="fa-solid fa-basketball content__modal-header-text-heading-icon"></i>
                Thêm sản phẩm
            </h2>
        </div>

        <div class="content__modal-body">
            <form action="sanpham.php" class="content__modal-body-form" method="POST" enctype="multipart/form-data">

                <div class="content__body-container">

                    <div class="content__modal-body-form-1">

                        <label for="" class="content__modal-body-label">Tên sản phẩm: </label>
                        <input require type="text" name="tensanpham" id="" class="content__modal-body-input" placeholder="Nhập tên sản phẩm">

                        <label for="" class="content__modal-body-label">Đơn giá: </label>
                        <input require type="number" name="dongia" id="" min="1" class="content__modal-body-input" placeholder="Nhập đơn giá">

                        <label for="" class="content__modal-body-label">Mô tả: </label>
                        <input require type="text" name="mota" id="" class="content__modal-body-input" placeholder="Nhập mô tả">

                        <br>

                        <label for="" class="content__modal-body-label">Trạng thái: </label>
                        <select class="content__modal-body-select" name="trangthai" id="">
                            <option value="1">Còn bán</option>
                            <option value="0">Hết hàng</option>
                        </select>

                        <label for="" class="content__modal-body-label">Nhà cung cấp: </label>
                        <select class="content__modal-body-select" name="idNhaCungCap" id="">
                            <?php

                            $sql_nhacungcap = "SELECT * FROM nhacungcap";
                            $result_nhacungcap = mysqli_query($conn, $sql_nhacungcap);

                            while ($row_nhacungcap = mysqli_fetch_array($result_nhacungcap)) {

                            ?>
                                <Option value="<?php echo $row_nhacungcap["idNhaCungCap"] ?>"><?php echo $row_nhacungcap["tennhacungcap"] ?></Option>

                            <?php } ?>
                        </select>

                        <label for="" class="content__modal-body-label">Danh mục sản phẩm: </label>
                        <select class="content__modal-body-select" name="idDanhMuc" id="">
                            <?php

                            $sql_danhmucsanpham = "SELECT * FROM danhmucsanpham";
                            $result_danhmucsanpham = mysqli_query($conn, $sql_danhmucsanpham);

                            while ($row_danhmucsanpham = mysqli_fetch_array($result_danhmucsanpham)) {

                            ?>
                                <Option value="<?php echo $row_danhmucsanpham["idDanhMuc"] ?>"><?php echo $row_danhmucsanpham["tendanhmuc"] ?></Option>

                            <?php } ?>
                        </select>
                    </div>

                    <div class="content__modal-body-form-2">
                        <label for="" class="content__modal-body-label">Số lượng sản phẩm: </label>
                        <input require type="number" name="soluongconlai" min="1" id="" class="content__modal-body-input" placeholder="Nhập số lượng sản phẩm">

                        <br>

                        <label for="" class="content__modal-body-label">Hình ảnh sản phẩm: </label>
                        <input require type="file" name="urlhinhanh" id="" class="content__modal-body-input"><!-- Chọn một ảnh -->

                        <label for="" class="content__modal-body-label">Nhiều hình ảnh sản phẩm: </label>
                        <input require type="file" name="hinhanhurl[]" id="" class="content__modal-body-input" multiple> <!-- Chọn nhiều ảnh -->


                        <br>
                        <br>
                        <br>

                        <label for="" class="content__modal-body-label">Kích thước sản phẩm: </label>
                        <select class="content__modal-body-select" name="idKichThuoc" id="">
                            <?php

                            $sql_kichthuocsanpham = "SELECT * FROM kichthuocsanpham";
                            $result_kichthuocsanpham = mysqli_query($conn, $sql_kichthuocsanpham);

                            while ($row_kichthuocsanpham = mysqli_fetch_array($result_kichthuocsanpham)) {

                            ?>
                                <Option value="<?php echo $row_kichthuocsanpham["idKichThuoc"] ?>"><?php echo $row_kichthuocsanpham["kichthuoc"] ?></Option>

                            <?php } ?>
                        </select>

                        <label for="" class="content__modal-body-label">Màu sắc sản phẩm: </label>
                        <select class="content__modal-body-select" name="idMauSac" id="">
                            <?php

                            $sql_mausacsanpham = "SELECT * FROM mausacsanpham";
                            $result_mausacsanpham = mysqli_query($conn, $sql_mausacsanpham);

                            while ($row_mausacsanpham = mysqli_fetch_array($result_mausacsanpham)) {

                            ?>
                                <Option value="<?php echo $row_mausacsanpham["idMauSac"] ?>"><p style="color: red;"><?php echo $row_mausacsanpham["mausac"] ?></p></Option>

                            <?php } ?>
                        </select>
                    </div>
                </div>

                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Thêm sản phẩm">
            </form>
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div>

<!-- Modal xem -->
<div id="productDetailsModal" class="content__modal js-product__modal-watch">
    <div class="content__modal-container js-product__modal-container-watch">

        <div class="content__modal-close js-product__modal-close-watch">
            <i class="fa-solid fa-xmark product__modal-icon-close"></i>
        </div>

        <div class="content__modal-header">
            <h2 class="content__modal-header-text-heading">
                <i class="fa-solid fa-basketball content__modal-header-text-heading-icon"></i>
                Thông tin chi tiết của sản phẩm
            </h2>
        </div>

        <div class="content__modal-body" id="product-details">
            // Hiện thông tin
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/footer.php");
?>