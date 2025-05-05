<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jquery -->
    <script src="../vendor/jQuery/jquery-3.7.1.min.js"></script>
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <script src="../vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="../vendor/fontawesome-free-6.6.0-web/css/all.min.css">

    <!-- css header -->
    <link rel="stylesheet" href="../public/assets/css/customer/header.css">

    <!-- css home -->
    <link rel="stylesheet" href="../public/assets/css/customer/home.css">

    <!-- css products -->
    <link rel="stylesheet" href="../public/assets/css/customer/product.css">

    <!-- css news -->
    <link rel="stylesheet" href="../public/assets/css/customer/news.css">

    <!-- css introduce -->
    <link rel="stylesheet" href="../public/assets/css/customer/introduce.css">

    <!-- css contact -->
    <link rel="stylesheet" href="../public/assets/css/customer/contact.css">

    <!-- css cart -->
    <link rel="stylesheet" href="../public/assets/css/customer/cart.css">

    <!-- details -->
    <link rel="stylesheet" href="../public/assets/css/customer/details.css"> 
    
    <!-- payment -->
    <link rel="stylesheet" href="../public/assets/css/customer/payment.css">

    <!-- information -->
    <link rel="stylesheet" href="../public/assets/css/customer/information.css">

    <!-- detail bill -->
    <link rel="stylesheet" href="../public/assets/css/customer/detail_bill.css">

    <!-- css footer -->
    <link rel="stylesheet" href="../public/assets/css/customer/footer.css">

    

    <title>HKN store</title>
</head>
<body>
        <header class="header">
            <nav class="header_nav">
                <div class="list_nav_after_hidden">
                    <i class="fa-solid fa-bars fa-lg" id="menu_icon"></i>
                </div>
                <div class="nav_logo">
                    <a href="index.php"><img src="../public/assets/images/Logo_unie.webp" class="nav_logo_img" alt="HKN store"></a>                  
                </div>
                <ul class="nav_ul_list text-white" id="menu">
                    <li class="nav_ul_list_item header_link_next">
                        <a href="index.php" class="nav_ul_list_item_link">Trang chủ</a>
                    </li>


                    <?php
                    $conn = connectBD();

                    $sql_dm = mysqli_query($conn, 'SELECT * FROM danhmucsanpham ORDER BY idDanhMuc ASC');
                    ?>
                    <li class="nav_ul_list_item header_link_next list_products_subnav_item">
                        <a href="index.php?page=products" class="nav_ul_list_item_link">Sản phẩm</a>
                        <ul class="nav_ul_list_item_subnav">
                            <?php
                            // Lặp qua các danh mục sản phẩm
                            while ($row_dm = mysqli_fetch_array($sql_dm)) {
                                $idDanhMuc = $row_dm['idDanhMuc'];
                                // Truy vấn để lấy 5 sản phẩm cho mỗi danh mục
                                $sql_sp = mysqli_query($conn, "SELECT * FROM sanpham WHERE idDanhMuc = '$idDanhMuc' LIMIT 5");
                                ?>
                                <li class="nav_ul_list_item_subnav_item sub_menu_products <?php echo $row_dm['idDanhMuc']; ?>">
                                    <a href="#" class="subnav_item_link">
                                        <i class="fa-solid fa-plus sub_icon"></i>
                                        <?php echo $row_dm['tendanhmuc']; ?>
                                    </a>

                                    <ul class="subnav_item_childen sub_menu_products_list">
                                        <?php
                                        // Hiển thị tên sản phẩm
                                        while ($row_sp = mysqli_fetch_array($sql_sp)) {
                                            ?>
                                            <li class="subnav_item_childen_item">
                                                <a href="index.php?page=details&id=<?php echo $row_sp['idSanPham']?>" class="childen_link <?php echo $row_sp['idSanPham']?>"><?php echo $row_sp['tensanpham']; ?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>


                    <li class="nav_ul_list_item header_link_next">
                        <a href="index.php?page=news" class="nav_ul_list_item_link">Tin tức</a>
                    </li>
                    <li class="nav_ul_list_item header_link_next">
                        <a href="index.php?page=introduce" class="nav_ul_list_item_link">Giới thiệu</a>
                    </li>
                    <li class="nav_ul_list_item header_link_next">
                        <a href="index.php?page=contact" class="nav_ul_list_item_link">Liên hệ</a>
                    </li>
                </ul>
                <div class="nav_tool">
                    
                        
                    <div class="nav_tool_search_icon_box" id="nav_tool_search_icon_box_btn">
                        <span class="nav_tool_search_icon_box_text">Tìm kiếm sản phẩm</span>
                        <i class="fa-solid fa-magnifying-glass" id="nav_tool_search_icon"></i> 
                    </div>

                    <div id="search_box">
                        <div class="box_container">
                            <div class="search_box_container">
                                <div class="search_box_logo">
                                    <img src="../public/assets/images/logo_trang.jpg" class="nav_logo_img" alt="HKN store">                  
                                </div>
                                
                                <input type="text" id="search_box_input">
                                <div id="search_box_close">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>

                                
                            </div>
                            <!-- sản phẩm hiện -->
                            

                            <div class="product_search">
                                <div class="search_container">
                                    

                                    
                                </div>
                            </div>
                            
                            
                            
                        </div>
                        
                    </div>
                    
                
                    <div class="nav_tool_mark">
                        <a href="index.php?page=cart">
                            <div class="nav_tool_cart">
                                <i class="fa-solid fa-cart-shopping text-white add_product_item"></i>
                            </div>
                        </a>
                        
                    </div>
                    <div class="nav_tool_mark" id="nav_tool_mark_id_user">
                        <div class="nav_tool_user">
                            <i class="fa-solid fa-user text-white"></i>
                        </div>
                    </div>
                    <div class="nav_tool_user_option_up">
                        <i class="fa-solid fa-caret-up"></i>
                    </div>
                    <div class="nav_tool_user_option" id="nav_tool_user_option_id_user">
                    <?php 
                        if(isset($_SESSION['user_id']) && isset($_SESSION['quyen'])){
                            if($_SESSION['quyen'] === 0){
                                ?>
                                
                        <a href="index.php?page=information" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user"></i>
                                <p>Tài khoản của bạn</p>
                            </div>
                        </a>

                        <a href="../app/views/others/logout.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user"></i>
                                <p>Đăng xuất</p>
                            </div>
                        </a>
                                
                            <?php
                            } elseif ($_SESSION['quyen'] === 1){
                                ?>
                                
                        <a href="manager/index.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user"></i>
                                <p>Trở về admin</p>
                            </div>
                        </a>

                        <a href="../app/views/others/logout.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user"></i>
                                <p>Đăng xuất</p>
                            </div>
                        </a>
                                
                                <?php
                            } elseif($_SESSION['quyen'] === 2){
                                ?>
                                
                        <a href="employee/index.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user"></i>
                                <p>Trở về employee</p>
                            </div>
                        </a>

                        <a href="../app/views/others/logout.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user"></i>
                                <p>Đăng xuất</p>
                            </div>
                        </a>
                                
                                <?php
                            }  
                        ?>
                                
                        

                        <?php
                        }else{
                            ?>
                        <a href="login.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <p>Đăng nhập</p>
                            </div>
                        </a>

                        <a href="signup.php" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user-plus"></i>
                                <p>Đăng ký</p>
                            </div>
                        </a>
                            <?php
                        }
                    ?>
                        

                        
                        
                    </div>
                </div>
            </nav>
        </header>