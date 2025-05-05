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

    <!-- css login -->
    <link rel="stylesheet" href="../public/assets/css/others/login.css">

    <!-- css signup -->
    <link rel="stylesheet" href="../public/assets/css/others/signup.css">

    <title>Đăng ký</title>
</head>
<body>
    


    <div class="container-fluid mx-auto mt-0 wrapper">
    <header class="header">
        <img src="../public/assets/images/logo_trang.jpg" class="header_logo" alt="logo_trang">
        <p class="header_title">Hãy đăng ký tài khoản và tham gia mua sắm cùng chúng tôi</p>
    </header>
    <main class="main">

        <div id="php_send" class="result_error"></div>
        <span class="result_error"></span>
        <div class="input_container">
            <div class="input_group">
                <input type="text" class="input_container_item" id="email" autocomplete="off">
                <label for="email">Email *</label>
            </div>
        </div>

        <span class="result_error"></span>
        <div class="input_container">
            <div class="input_group">
                <input type="password" class="input_container_item" id="password" autocomplete="off">
                <label for="password">Password *</label>
            </div>
        </div>

        <p class="main_title">HKN Store – Mua thông minh, sắm chất lượng.</p>

        <div class="btn_container">
            <a href="index.php" style="text-decoration: none; color: #333;" class="back">Trở lại</a>
            <button id="confirm_acc" class="continue" href="/CuaHangGiaDung/public/confirm.php">Xác nhận tài khoản <div class="load_signup "></div> </button>
        </div>
        
        
    </main>
    </div>
    <script src="../public/assets/js/others/signup.js"></script>
</body>
</html>