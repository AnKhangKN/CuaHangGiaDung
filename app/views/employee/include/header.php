<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jquery -->
    <script src="../../vendor/jQuery/jquery-3.7.1.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="../../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <script src="../../vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="../../vendor/fontawesome-free-6.6.0-web/css/all.min.css">

    <!-- css header -->
    <link rel="stylesheet" href="../../app/views/employee/assetss/css/header_.css">

    <!-- css khách hàng -->
    <link rel="stylesheet" href="../../app/views/employee/assetss/css/khachhang.css">

    <!-- css sản phẩm -->
    <link rel="stylesheet" href="../../app/views/employee/assetss/css/sanpham.css">

    <!-- css thống kê -->
    <link rel="stylesheet" href="../../app/views/employee/assetss/css/thongke.css">
    <!-- css duyệt đơn -->
    <link rel="stylesheet" href="../../app/views/employee/assetss/css/duyetdon.css">
    <!-- css trang cá nhân -->
    <link rel="stylesheet" href="../../app/views/employee/assetss/css/trangcanhan.css">
    <title>Khách hàng</title>

    
</head>
<body>

  <header class="header">
    <div class="container_header">

      <!-- logo -->
      <div class="header_logo">
        <img src="../../public/assets/images/logo_den.jpg" alt="Logo">
      </div>

      <!-- tool -->
      <div class="header_tool">
      
        <div class="header_tool_item">
          <a href="index.php?page=trangcanhan"><i class="fa-regular fa-user" ></i></a>
        </div>
        <div class="header_tool_item">
          <i class="fa-regular fa-bell" ></i>
        </div>
        <div class="header_tool_item">
          <i class="fa-regular fa-heart"></i>
        </div>
        
      </div>
    </div>

  </header>

  <div class="container_main">
    <nav class="nav">
      <ul class="list_tool">
        <li class="list_tool_item">
          <i class="fa-solid fa-bag-shopping"></i>
          <a href="index.php?page=sanpham" class=""> SẢN PHẨM</a>
        </li>
        <li class="list_tool_item">
          <i class="fa-regular fa-user"></i> 
          <a href="index.php?page=khachhang" class="">KHÁCH HÀNG</a>
        </li>
        <li class="list_tool_item">
          <i class="fa-solid fa-chart-simple"></i>
          <a href="index.php?page=thongke" class=""> THỐNG KÊ</a>
        </li>
        <li class="list_tool_item">
          <i class="fa-solid fa-check"></i>
          <a href="index.php?page=duyetdon" class=""> DUYỆT ĐƠN</a>
        </li>

        <li class="list_tool_item" style="margin-top: 135px;">
          <i class="fa-solid fa-door-open"></i>
          <a href="../../app/views/others/logout.php" style="text-decoration: none; color: white;" class="logout">Đăng xuất</a>
        </li>
      </ul>
      
    </nav>