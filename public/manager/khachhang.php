<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// tenkhachhang sdt diachi loaikhachhang trangthaithongtin idTaiKhoan
if (isset($_POST["product__sumit"])) {
    $tenkhachhang = test_input($_POST["tenkhachhang"]);
    $sdt = test_input($_POST["sdt"]);
    $diachi = test_input($_POST["diachi"]);

    $loaikhachhang = $_POST["loaikhachhang"];
    $trangthaithongtin = $_POST["trangthaithongtin"];
    $idTaiKhoan = $_POST["idTaiKhoan"];

    $email = test_input($_POST["email"]);
    $matkhau = password_hash($_POST["matkhau"], PASSWORD_DEFAULT);


    // Bắt đầu giao dịch
    $conn->begin_transaction();
    try {
        // Thêm tài khoản vào bảng taikhoan
        $sqlTaiKhoan = "INSERT INTO taikhoan (email, matkhau, quyen, ngaytao) VALUES (?, ?, 0, NOW())";
        $stmtTaiKhoan = $conn->prepare($sqlTaiKhoan);
        $stmtTaiKhoan->bind_param("ss", $email, $matkhau);
        $stmtTaiKhoan->execute();

        // Lấy idTaiKhoan vừa được tạo
        $idTaiKhoan = $conn->insert_id;

        // Thêm thông tin vào bảng khachhang
        $sqlKhachHang = "INSERT INTO khachhang (tenkhachhang, sdt, diachi, loaikhachhang, trangthaithongtin, idTaiKhoan) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtKhachHang = $conn->prepare($sqlKhachHang);
        $stmtKhachHang->bind_param("sssiii", $tenkhachhang, $sdt, $diachi, $loaikhachhang, $trangthaithongtin, $idTaiKhoan);
        $stmtKhachHang->execute();

        // Xác nhận giao dịch
        $conn->commit();

        echo "<script>
            alert('Thêm khách thành công.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=khachhang';
            </script>";
    } catch (Exception $e) {
        // Hủy giao dịch nếu có lỗi
        $conn->rollback();
        echo "<script>
            alert('Lỗi thêm khách.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=khachhang';
            </script>";
    }
}

$search_khachhang = isset($_GET["search_khachhang"]) ? $_GET["search_khachhang"] : "";

$item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 4;
$current_page = !empty($_GET["pages"]) ? $_GET["pages"] : 1;
$offset = ($current_page - 1) * $item_per_page;

if ($search_khachhang) {
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/header.php");
    $sql_khachhang = "SELECT * FROM khachhang kh JOIN taikhoan tk ON kh.idTaiKhoan = tk.idTaiKhoan
                    WHERE kh.tenkhachhang LIKE '%" . $search_khachhang . "%' 
                    OR kh.sdt LIKE '%" . $search_khachhang . "%' 
                    OR tk.email LIKE '%" . $search_khachhang . "%' 
                    ORDER BY kh.idKhachHang ASC LIMIT $item_per_page OFFSET $offset";
    $result_khachhang = mysqli_query($conn, $sql_khachhang);
    $totalRecords = mysqli_query($conn, "SELECT * FROM khachhang kh JOIN taikhoan tk ON kh.idTaiKhoan = tk.idTaiKhoan 
                                        WHERE kh.tenkhachhang LIKE '%" . $search_khachhang . "%' 
                                        OR kh.sdt LIKE '%" . $search_khachhang . "%' 
                                        OR tk.email LIKE '%" . $search_khachhang . "%'");
} else {
    $sql_khachhang = "SELECT * FROM khachhang kh JOIN taikhoan tk ON kh.idTaiKhoan = tk.idTaiKhoan ORDER BY kh.idKhachHang ASC LIMIT $item_per_page OFFSET $offset";
    $result_khachhang = mysqli_query($conn, $sql_khachhang);
    $totalRecords = mysqli_query($conn, "SELECT * FROM khachhang kh JOIN taikhoan tk ON kh.idTaiKhoan = tk.idTaiKhoan");
}


$totalNumber = $totalRecords->num_rows;
$totalPages = ceil($totalNumber / $item_per_page);


?>

<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Quản lý khách hàng
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>

            <!-- <button class="content__header-btn js-product__header-btn">
                Thêm khách hàng
            </button> -->

            <form action="/CuaHangGiaDung/public/manager/khachhang.php" class="content__header-form-search">
                <input type="text" name="search_khachhang" required class="content__header-form-search-text" placeholder="Tìm kiếm tên, sdt, email khách hàng">

                <button type="submit" class="content__header-form-search-submit">
                    Tìm kiếm
                    <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                </button>
            </form>
        </div>

        <div class="content__body">
            <h2 class="content__body-heading-text">Danh sách khách hàng</h2>


            <table class="content__body-table" cellspacing="0">
                <thead class="content__body-thead">
                    <tr class="content__body-tr">
                        <th class="content__body-th">ID</th>
                        <th class="content__body-th">Tên khách hàng</th>
                        <th class="content__body-th">SDT</th>
                        <th class="content__body-th">Địa chỉ</th>
                        <th class="content__body-th">Loại khách hàng</th>
                        <th class="content__body-th">Trạng thái thông tin</th>
                        <th class="content__body-th">Email</th>
                        <th class="content__body-th">Chức năng</th>
                    </tr>
                </thead>

                <tbody class="content__body-tbody">

                    <?php

                    if ($result_khachhang->num_rows > 0) {
                        while ($row_khachhang = mysqli_fetch_assoc($result_khachhang)) {
                    ?>

                            <tr class="content__body-tr">
                                <td class="content__body-td"><?php echo $row_khachhang["idKhachHang"] ?></td>
                                <td class="content__body-td"><?php echo $row_khachhang["tenkhachhang"] ?></td>
                                <td class="content__body-td"><?php echo $row_khachhang["sdt"] ?></td>
                                <td class="content__body-td"><?php echo $row_khachhang["diachi"] ?></td>
                                <td class="content__body-td">
                                    <?php
                                    if ($row_khachhang["loaikhachhang"] == 1) {
                                        echo "uy tín";
                                    } else if ($row_khachhang["loaikhachhang"] == 0) {
                                        echo "không uy tín";
                                    }
                                    ?>
                                </td>
                                <td class="content__body-td">
                                    <?php
                                    if ($row_khachhang["trangthaithongtin"] == 1) {
                                        echo "có thông tin";
                                    } else if ($row_khachhang["trangthaithongtin"] == 0) {
                                        echo "thiếu thông tin";
                                    }
                                    ?>
                                </td>
                                <td class="content__body-td"><?php echo $row_khachhang["email"]?></td>
                                <td class="content__body-td">
                                <!-- <button class="content__body-td__btn-see view-details js_content__body-td__btn-see" data-id="<?php echo $row_khachhang['idKhachHang'] ?>">xem</button> -->

                                    <form action="/CuaHangGiaDung/app/controllers/manager/editKhachHang.php" class="content__body-td-form" method="POST">
                                        <input type="hidden" name="idKhachHang" value="<?php echo $row_khachhang["idKhachHang"] ?>">
                                        <input type="hidden" name="idTaiKhoan" value="<?php echo $row_khachhang["idTaiKhoan"] ?>">
                                        <input type="submit" class="content__body-td__btn-edit" value="sửa">
                                    </form>
                                </td>
                            </tr>

                    <?php }
                    } else {
                        echo "  <tr class='content__body-tr'>
                        <td class='content__body-td' colspan='8'>Không có khách hàng nào.</td>
                    </tr>";
                    } ?>
                </tbody>
            </table>

            <?php include $_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/controllers/manager/paginationKhachHang.php" ?>

        </div>
    </div>
</div>
</div>

<!-- Modal Add -->
<!-- <div class="content__modal js-product__modal">
    <div class="content__modal-container js-product__modal-container">

        <div class="content__modal-close js-product__modal-close">
            <i class="fa-solid fa-xmark product__modal-icon-close"></i>
        </div>

        <div class="content__modal-header">
            <h2 class="content__modal-header-text-heading">
                <i class="fa-solid fa-person content__modal-header-text-heading-icon"></i>
                Thêm khách hàng
            </h2>
        </div>

        <div class="content__modal-body">
            <form action="khachhang.php" class="content__modal-body-form" method="POST">

                <div class="content__body-container">

                    <div class="content__modal-body-form-1">

                        <label for="" class="content__modal-body-label">Tên khách hàng: </label>
                        <input type="text" name="tenkhachhang" id="" class="content__modal-body-input" placeholder="Nhập tên khách hàng">

                        <label for="" class="content__modal-body-label">Số điện thoại: </label>
                        <input type="text" name="sdt" id="" class="content__modal-body-input" placeholder="Nhập số điện thoại">

                        <label for="" class="content__modal-body-label">Địa chỉ: </label>
                        <input type="text" name="diachi" id="" class="content__modal-body-input" placeholder="Nhập địa chỉ">

                        <label for="" class="content__modal-body-label">Loại khách hàng: </label>
                        <select class="content__modal-body-select" name="loaikhachhang" id="">
                            <option value="1">uy tín</option>
                            <option value="0">không uy tín</option>
                        </select>

                        <label for="" class="content__modal-body-label">Trạng thái thông tin: </label>
                        <select class="content__modal-body-select" name="trangthaithongtin" id="">
                            <option value="1">có thông tin</option>
                            <option value="0">thiếu thông tin</option>
                        </select>

                    </div>

                    <div class="content__modal-body-form-2">
                        <label for="" class="content__modal-body-label">Email: </label>
                        <input type="email" name="email" id="" class="content__modal-body-input" placeholder="Nhập email">

                        <label for="" class="content__modal-body-label">Mật khẩu: </label>
                        <input type="password" name="matkhau" id="" class="content__modal-body-input" placeholder="Nhập mật khẩu">

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>

                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Thêm khách hàng">
            </form>
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div> -->

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/footer.php");
?>