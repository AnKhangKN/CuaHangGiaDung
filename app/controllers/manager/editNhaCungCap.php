<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNhaCungCap = $_POST['idNhaCungCap'] ?? null;
}

$sql_nhacungcap = "SELECT * FROM nhacungcap WHERE idNhaCungCap = ?";

$stmt_nhacungcap = $conn->prepare($sql_nhacungcap);
$stmt_nhacungcap->bind_param("i", $idNhaCungCap);
$stmt_nhacungcap->execute();
$result_nhacungcap = $stmt_nhacungcap->get_result();

$row_nhacungcap = $result_nhacungcap->fetch_assoc();

if (isset($_POST["product__sumit"])) {

    $tennhacungcap = test_input($_POST["tennhacungcap"]);
    $email = test_input($_POST["email"]);
    $sdt = test_input($_POST["sdt"]);
    $diachi = test_input($_POST["diachi"]);
    $trangthai = test_input($_POST["trangthai"]);
    $ghichu = test_input($_POST["ghichu"]);

    try {

        $sql_update_nhacungcap = "UPDATE nhacungcap SET tennhacungcap = ?, email = ?, sdt = ?, diachi = ?, trangthai = ?, ghichu = ? WHERE idNhaCungCap = ?";
        $stmt_update_nhacungcap = $conn->prepare($sql_update_nhacungcap);
        $stmt_update_nhacungcap->bind_param("ssssisi", $tennhacungcap, $email, $sdt, $diachi, $trangthai, $ghichu, $idNhaCungCap);
        $stmt_update_nhacungcap->execute();

        echo "<script>
            alert('Sửa nhà cung cấp thành công.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=nhacungcap';
            </script>";
    } catch (Exception $e) {
        echo "<script>
            alert('Không thể sửa nhà cung cấp này.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=nhacungcap';
            </script>";
    }
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
                            Sửa thông tin nhà cung cấp: <p style="color: red; display: inline;"><?php echo $row_nhacungcap["tennhacungcap"] ?></p>
                        </h2>
                        <hr class="content__header-namepage-bottom-line">
                    </div>
                    <div>
                    </div>

                    <div class="content__body">
                        <div class="content__body-container">
                            <form action="/CuaHangGiaDung/app/controllers/manager/editNhaCungCap.php" class="content__modal-body-form" method="POST">

                                <input type="hidden" name="idNhaCungCap" value="<?php echo $idNhaCungCap; ?>">

                                <label for="" class="content__modal-body-label">Tên nhà cung cấp: </label>
                                <input type="text" name="tennhacungcap" id="" class="content__modal-body-input" placeholder="Nhập tên nhà cung cấp" value="<?php echo $row_nhacungcap["tennhacungcap"] ?>">

                                <label for="" class="content__modal-body-label">Email: </label>
                                <input type="email" name="email" id="" class="content__modal-body-input" placeholder="Nhập email" value="<?php echo $row_nhacungcap["email"] ?>">

                                <label for="" class="content__modal-body-label">Số điện thoại: </label>
                                <input type="text" name="sdt" id="" class="content__modal-body-input" placeholder="Nhập số điện thoại" value="<?php echo $row_nhacungcap["sdt"] ?>">

                                <label for="" class="content__modal-body-label">Địa chỉ: </label>
                                <input type="text" name="diachi" id="" class="content__modal-body-input" placeholder="Nhập địa chỉ" value="<?php echo $row_nhacungcap["diachi"] ?>">

                                <label for="" class="content__modal-body-label">Trạng thái: </label>
                                <select class="content__modal-body-select" name="trangthai" id="">
                                    <option value="1" <?php echo ($row_nhacungcap["trangthai"] == 1) ? 'selected' : '' ?>>còn hợp tác</option>
                                    <option value="0" <?php echo ($row_nhacungcap["trangthai"] == 0) ? 'selected' : '' ?>>không còn hợp tác</option>
                                </select>

                                <label for="" class="content__modal-body-label">Ghi chu: </label>
                                <textarea name="ghichu" class="content__modal-body-input" id=""><?php echo $row_nhacungcap["ghichu"] ?></textarea>
                                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Lưu nhà cung cấp đã sửa">
                            </form>
                        </div>

                    </div>
                    <div>
                    </div>




                    <script src="/CuaHangGiaDung/app/views/manager/assets/js/main.js"></script>
</body>

</html>