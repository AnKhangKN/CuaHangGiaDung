<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSanPham = $_POST['idSanPham'] ?? null;
    $idChiTietSanPham = $_POST['idChiTietSanPham'] ?? null;
}

$sql_sp_ctsp = "SELECT * FROM sanpham sp JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
                    WHERE sp.idSanPham = ? AND ctsp.idChiTietSanPham = ?";

$stmt_sp_ctsp = $conn->prepare($sql_sp_ctsp);
$stmt_sp_ctsp->bind_param("ii", $idSanPham, $idChiTietSanPham);
$stmt_sp_ctsp->execute();
$result_sp_ctsp = $stmt_sp_ctsp->get_result();

$row_sp_ctsp = $result_sp_ctsp->fetch_assoc();

$selected_nhacungcap = $row_sp_ctsp["idNhaCungCap"];
$selected_danhmucsanpham = $row_sp_ctsp["idDanhMuc"];
$selected_kichthuoc = $row_sp_ctsp["idKichThuoc"];
$selected_mausac = $row_sp_ctsp["idMauSac"];

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

        $stmt1 = $conn->prepare("UPDATE sanpham SET tensanpham = ?, dongia = ?, mota = ?, trangthai = ?, idNhaCungCap = ?, idDanhMuc = ? WHERE idSanPham = ?");
        $stmt1->bind_param("sisiiii", $tensanpham, $dongia, $mota, $trangthai, $idNhaCungCap, $idDanhMuc, $idSanPham);
        $stmt1->execute();

        $stmt2 = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ?, idKichThuoc = ?, idMauSac = ? WHERE idChiTietSanPham = ?");
        $stmt2->bind_param("iiii", $soluongconlai, $idKichThuoc, $idMauSac, $idChiTietSanPham);
        $stmt2->execute();

        // Commit giao dịch
        $conn->commit();

        $sql_hinhanhsp = "SELECT * FROM sanpham sp,chitietsanpham ctsp, hinhanhsanpham hasp 
                        WHERE sp.idSanPham = hasp.idSanPham 
                        AND sp.idSanPham = ctsp.idSanPham 
                        AND sp.idSanPham = ? 
                        AND ctsp.idChiTietSanPham = ?";
        $stmt_hinhanhsp = $conn->prepare($sql_hinhanhsp);
        $stmt_hinhanhsp->bind_param("ii", $idSanPham, $idChiTietSanPham);
        $stmt_hinhanhsp->execute();
        $result_hinhanhsp = $stmt_hinhanhsp->get_result();


        if ($result_hinhanhsp->num_rows > 0) {
            $stmt3 = $conn->prepare("UPDATE hinhanhsanpham SET urlhinhanh = ? WHERE idSanPham = ? AND $idChiTietSanPham");
            $stmt3->bind_param("si", $image, $idSanPham);
            $stmt3->execute();

            // Đoạn mã xử lý phần thêm nhiều ảnh
            $image_path = 'C:/xampp/htdocs/CuaHangGiaDung/public/assets/images/products/';
            if (isset($_FILES['hinhanhurl']) && !empty($_FILES['hinhanhurl']['name'][0])) {
                foreach ($_FILES['hinhanhurl']['name'] as $key => $image_name) {
                    if ($_FILES['hinhanhurl']['error'][$key] === UPLOAD_ERR_OK) {
                        $image_tmp_name = $_FILES['hinhanhurl']['tmp_name'][$key];
                        $final_image_path = $image_path . basename($image_name);

                        if (move_uploaded_file($image_tmp_name, $final_image_path)) {
                            $stmt = $conn->prepare("INSERT INTO hinhanhsanpham (urlhinhanh, idSanPham) VALUES (?, ?)");
                            $stmt->bind_param("si", $image_name, $idSanPham);
                            $stmt->execute();
                        } else {
                            echo "Không thể lưu tệp: " . $image_name;
                            $conn->rollback();
                            exit;
                        }
                    } else {
                        echo "Lỗi tải tệp: " . $_FILES['hinhanhurl']['error'][$key];
                    }
                }
            } else {
                echo "<script>
                alert('Vui lòng chọn ít nhất 1 ảnh');
                window.location.href = '/CuaHangGiaDung/app/controllers/manager/editSanPham.php';
                </script>";
            }

            move_uploaded_file($image_tmp_name, 'C:/xampp/htdocs/CuaHangGiaDung/public/assets/images/product/' . $image);
        } else {
            $stmt4 = $conn->prepare("INSERT INTO hinhanhsanpham (urlhinhanh, idSanPham) VALUES (?, ?)");
            $stmt4->bind_param("si", $image, $idSanPham);
            $stmt4->execute();

            // Đoạn mã xử lý phần thêm nhiều ảnh
            $image_path = 'C:/xampp/htdocs/CuaHangGiaDung/public/assets/images/products/';
            if (isset($_FILES['hinhanhurl']) && !empty($_FILES['hinhanhurl']['name'][0])) {
                foreach ($_FILES['hinhanhurl']['name'] as $key => $image_name) {
                    if ($_FILES['hinhanhurl']['error'][$key] === UPLOAD_ERR_OK) {
                        $image_tmp_name = $_FILES['hinhanhurl']['tmp_name'][$key];
                        $final_image_path = $image_path . basename($image_name);

                        if (move_uploaded_file($image_tmp_name, $final_image_path)) {
                            $stmt = $conn->prepare("INSERT INTO hinhanhsanpham (urlhinhanh, idSanPham) VALUES (?, ?)");
                            $stmt->bind_param("si", $image_name, $idSanPham);
                            $stmt->execute();
                        } else {
                            echo "Không thể lưu tệp: " . $image_name;
                            $conn->rollback();
                            exit;
                        }
                    } else {
                        echo "Lỗi tải tệp: " . $_FILES['hinhanhurl']['error'][$key];
                    }
                }
            } else {
                echo "<script>
                alert('Vui lòng chọn ít nhất 1 ảnh');
                window.location.href = '/CuaHangGiaDung/app/controllers/manager/editSanPham.php';
                </script>";
            }
            move_uploaded_file($image_tmp_name, 'C:/xampp/htdocs/CuaHangGiaDung/public/assets/images/product/' . $image);
        }
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();
        echo "<script>
            alert('Không thể sửa sản phẩm này.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=sanpham';
            </script>";
    }

    echo "<script>
            alert('Sửa sản phẩm thành công.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=sanpham';
            </script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HKN store</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="/CuaHangGiaDung/public/assets/images/logo_trang.jpg">
    <link rel="stylesheet" href="/CuaHangGiaDung/app/views/manager/assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/CuaHangGiaDung/vendor/fontawesome-free-6.6.0-web/css/all.css">
</head>

<body id="body">
    <div class="l-navbar" id="navbar">
        <div class="nav">
            <div>
                <a href="/CuaHangGiaDung/public/manager/index.php" class="nav__logo">
                    <img src="/CuaHangGiaDung/public/assets/images/logo_trang.jpg" alt="" class="nav__logo-icon">
                    <span class="nav__logo-text">HKN store</span>
                </a>

                <ul class="nav__list">

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=sanpham" class="nav__link">
                        <i class='fa-solid fa-basketball nav__icon'></i>
                        <span class="nav__text">Sản phẩm</span>
                    </a>

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=danhmuc" class="nav__link">
                        <i class='fa-solid fa-list nav__icon'></i>
                        <span class="nav__text">DM sản phẩm</span>
                    </a>

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=nhanvien" class="nav__link">
                        <i class='fa-regular fa-user nav__icon'></i>
                        <span class="nav__text">Nhân viên</span>
                    </a>

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=khachhang" class="nav__link">
                        <i class='fa-solid fa-person nav__icon'></i>
                        <span class="nav__text">Khách hàng</span>
                    </a>

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=nhacungcap" class="nav__link">
                        <i class="fa-solid fa-house nav__icon"></i>
                        <span class="nav__text">Nhà cung cấp</span>
                    </a>

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=donhang" class="nav__link">
                        <i class='fa-solid fa-box nav__icon'></i>
                        <span class="nav__text">Đơn hàng</span>
                    </a>

                    <a href="/CuaHangGiaDung/public/manager/index.php?page=thongke" class="nav__link">
                        <i class='fa-solid fa-chart-pie nav__icon'></i>
                        <span class="nav__text">Thống kê</span>
                    </a>
                </ul>
            </div>

            <a href="/CuaHangGiaDung/public/manager/index.php?page=dangxuat" class="nav__link">
                <i class='fa-solid fa-right-from-bracket nav__icon'></i>
                <span class="nav__text">Đăng xuất</span>
            </a>
        </div>
    </div>

    <div id="main">
        <div id="header">
            <div class="header__bar" id="bar-icon">
                <i class="fa-solid fa-bars header__bar-icon"></i>
            </div>

            <div class="header__home">
                <a href="/CuaHangGiaDung/public/manager/index.php">
                    <h3>Trang chủ</h3>
                </a>
            </div>

            <!-- <div class="header__left">
                <div class="header__search" id="header-search">
                    <input id="search" type="text" class="header__search-input">
                    <label for="search" class="header__search-label">
                        <i class="fa-solid fa-magnifying-glass header__search-icon"></i>
                    </label>
                </div>
    
                <div class="header__bell">
                    <i class="fa-solid fa-bell header__bell-icon"></i>
                </div>
            </div> -->

        </div>

        <div id="content">
            <div class="content__section">
                <div class="content__header">
                    <div class="content__header-namepage">
                        <h2 class="content__header-namepage-text">
                            Sửa thông tin sản phẩm: <p style="color: red; display: inline;"><?php echo $row_sp_ctsp["tensanpham"] ?></p>
                        </h2>
                        <hr class="content__header-namepage-bottom-line">
                    </div>
                    <div>
                    </div>

                    <div class="content__body">

                        <form action="/CuaHangGiaDung/app/controllers/manager/editSanPham.php" method="POST" class="content__body-from" enctype="multipart/form-data">

                            <input type="hidden" name="idSanPham" value="<?php echo $idSanPham; ?>">
                            <input type="hidden" name="idChiTietSanPham" value="<?php echo $idChiTietSanPham; ?>">

                            <div class="content__body-container">

                                <div class="content__modal-body-form-1">

                                    <label for="" class="content__modal-body-label">Tên sản phẩm: </label>

                                    <input require type="text" name="tensanpham" id="" class="content__modal-body-input" value="<?php echo $row_sp_ctsp["tensanpham"] ?>" placeholder="Nhập tên sản phẩm">

                                    <label for="" class="content__modal-body-label">Đơn giá: </label>
                                    <input require type="text" name="dongia" id="" class="content__modal-body-input" value="<?php echo $row_sp_ctsp["dongia"] ?>" placeholder="Nhập đơn giá">

                                    <label for="" class="content__modal-body-label">Mô tả: </label>
                                    <input require type="text" name="mota" id="" class="content__modal-body-input" value="<?php echo $row_sp_ctsp["mota"] ?>" placeholder="Nhập mô tả">

                                    <br>

                                    <label for="" class="content__modal-body-label">Trạng thái: </label>
                                    <select class="content__modal-body-select" name="trangthai" id="">
                                        <option value="1" <?php echo ($row_sp_ctsp["trangthai"] == 1) ? 'selected' : '' ?>>Còn bán</option>
                                        <option value="0" <?php echo ($row_sp_ctsp["trangthai"] == 0) ? 'selected' : '' ?>>Hết hàng</option>

                                    </select>

                                    <label for="" class="content__modal-body-label">Nhà cung cấp: </label>
                                    <select class="content__modal-body-select" name="idNhaCungCap" id="">
                                        <?php

                                        $sql_nhacungcap = "SELECT * FROM nhacungcap";
                                        $result_nhacungcap = mysqli_query($conn, $sql_nhacungcap);

                                        while ($row_nhacungcap = mysqli_fetch_array($result_nhacungcap)) {

                                        ?>

                                            <Option value="<?php echo $row_nhacungcap["idNhaCungCap"] ?>"
                                                <?php echo ($row_nhacungcap["idNhaCungCap"] == $selected_nhacungcap) ? 'selected' : ''; ?>>
                                                <?php echo $row_nhacungcap["tennhacungcap"] ?>
                                            </Option>

                                        <?php } ?>
                                    </select>

                                    <label for="" class="content__modal-body-label">Danh mục sản phẩm: </label>
                                    <select class="content__modal-body-select" name="idDanhMuc" id="">
                                        <?php

                                        $sql_danhmucsanpham = "SELECT * FROM danhmucsanpham";
                                        $result_danhmucsanpham = mysqli_query($conn, $sql_danhmucsanpham);

                                        while ($row_danhmucsanpham = mysqli_fetch_array($result_danhmucsanpham)) {

                                        ?>
                                            <Option value="<?php echo $row_danhmucsanpham["idDanhMuc"] ?>"
                                                <?php echo ($row_danhmucsanpham["idDanhMuc"] == $selected_danhmucsanpham) ? 'selected' : ''; ?>>

                                                <?php echo $row_danhmucsanpham["tendanhmuc"] ?>

                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="content__modal-body-form-2">
                                    <label for="" class="content__modal-body-label">Số lượng sản phẩm: </label>
                                    <input require type="number" name="soluongconlai" id="" class="content__modal-body-input" value="<?php echo $row_sp_ctsp["soluongconlai"] ?>" placeholder="Nhập số lượng sản phẩm">

                                    <br>
                                    <br>
                                    <br>

                                    <?php
                                    $sql_hinhanhsp = "SELECT * FROM sanpham sp JOIN hinhanhsanpham hasp ON sp.idSanPham = hasp.idSanPham WHERE sp.idSanPham = ?";
                                    $stmt_hinhanhsp = $conn->prepare($sql_hinhanhsp);
                                    $stmt_hinhanhsp->bind_param("i", $idSanPham);
                                    $stmt_hinhanhsp->execute();
                                    $result_hinhanhsp = $stmt_hinhanhsp->get_result();
                                    $row__hinhanhsp = $result_hinhanhsp->fetch_assoc();
                                    ?>

                                    <label for="" class="content__modal-body-label">Hình ảnh sản phẩm: </label>
                                    <img class="content__body-td-img" width="40" height="50" src="http://localhost/CuaHangGiaDung/public/assets/images/products/<?php echo $row__hinhanhsp["urlhinhanh"]; ?>" alt="Hinh anh san pham">
                                    <input require type="file" name="urlhinhanh" id="" class="">


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
                                            <Option value="<?php echo $row_kichthuocsanpham["idKichThuoc"] ?>"
                                                <?php echo ($row_kichthuocsanpham["idKichThuoc"] == $selected_kichthuoc) ? 'selected' : ''; ?>>
                                                <?php echo $row_kichthuocsanpham["kichthuoc"] ?>
                                            </Option>

                                        <?php } ?>
                                    </select>

                                    <label for="" class="content__modal-body-label">Màu sắc sản phẩm: </label>
                                    <select class="content__modal-body-select" name="idMauSac" id="">
                                        <?php

                                        $sql_mausacsanpham = "SELECT * FROM mausacsanpham";
                                        $result_mausacsanpham = mysqli_query($conn, $sql_mausacsanpham);

                                        while ($row_mausacsanpham = mysqli_fetch_array($result_mausacsanpham)) {

                                        ?>
                                            <Option value="<?php echo $row_mausacsanpham["idMauSac"] ?>"
                                                <?php echo ($row_mausacsanpham["idMauSac"] == $selected_mausac) ? 'selected' : ''; ?>>
                                                <?php echo $row_mausacsanpham["mausac"] ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="content__modal-body-form-3">
                                    <?php

                                    // Lưu tất cả URL ảnh vào mảng
                                    $images = [];
                                    while ($row__hinhanhsp = $result_hinhanhsp->fetch_assoc()) {
                                        $images[] = $row__hinhanhsp['urlhinhanh'];
                                    }
                                    ?>
                                    <label for="" class="content__modal-body-label">Hình ảnh sản phẩm: </label>
                                    <input require type="file" name="hinhanhurl[]" id="" class="" multiple> <!-- Chọn nhiều ảnh -->
                                    <div class="content__modal-body-image-gallery">
                                        <?php foreach ($images as $image): ?>
                                            <img class="content__modal-body-image-gallery_item" src="http://localhost/CuaHangGiaDung/public/assets/images/products/<?php echo htmlspecialchars($image); ?>" alt="Hình ảnh sản phẩm">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Lưu sản phẩm đã sửa">
                        </form>
                    </div>
                    <div>
                    </div>




                    <script src="/CuaHangGiaDung/app/views/manager/assets/js/main.js"></script>

</body>

</html>