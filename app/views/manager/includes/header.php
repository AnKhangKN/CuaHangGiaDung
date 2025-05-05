<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HKN store</title>
    <link rel="stylesheet" href="../../app/views/manager/assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="../../public/assets/images/logo_trang.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../vendor/fontawesome-free-6.6.0-web/css/all.min.css">
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

            <a href="/CuaHangGiaDung/public/manager/dangxuat.php" class="nav__link">
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