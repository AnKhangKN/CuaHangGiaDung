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
                                <span>Sắp xếp</span>
                            </li> 
                            <li class="all_products_top_order_list_item">
                                <span>Bán chạy nhất</span>
                            </li> 
                            <li class="all_products_top_order_list_item">
                                <span>Tên: A - Z</span>
                            </li> 
                            <li class="all_products_top_order_list_item">
                                <span>Tên: Z - A</span>
                            </li>
                            <li class="all_products_top_order_list_item">
                                <span>Giá: Tăng dần</span>
                            </li> 
                            <li class="all_products_top_order_list_item">
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
                                    <input type="checkbox" class="filter-checkbox" name="price" id=""  value="0-100000">
                                    <span>Dưới 100.000đ</span>
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <input type="checkbox" class="filter-checkbox" name="price" id=""  value="100000-250000">
                                    <span>100.000đ - 250.000đ</span>
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <input type="checkbox" class="filter-checkbox" name="price" id=""  value="250000-500000">
                                    <span>250.000đ - 500.000đ</span>
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <input type="checkbox" class="filter-checkbox" name="price" id=""  value="500000-800000">
                                    <span>500.000đ - 800.000đ</span>
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <input type="checkbox" class="filter-checkbox" name="price" id=""  value="800000-1500000">
                                    <span>800.000đ - 1.500.000đ</span>
                                </li>
                                <li class="all_products_filter_price_list_item">
                                    <input type="checkbox" class="filter-checkbox" name="price" id=""  value="1500000">
                                    <span>Trên 1.500.000đ</span>
                                </li>
                            </ul>
                        </div>

                        <!-- color -->
                        <div class="all_products_filter_color">
                            <div class="all_products_filter_color_title">
                                <span>Màu sắc</span>
                            </div>
                            <ul class="all_products_filter_color_list">
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-red">
                                    <label for="" style="background-color: red;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item">
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-blue" >
                                    <label for="" style="background-color: blue;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-green" >
                                    <label for="" style="background-color: green;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-yellow" >
                                    <label for="" style="background-color: yellow;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-purple" >
                                    <label for="" style="background-color: purple;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-orange" >
                                    <label for="" style="background-color: orange;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-black" >
                                    <label for="" style="background-color: rgb(0, 0, 0);"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-pink" >
                                    <label for="" style="background-color: rgb(255, 0, 204);"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-white" >
                                    <label for="" style="background-color: white;"></label>
                                </li>
                                <li class="all_products_filter_color_list_item" >
                                    <input type="checkbox" class="filter-checkbox" name="color" id="color-gray" >
                                    <label for="" style="background-color: gray"></label>
                                </li>
                            </ul>
                        </div>


                        <!-- size -->
                        <div class="all_products_filter_size">
                            <div class="all_products_filter_size_title">
                                <span>Kích thước</span>
                            </div>
                            <ul class="all_products_filter_size_list">
                                <li>
                                    <ul>Quần áo
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>S</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>M</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>L</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>XL</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>XXL</span>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <ul>Giày
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>36</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>37</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>38</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>39</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>40</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>41</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>42</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>43</span>
                                        </li>
                                        <li class="all_products_filter_size_list_item">
                                            <input type="checkbox" class="filter-checkbox" name="size" id="">
                                            <span>44</span>
                                        </li>
                                    </ul>
                                </li>
                                

                            </ul>
                        </div>
                    </div>
                    
                    
                </div>

                <!-- tag -->
                <div class="all_products_tags">
                    <div class="all_products_tags_filter">
                        Giá: 
                        <b>100.000đ - 500.000đ</b>
                        <span class="all_products_tags_filter_remove">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                    </div>

                    <div class="all_products_tags_filter">
                        Màu sắc:
                        <b>đỏ</b>
                        <span class="all_products_tags_filter_remove">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                    </div>

                    <div class="all_products_tags_filter">
                        Kích thước:
                        <b>M</b>
                        <span class="all_products_tags_filter_remove">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                    </div>

                    <div class="all_products_tags_remove_all">
                        <span>Xóa hết</span>
                    </div>
                </div>

                <!-- all products container -->
                <div class="row row-cols-1 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 g-2">
                    <?php 
                    
                        
                    $products = getAllProducts();

                    // Hiển thị sản phẩm
                    foreach($products as $product) {

                        // Đảm bảo ID sản phẩm được lưu để sử dụng sau này nếu cần
                        $id_product = $product['idSanPham'];

                    ?>
                    <div class="col">
                        <div class="all_products_card" id="product-list">
                            <a href="index.php?page=details&id=<?php echo htmlentities($id_product); ?>" class="all_products_card_link">
                            <img class="card-img-top all_products_card_img" src="./public/assets/images/products/<?php echo htmlentities($product['urlhinhanh']) ?>" alt="Card image" style="width:100%">
                                <div class="card-body">
                                    <p class="all_products_card_title">
                                        <?php echo htmlentities($product['tensanpham']) ?>
                                    </p>
                    
                                    <p class="all_products_card_category">
                                        <span class="all_products_card_category"><?php echo htmlentities($product['tendanhmuc']) ?></span>
                                    </p>
                    
                                    <p class="all_products_card_price">
                                        <span class="all_products_card_new_price"><?php echo htmlentities($product['dongia']) ?> đ</span>
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