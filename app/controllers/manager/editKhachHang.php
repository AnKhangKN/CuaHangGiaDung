<?php

    include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/connect.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idKhachHang = $_POST['idKhachHang'] ?? null;
        $idTaiKhoan = $_POST['idTaiKhoan'] ?? null;
    }

    $sql_kh_tk = "SELECT * FROM khachhang kh JOIN taikhoan tk ON kh.idTaiKhoan = tk.idTaiKhoan 
                    WHERE kh.idKhachHang = ? AND tk.idTaiKhoan = ?";

    $stmt_kh_tk = $conn->prepare($sql_kh_tk);
    $stmt_kh_tk->bind_param("ii", $idKhachHang, $idTaiKhoan);
    $stmt_kh_tk->execute();
    $result_kh_tk = $stmt_kh_tk->get_result();

    $row_kh_tk = $result_kh_tk->fetch_assoc();

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST["product__sumit"])) {
        $tenkhachhang = test_input($_POST["tenkhachhang"]);
        $sdt = test_input($_POST["sdt"]);
        $diachi = test_input($_POST["diachi"]);

        $loaikhachhang = $_POST["loaikhachhang"];
        $trangthaithongtin = $_POST["trangthaithongtin"];

        $email = test_input($_POST["email"]);

        // Bắt đầu giao dịch
        $conn->begin_transaction();
        try {

            $stmt1 = $conn->prepare("UPDATE khachhang SET tenkhachhang = ?, sdt = ?, diachi = ?, loaikhachhang = ?, trangthaithongtin = ? WHERE idKhachHang = ?");
            $stmt1->bind_param("sssiii", $tenkhachhang, $sdt, $diachi, $loaikhachhang, $trangthaithongtin, $idKhachHang);
            $stmt1->execute();

            $stmt2 = $conn->prepare("UPDATE taikhoan SET email = ? WHERE idTaiKhoan = ?");
            $stmt2->bind_param("si", $email, $idTaiKhoan);
            $stmt2->execute();

            // Xác nhận giao dịch
            $conn->commit();
            header("location: /CHDDTTHKN/assets/view/QuanLy/index.php?page=khachhang");
        }

        catch (Exception $e) {
            $conn->rollback();
            echo "<script>
            alert('Không thể sửa thông tin khách hàng: " . $e->getMessage() . "');
            window.location.href = '/CHDDTTHKN/assets/view/QuanLy/index.php?page=khachhang';
            </script>";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin HKN store</title>
<link rel="icon" type="image/x-icon" href="/CHDDTTHKN/assets/img/logo.jpg">
<link rel="stylesheet" href="/CHDDTTHKN/assets/css/style.css">
<link rel="stylesheet" href="/CHDDTTHKN/assets/fonts/fontawesome-free-6.6.0-web/css/all.css">
</head>
<body id="body">
<div class="l-navbar" id="navbar">
        <div class="nav">
            <div>
                <a href="/CHDDTTHKN/assets/view/QuanLy/index.php" class="nav__logo">
                    <img src="/CHDDTTHKN/assets/img/logo.jpg" alt="" class="nav__logo-icon">
                    <span class="nav__logo-text">HKN store</span>
                </a>

                <ul class="nav__list">

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham" class="nav__link">
                        <i class='fa-solid fa-basketball nav__icon'></i>
                        <span class="nav__text">Sản phẩm</span>
                    </a>

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=danhmuc" class="nav__link">
                        <i class='fa-solid fa-list nav__icon'></i>
                        <span class="nav__text">DM sản phẩm</span>
                    </a>

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=nhanvien" class="nav__link">
                        <i class='fa-regular fa-user nav__icon'></i>
                        <span class="nav__text">Nhân viên</span>
                    </a>

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=khachhang" class="nav__link">
                        <i class='fa-solid fa-person nav__icon'></i>
                        <span class="nav__text">Khách hàng</span>
                    </a>

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=nhacungcap" class="nav__link">
                        <i class="fa-solid fa-house nav__icon"></i>
                        <span class="nav__text">Nhà cung cấp</span>
                    </a>

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=donhang" class="nav__link">
                        <i class='fa-solid fa-box nav__icon'></i>
                        <span class="nav__text">Đơn hàng</span>
                    </a>

                    <a href="/CHDDTTHKN/assets/view/QuanLy/index.php?page=thongke" class="nav__link">
                        <i class='fa-solid fa-chart-pie nav__icon'></i>
                        <span class="nav__text">Thống kê</span>
                    </a>
                </ul>
            </div>

            <a href="#" class="nav__link">
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
            <a href="index.php">
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
                        Sửa thông tin khách hàng
                    </h2>
                    <hr class="content__header-namepage-bottom-line">
                </div>
            <div>
        </div>
        
        <div class="content__body">
            <div class="content__body-container">
            <form action="/CHDDTTHKN/assets/controller/editKhachHang.php" class="content__modal-body-form" method="POST">

                <input type="hidden" name="idKhachHang" value="<?php echo $idKhachHang; ?>">
                <input type="hidden" name="idTaiKhoan" value="<?php echo $idTaiKhoan; ?>">
                
            <div class="content__body-container">
                    
                    <div class="content__modal-body-form-1">
    
                        <label for="" class="content__modal-body-label">Tên khách hàng: </label>
                        <input type="text" name="tenkhachhang" id="" class="content__modal-body-input" value="<?php echo $row_kh_tk["tenkhachhang"] ?>" placeholder="Nhập tên khách hàng">
    
                        <label for="" class="content__modal-body-label">Số điện thoại: </label>
                        <input type="text" name="sdt" id="" class="content__modal-body-input" value="<?php echo $row_kh_tk["sdt"] ?>" placeholder="Nhập số điện thoại">
    
                        <label for="" class="content__modal-body-label">Địa chỉ: </label>
                        <input type="text" name="diachi" id="" class="content__modal-body-input" value="<?php echo $row_kh_tk["diachi"] ?>" placeholder="Nhập địa chỉ">
                        
                        <label for="" class="content__modal-body-label">Loại khách hàng: </label>
                        <select class="content__modal-body-select" name="loaikhachhang" id="">
                            <option value="1" <?php echo ($row_kh_tk["loaikhachhang"] == 1) ? 'selected' : '' ?>>uy tín</option>
                            <option value="0" <?php echo ($row_kh_tk["loaikhachhang"] == 0) ? 'selected' : '' ?>>không uy tín</option>
                        </select>
    
                        <label for="" class="content__modal-body-label">Trạng thái thông tin: </label>
                        <select class="content__modal-body-select" name="trangthaithongtin" id="">
                            <option value="1" <?php echo ($row_kh_tk["trangthaithongtin"] == 1) ? 'selected' : '' ?>>có thông tin</option>
                            <option value="0" <?php echo ($row_kh_tk["trangthaithongtin"] == 0) ? 'selected' : '' ?>>thiếu thông tin</option>
                        </select>
                    </div>
    
                    <div class="content__modal-body-form-2">
                        <!-- <label for="" class="content__modal-body-label">Email: </label>
                        <input type="email" name="email" id="" class="content__modal-body-input" value="<?php echo $row_kh_tk["email"] ?>" placeholder="Nhập email"> -->
    
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
            </div>
                    
                    <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Lưu">
                </form>
            </div>
            
        </div>
        <div>
    </div>
</div>




<script src="/CHDDTTHKN/assets/js/main.js"></script>
</body>
</html>