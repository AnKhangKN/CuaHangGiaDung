<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="/CuaHangGiaDung/vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <script src="/CuaHangGiaDung/vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="/CuaHangGiaDung/vendor/fontawesome-free-6.6.0-web/css/all.min.css">

    <!-- css header -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/header.css">

    <!-- css home -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/home.css">

    <!-- css products -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/product.css">

    <!-- css news -->
    <link rel="stylesheet" href="/CuaHangGiaDungpublic/assets/css/customer/news.css">

    <!-- css introduce -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/introduce.css">

    <!-- css contact -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/contact.css">

    <!-- css cart -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/cart.css">

    <!-- css 404 -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/404.css">

    <!-- css footer -->
    <link rel="stylesheet" href="/CuaHangGiaDung/public/assets/css/customer/footer.css">

    

    <title>Giỏ hàng</title>
</head>
<body>
        <header class="header">
            <nav class="header_nav">
                <div class="list_nav_after_hidden">
                    <i class="fa-solid fa-bars fa-lg" id="menu_icon"></i>
                </div>
                <div class="nav_logo">
                    <a href="#"><img src="/CuaHangGiaDung/public/assets/images/logo_den.jpg" class="nav_logo_img" alt="HKN store"></a>                  
                </div>
                <ul class="nav_ul_list text-white" id="menu">
                    <li class="nav_ul_list_item header_link_next">
                        <a href="#" class="nav_ul_list_item_link">Trang chủ</a>
                    </li>
                    <li class="nav_ul_list_item header_link_next list_products_subnav_item">
                        <a href="#" class="nav_ul_list_item_link">Sản phẩm</a>
                        <ul class="nav_ul_list_item_subnav">
                            <li class="nav_ul_list_item_subnav_item sub_menu_products" >
                                <a href="#" class="subnav_item_link"><i class="fa-solid fa-plus sub_icon"></i> Thời trang thể thao </a>
                                <ul class="subnav_item_childen sub_menu_products_list">
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 1</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 1</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 1</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 1</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 1</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 1</a></li>
                                </ul>
                            </li>
                            <li class="nav_ul_list_item_subnav_item sub_menu_products">
                                <a href="#" class="subnav_item_link"><i class="fa-solid fa-plus sub_icon"></i> Dụng cụ thể thao </a>
                                <ul class="subnav_item_childen">
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 2</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 2</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 2</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sản phẩm lv 2</a></li>
                                </ul>
                            </li>
                            <li class="nav_ul_list_item_subnav_item sub_menu_products">
                                <a href="#" class="subnav_item_link"><i class="fa-solid fa-plus sub_icon"></i> Phụ kiện thể thao </a>
                                <ul class="subnav_item_childen">
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sẩn phẩm lv3</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sẩn phẩm lv3</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sẩn phẩm lv3</a></li>
                                    <li class="subnav_item_childen_item"><a href="#" class="childen_link">Sẩn phẩm lv3</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav_ul_list_item header_link_next">
                        <a href="#" class="nav_ul_list_item_link">Tin tức</a>
                    </li>
                    <li class="nav_ul_list_item header_link_next">
                        <a href="#" class="nav_ul_list_item_link">Giới thiệu</a>
                    </li>
                    <li class="nav_ul_list_item header_link_next">
                        <a href="#" class="nav_ul_list_item_link">Liên hệ</a>
                    </li>
                </ul>
                <div class="nav_tool">
                    <form action="">
                        <div class="nav_tool_search" id="nav_tool_search_box">
                            <input type="text" placeholder="Tìm kiếm" id="nav_tool_search_input">
                        </div>
                        <div class="nav_tool_search_icon_box" id="nav_tool_search_icon_box_btn">
                            <span class="nav_tool_search_icon_box_text">Tìm kiếm sản phẩm</span>
                            <i class="fa-solid fa-magnifying-glass" id="nav_tool_search_icon"></i> 
                        </div>
                        <button class="close_search_top" id="close_search_top_element">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <div class="nav_tool_box" id="nav_tool_box_recommend"></div>
                    </form>
                    <div class="nav_tool_mark">
                        <div class="nav_tool_cart">
                            <i class="fa-solid fa-cart-shopping text-white"></i>
                        </div>
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
                        <a href="#" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <p>Đăng nhập</p>
                            </div>
                        </a>
                        <a href="#" style="text-decoration: none; color: black;">
                            <div class="option_sub">
                                <i class="fa-solid fa-user-plus"></i>
                                <p>Đăng ký</p>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <main class="main">
            <div class="container">
                <div class="container_error">
                    <p>404</p>

                    <div class="title_error">
                        <p class="title_error_item">Trang bạn truy cập không tồn tại</p>
                        <p class="title_error_content">Hãy kiểm tra lại đường dẫn <span>
                            <a style="color: #333; text-decoration: none; font-size: 18px; font-weight: 500;" href="/CuaHangGiaDung/public/index.php">nhấn vào để trở lại</a></span></p>
                    </div>
                </div>
                
            </div>
        </main>
        <footer class="footer">
            <div class="container container_footer">
                <div class="footer_content">
                    <p>THÔNG TIN CHUNG </p> 
                    <a href="#" class="footer_content_item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>256 Nguyễn Văn Cừ An Hòa 94108 Cần Thơ</span>
                    </a>
                    <a href="#" class="footer_content_item">
                        <i class="fa-solid fa-phone"></i>
                        <span >+84 292 3898 167</span> 
                    </a>
                    <a href="#" class="footer_content_item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>hknstore@gmail.com</span> 
                    </a>
                    <a href="#" class="footer_content_item">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Gửi phản hồi</span>
                    </a>
                </div>
                <div class="footer_content">
                    <p>HƯỚNG DẪN</p>  
                    <a href="#" class="footer_content_item">Hướng dẫn mua hàng</a>
                    <a href="#" class="footer_content_item">Hướng dẫn thanh toán</a>
                    <a href="#" class="footer_content_item">Hướng dẫn đổi trả</a>
                </div>
                <div class="footer_content">
                    <p>MẠNG XÃ HỘI</p>
                    <a href="#" class="footer_content_item"><i class="fa-brands fa-facebook"></i> facebook</a>
                    <a href="#" class="footer_content_item"><i class="fa-brands fa-instagram"></i> instagram</a>
                    <a href="#" class="footer_content_item"><i class="fa-solid fa-z"></i> zalo</a>
                </div> 
            </div>

            <hr class="footer_hr">

            <div class="container copyright">
                <p class="text-center" style="margin-bottom: 0;">Bản quyền © 2024 bởi HKN store</p>
            </div>
        </footer>
    <script src="/CuaHangGiaDung/public/assets/js/customer/header.js"></script>

    <script src="/CuaHangGiaDung/public/assets/js/customer/home.js"></script>
</body>
</html>