<?php
    session_start();
    ob_start();

    
    if(isset($_SESSION['user_id'])){
        header('Location: /CuaHangGiaDung/public/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Jquery -->
    <script src="../vendor/jQuery/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <script src="../vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- css -->
    <link rel="stylesheet" href="../public/assets/css/others/login.css">

    <title>Quên mật khẩu</title>
</head>
<body>
    


<div class="container-fluid mx-auto mt-0 wrapper">
    
    
    <header class="header">
        <img src="../public/assets/images/Logo.webp" class="header_logo" alt="logo_trang">
        <p class="header_title">Hãy đăng nhập tài khoản của bạn để dễ dàng mua sắm cùng HKN store</p>
    </header>
    <main class="main">
        
        <div class="result" style="color:red; font-size: 13px; margin-bottom: 10px;"></div>

        <div class="errorPassword" id="password_error" style="margin-bottom: 10px;"></div>

        <div class="errorCode" id="code_error" style="margin-bottom: 10px;"></div>

        <div class="errorEmail" id="email_error" style="margin-bottom: 10px;"></div>

        <div class="input_container">
            <div class="input_group">
                <input type="text" class=" email" id="input_email" tabindex="1" autocomplete="off">
                <label for="input_email">Email *</label>
            </div>
        </div>
        
        <div class="input_container">
            <div class="input_group">
                <input type="code" class=" code" id="input_code" tabindex="2" autocomplete="off">
                <label for="input_code">Code *</label>
                <button id="getCode"> Nhận code * <div class="btn_code "></button>

            </div>
        </div>


        <div class="input_container">
            <div class="input_group">
                <input type="password" class=" password" id="input_password" tabindex="3" autocomplete="off">
                <label for="input_password">New Password *</label>
            </div>
        </div>

        <p class="main_title">HKN Store – Mua thông minh, sắm chất lượng.</p>

        <div class="main_btn_group">
            <a href="index.php" tabindex="4" class="main_btn_group_back text-black">Trở về</a>
            <button id="btn_changePass" class="button main_btn_group_login" tabindex="4">Trở lại đăng nhập <div class="btn_login "></div></button>
        </div>
    
    </main>
</div>

<script src="../public/assets/js/others/forgot.js"></script>
</body>
</html>