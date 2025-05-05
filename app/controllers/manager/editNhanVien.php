<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNhanVien = $_POST['idNhanVien'] ?? null;
    $idTaiKhoan = $_POST['idTaiKhoan'] ?? null;
}

$sql_nv_tk = "SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan 
    WHERE nv.idNhanVien = ? AND tk.idTaiKhoan = ?";

$stmt_nv_tk = $conn->prepare($sql_nv_tk);
$stmt_nv_tk->bind_param("ii", $idNhanVien, $idTaiKhoan);
$stmt_nv_tk->execute();
$result_nv_tk = $stmt_nv_tk->get_result();

$row_nv_tk = $result_nv_tk->fetch_assoc();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["product__sumit"])) {
    $tennhanvien = test_input($_POST["tennhanvien"]);
    $sdt = test_input($_POST["sdt"]);
    $cccd = test_input($_POST["cccd"]);
    $luong = test_input($_POST["luong"]);
    $thuong = test_input($_POST["thuong"]);

    $trangthai = $_POST["trangthai"];

    // email matkhau quyen
    $email = test_input($_POST["email"]);

    $quyen = $_POST["quyen"];

    // Bắt đầu giao dịch
    $conn->begin_transaction();
    try {

        $stmt1 = $conn->prepare("UPDATE nhanvien SET tennhanvien = ?, sdt = ?, cccd = ?, luong = ?, thuong = ?, trangthai = ? WHERE idNhanVien = ?");
        $stmt1->bind_param("sssddii", $tennhanvien, $sdt, $cccd, $luong, $thuong, $trangthai, $idNhanVien);
        $stmt1->execute();

        $stmt2 = $conn->prepare("UPDATE taikhoan SET quyen = ? WHERE idTaiKhoan = ?");
        $stmt2->bind_param("ii", $quyen, $idTaiKhoan);
        $stmt2->execute();

        // Xác nhận giao dịch
        $conn->commit();

        echo "<script>
            alert('Sửa nhân viên thành công.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=nhanvien';
            </script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>
            alert('Không thể sửa nhân viên này.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=nhanvien';
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
                            Sửa thông tin nhân viên: <p style="color: red; display: inline;"><?php echo $row_nv_tk["tennhanvien"] ?></p>
                        </h2>
                        <hr class="content__header-namepage-bottom-line">
                    </div>
                    <div>
                    </div>

                    <div class="content__body">
                        <div class="content__body-container">
                            <form action="/CuaHangGiaDung/app/controllers/manager/editNhanVien.php" class="content__modal-body-form" method="POST">

                                <input type="hidden" name="idNhanVien" value="<?php echo $idNhanVien; ?>">
                                <input type="hidden" name="idTaiKhoan" value="<?php echo $idTaiKhoan; ?>">

                                <div class="content__body-container">

                                    <div class="content__modal-body-form-1">

                                        <label for="" class="content__modal-body-label">Tên nhân viên: </label>
                                        <input type="text" name="tennhanvien" id="" class="content__modal-body-input" value="<?php echo $row_nv_tk["tennhanvien"] ?>" placeholder="Nhập tên nhân viên">

                                        <label for="" class="content__modal-body-label">Số điện thoại: </label>
                                        <input type="text" name="sdt" id="" class="content__modal-body-input" value="<?php echo $row_nv_tk["sdt"] ?>" placeholder="Nhập số điện thoại">

                                        <label for="" class="content__modal-body-label">Căn cước công dân: </label>
                                        <input type="text" name="cccd" id="" class="content__modal-body-input" value="<?php echo $row_nv_tk["cccd"] ?>" placeholder="Nhập căn cước công dân">

                                        <label for="" class="content__modal-body-label">Lương: </label>
                                        <input type="number" name="luong" id="" class="content__modal-body-input" value="<?php echo $row_nv_tk["luong"] ?>" placeholder="Nhập lương">

                                        <label for="" class="content__modal-body-label">Thưởng: </label>
                                        <input type="number" name="thuong" id="" class="content__modal-body-input" value="<?php echo $row_nv_tk["thuong"] ?>" placeholder="Nhập thưởng">
                                        <br>

                                        <label for="" class="content__modal-body-label">Trạng thái: </label>
                                        <select class="content__modal-body-select" name="trangthai" id="">
                                            <option value="1" <?php echo ($row_nv_tk["trangthai"] == 1) ? 'selected' : '' ?>>Còn làm việc</option>
                                            <option value="0" <?php echo ($row_nv_tk["trangthai"] == 0) ? 'selected' : '' ?>>Ngừng làm việc</option>
                                        </select>

                                        <label for="" class="content__modal-body-label">Quyền: </label>
                                        <select class="content__modal-body-select" name="quyen" id="">
                                            <option value="1" <?php echo ($row_nv_tk["quyen"] == 1) ? 'selected' : '' ?>>Quản lý</option>
                                            <option value="2" <?php echo ($row_nv_tk["quyen"] == 2) ? 'selected' : '' ?>>Nhân viên</option>
                                        </select>

                                    </div>

                                    <div class="content__modal-body-form-2">
                                        

                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>



                                    </div>
                                </div>

                                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Lưu nhân viên đã sửa">
                            </form>
                        </div>

                    </div>
                    <div>
                    </div>
                </div>




                <script src="/CuaHangGiaDung/app/views/manager/assets/js/main.js"></script>
</body>

</html>