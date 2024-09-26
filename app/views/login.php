<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cuahangdungcu/vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/cuahangdungcu/public/assets/css/login.css">
    <title>Đăng nhâp cùng HKN store</title>
</head>

<body>

<div class="wapper p-3">
<header class="head_login">
    <img src="/cuahangdungcu/public/assets/images/logo.jpg" alt="Logo" class="img_logo " >
    <p class="header_title mt-4">Chào mừng bạn đến với HKN store hãy đăng nhập để có trải nghiệm tốt nhất.</p>
</header>
<section class="section_form">

    <form action="" method="post">
    <div class="form_input">
        <input type="text" id="input_email" name="email" placeholder="Email*">
    </div>
    <span id="email_error"></span> <!-- Vùng hiển thị lỗi -->

    <div class="form_input form_input_password">
        <input type="password" id="input_password" name="password" placeholder="Mật khẩu*">  
    </div>
    <span id="password_error"></span> <!-- Vùng hiển thị lỗi -->

    <div class="form_remember">
        <input type="checkbox" class="form_remember_checkbox"> 
        <p class="form_remember_text">Lưu lại mật khẩu</p>
    </div>

    <p class="form_text">Nhóm phát triển HKN cảm ơn bạn đã ghé thăm.</p>

    <div class="form_btn">          
        <input type="submit" id="btn_continue" onclick="return checkSignup()" name="continue" class="form_btn_save" value="Đăng nhập">
        <a href="#" class="form_btn_back text-black text-decoration-none">Trở lại</a>                                                
    </div>        
    </form>
</section>

</div>


<script src="/cuahangdungcu/vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/cuahangdungcu/public/assets/js/signUp.js"></script>
</body>


</html>