<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Jquery -->
    <script src="/CuaHangDungCu/vendor/jQuery/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/CuaHangDungCu/vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <script src="/CuaHangDungCu/vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- css -->
    <link rel="stylesheet" href="/CuaHangDungCu/public/assets/css/others/login.css">

    <title>Đăng nhập</title>
</head>
<body>
    
    <div class="container-fluid mx-auto mt-0 wrapper">
    <header class="header">
        <img src="/CuaHangDungCu/public/assets/images/logo_trang.jpg" class="header_logo" alt="logo_trang">
        <p class="header_title">Hãy đăng ký tài khoản để tham gia vào HKN store</p>
    </header>
    <main class="main">
        <form>
            <div class="main_input_group">
            <span class="result" style="color:red; font-size: 13px; "></span>
                <input type="text" class="main_input_group_item_email" id="input_email">
                <span class="errorEmail" id="email_error"></span>
                <input type="password" class="main_input_group_item_pass password" id="input_password">
                <span class="errorPassword" id="password_error"></span>
            </div>
            <div class="main_checkbox">
                <input type="checkbox" class="main_checkbox_box">
                <p class="main_checkbox_text">Lưu lại mật khẩu</p>
            </div>
            <p class="main_title">Nhóm phát triển HKN cảm ơn bạn đã ghé thăm.</p>
            <div class="main_btn_group">
                <a href="#" class="main_btn_group_back text-black">Trở về</a>
                <input type="submit" class="button main_btn_group_login" value="Đăng nhập">
            </div>
        </form>
    </main>
    </div>
    <script src="/CuaHangDungCu/public/assets/js/others/login.js"></script>
</body>
</html>