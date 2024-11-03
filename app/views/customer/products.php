<?php 
    include './app/controllers/customer/customerController.php';
?>

<main class="main">
            <!-- position sub -->
            <ul class="position_top">
                <li class="position_top_li_home">
                    <a href="index.php" style="text-decoration: none; color: #333;">
                        <span class="position_top_main">Trang chủ</span>
                    </a>
                </li>


                <li class="position_top_li">
                    <span class="position_top_sub">Sản phẩm</span>
                </li> 
            </ul>


            <!-- banner top -->
            <div class="banner_products_top">
                <img src="./public/assets/images/banner/Banner-demo-products.png" alt="Banner">
            </div>
            <!-- all products -->
            <!-- all products top -->
            <div class="container">
                <div class="all_products_top">
                    <span class="all_products_top_text">
                        Tất cả sản phẩm
                    </span>
                    <div class="all_products_top_order">
                        <div class="all_products_top_order_title">
                            <span>Sắp xếp</span>
                        </div>
                        <ul class="all_products_top_order_list">
                            
                            <li class="all_products_top_order_list_item">
                                
                                <div class="container_arrange">
                                    <input type="checkbox" id="cbxaz" style="display: none;" class="arrange filter_arrange" value="nameA-nameZ">
                                    <label for="cbxaz" class="check">
                                    <svg width="18px" height="18px" viewBox="0 0 18 18">
                                        <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                        <polyline points="1 9 7 14 15 4"></polyline>
                                        </svg>
                                    </label>
                                </div>
                                
                                
                                <span>Tên: A - Z</span>
                            </li> 
                            <li class="all_products_top_order_list_item">
                                <div class="container_arrange">
                                    <input type="checkbox" id="cbxza" style="display: none;" class="arrange filter_arrange" value="nameZ-nameA">
                                    <label for="cbxza" class="check">
                                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                                            <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                            <polyline points="1 9 7 14 15 4"></polyline>
                                        </svg>
                                    </label>
                                </div>
                                
                                <span>Tên: Z - A</span>
                            </li>
                            <li class="all_products_top_order_list_item">

                                <div class="container_arrange">
                                    <input type="checkbox" id="cbxmin" style="display: none;" class="arrange filter_arrange" value="minPrice-maxPrice">
                                    <label for="cbxmin" class="check">
                                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                                            <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                            <polyline points="1 9 7 14 15 4"></polyline>
                                        </svg>
                                    </label>
                                </div>



                                <span>Giá: Tăng dần</span>
                            </li> 
                            <li class="all_products_top_order_list_item">
                                
                                <div class="container_arrange">
                                    <input type="checkbox" id="cbxmax" style="display: none;" class="arrange filter_arrange" value="maxPrice-minPrice">
                                    <label for="cbxmax" class="check">
                                        <svg width="18px" height="18px" viewBox="0 0 18 18">
                                            <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                            <polyline points="1 9 7 14 15 4"></polyline>
                                        </svg>
                                    </label>
                                </div>
                            
                                <span>Giá: Giảm dần</span>
                            </li> 
                        </ul>
                    </div>                    
                </div>
                <!-- filter -->
                <div class="all_products_filter">
                    <!-- text -->
                    <div class="all_products_filter_text">
                        <i class="fa-solid fa-arrow-down-wide-short"></i>
                        <span>Bộ lọc</span>
                    </div>

                    <!-- group -->
                    <div class="all_products_filter_group">
                        <!-- price -->
                        <div class="all_products_filter_price">
                            <div class="all_products_filter_price_title">
                                <span>Giá</span>
                            </div>
                            <ul class="all_products_filter_price_list">
                                <li class="all_products_filter_price_list_item">
                                    <div class="center_price_size">
                                    <input type="checkbox" class="filter-checkbox price" value="0-100000">
                                    <span>Dưới 100.000đ</span>
                                    </div>
                                        
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <div class="center_price_size">
                                    <input type="checkbox" class="filter-checkbox price" value="100000-250000">
                                    <span>100.000đ - 250.000đ</span>
                                    </div>
                                    
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <div class="center_price_size">
                                    <input type="checkbox" class="filter-checkbox price" value="250000-500000">
                                    <span>250.000đ - 500.000đ</span>
                                    </div>
                                    
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <div class="center_price_size">
                                    <input type="checkbox" class="filter-checkbox price" value="500000-800000">
                                    <span>500.000đ - 800.000đ</span>
                                    </div>
                                    
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <div class="center_price_size">
                                    <input type="checkbox" class="filter-checkbox price" value="800000-1500000">
                                    <span>800.000đ - 1.500.000đ</span>
                                    </div>
                                    
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <div class="center_price_size">
                                    <input type="checkbox" class="filter-checkbox price" value="1500000">
                                    <span>Trên 1.500.000đ</span>
                                    </div>
                                    
                                </li>
                            </ul>
                        </div>

                        <!-- color -->
                        <div class="all_products_filter_color">
                            <div class="all_products_filter_color_title">
                                <span>Màu sắc</span>
                            </div>
                            <ul class="all_products_filter_color_list">
                                <?php
                                $Color = getColorProduct();
                                foreach ($Color as $rowColor){
                                    ?>
                                <li class="all_products_filter_color_list_item" >

                                <div class="content_color">
                                    <label class="checkBox_color" style="box-shadow: 0px 0px 0px 2px 
                                    <?php echo htmlentities($rowColor['mausac'])?>;">
                                        <input type="checkbox" class="filter-checkbox color" 
                                        value="<?php echo htmlentities($rowColor['mausac'])?>" name="color" 
                                        id="color-<?php echo htmlentities($rowColor['mausac'])?>">
                                        <div class="transition_color" style="background-color: 
                                        <?php echo htmlentities($rowColor['mausac'])?>;">
                                        </div>
                                    </label>
                                </div>

                                </li>
                                    <?php
                                }
                                ?>
                                
                            </ul>
                        </div>

                        <!-- size -->
                        <div class="all_products_filter_size">
                            <div class="all_products_filter_size_title">
                                <span>Kích thước</span>
                            </div>
                            <ul class="all_products_filter_size_list">
                                <li>
                                    <?php 
                                        $CategoryName = 'Quần áo';
                                        $Size = getSizeProducts($CategoryName);
                                    ?>
                                    <ul>
                                        <p><?php echo htmlentities($CategoryName)?></p>
                                        
                                        <?php 
                                        foreach($Size as $rowSize){
                                            ?>
                                        <li class="all_products_filter_size_list_item">


                                    
                                            <div class="center_price_size">
                                                <input type="checkbox" class="filter-checkbox size" 
                                                value="<?php echo htmlentities($rowSize['kichthuoc'])?>" >
                                                <span><?php echo htmlentities($rowSize['kichthuoc'])?></span>
                                            </div>

                                            
                                        </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li>
                                <?php 
                                        $CategoryName = 'Giày dép';
                                        $Size = getSizeProducts($CategoryName);
                                    ?>
                                    <ul>
                                        <p><?php echo htmlentities($CategoryName)?></p>
                                        

                                        <?php 
                                        foreach ($Size as $rowSize){
                                        ?>
                                        <li class="all_products_filter_size_list_item">

                                            <div class="center_price_size">
                                                <input type="checkbox" class="filter-checkbox size" 
                                                value="<?php echo htmlentities($rowSize['kichthuoc'])?>" name="size">
                                                <span><?php echo htmlentities($rowSize['kichthuoc'])?></span>
                                            </div>
                                            


                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- tag -->
                <div class="all_products_tags">
                    
                </div>

                <!-- all products container -->
                <div class="row row-cols-1 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 g-2 filter_data">
                    <?php
                        $row = getAllProducts();
                        foreach($row as $product){
                            ?>
                            <div class="col">
                                <div class="all_products_card filter_data" id="product-list ">
                                    <a href="index.php?page=details&id=<?php echo htmlentities($product['idSanPham']); ?>" 
                                    class="all_products_card_link">
                                    <img class="card-img-top all_products_card_img" 
                                    src="./public/assets/images/products/<?php echo htmlentities($product['urlhinhanh']) ?>" 
                                    alt="Card image" style="width:100%">
                                        <div class="card-body">
                                            <p class="all_products_card_title">
                                                <?php echo htmlentities($product['tensanpham']) ?>
                                            </p>
                                
                                            <p class="all_products_card_category">
                                                <span class="all_products_card_category">
                                                    <?php 
                                                echo htmlentities($product['tendanhmuc']) 
                                                ?></span>
                                            </p>
                                
                                            <p class="all_products_card_price">
                                                <span class="all_products_card_new_price">
                                                    <?php echo number_format($product['dongia'], 0, ',', '.') ?> đ
                                                </span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
                </div>


                <!-- pre and next page -->
                <div class="page_nav">
                    <div class="page_nav_list">
                        <a href="#" class="page_nav_list_item"><i class="fa-solid fa-chevron-left"></i></a>
                        <a href="#" class="page_nav_list_item">1</a>
                        <a href="#" class="page_nav_list_item">2</a>
                        <a href="#" class="page_nav_list_item">3</a>
                        <a href="#" class="page_nav_list_item">...</a>
                        <a href="#" class="page_nav_list_item">8</a>
                        <a href="#" class="page_nav_list_item">9</a>
                        <a href="#" class="page_nav_list_item">10</a>
                        <a href="#" class="page_nav_list_item"><i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>            
        </main>