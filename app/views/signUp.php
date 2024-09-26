<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cuahangdungcu/vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/cuahangdungcu/public/assets/css/signUp.css">
    <title>Đăng ký cùng HKN store</title>
</head>

<body>

<div class="wapper p-3">
  <header class="head_login">
    <img src="/cuahangdungcu/public/assets/images/logo.jpg" alt="Logo" class="img_logo " >
    <p class="head_title mt-4">Hãy đăng ký tài khoản để tham gia vào HKN store</p>
  </header>
  <section class="form_s">
    <form action="" method="post">
      <div class="input_f">
        <input type="text" id="input_email" name="email" placeholder="Email*">
      </div>
      <span id="email_error"></span> <!-- Vùng hiển thị lỗi -->
      <div class="input_f input_p">
        <input type="password" id="input_password" name="password" placeholder="Mật khẩu*">  
      </div>
      <span id="password_error"></span> <!-- Vùng hiển thị lỗi -->
      <p class="text_e">Nhóm phát triển HKN cảm ơn bạn đã ghé thăm</p>
      <div class="btn_group">          
        <input type="submit" id="btn_continue" onclick="return checkSignup()" name="continue" class="btn_s" value="Tiếp tục">
        <a href="#" class="btn_b text-black text-decoration-none">Trở lại</a>
        <div class="btn_signup">
          <span>Bạn đã có tài khoảng?</span>
          <a href="#" class="text-black text-decoration-none">Đăng nhập</a>
        </div>                                                
      </div>        
    </form>
  </section>

</div>

  
<script src="/cuahangdungcu/vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/cuahangdungcu/public/assets/js/signUp.js"></script>
</body>


</html>