<?php 
    include './app/models/customer/productModel.php';

    if(isset($_GET['id']) && ($_GET['id']) > 0){
        $id = $_GET['id'];
        $ProductId = getProductById($id);
    }else{
        $ProductId = 0;
    }

?>

<main class="main">
            <!-- position sub -->
            <div class="position_top">
                <a href="index.php" style="text-decoration: none;">
                <span class="position_top_main">Trang chủ /</span>
                </a>
                <a href="index.php?page=products" style="text-decoration: none;">
                    <span class="position_top_main">Sản phẩm /</span>
                </a>
                <span class="position_top_sub"> <?php echo htmlentities($ProductId['tensanpham'])?></span>
            </div>
            
            <!-- details -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="all_img">
                                    <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                </div>
                                <div class="all_img">
                                    <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                </div>
                                <div class="all_img">
                                    <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                </div>
                                <div class="all_img">
                                    <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-lg-10 main_img_show">
                                <button class="main_img_show_btn_left" id="main_img_show_btn_left_id">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                                <div class="main_img_show_list" id="main_img_show_list_id">
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                            
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                            
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                            
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                            
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                            
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                            
                                    <div class="img_main">
                                        <img src="./public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                    </div>
                                </div>
                                <button class="main_img_show_btn_right" id="main_img_show_btn_right_id">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="products_details_info">
                            <form action="">
                                <div class="products_details_info_title">
                                    <span><?php echo htmlentities($ProductId['tensanpham'])?></span>
                                </div>
                                <div class="products_details_info_price">
                                    <div class="products_details_info_price_under">
                                        <div class="products_details_info_price_under_promotion">
                                            <!-- khuyến mãi -->
                                            <span>40%</span>
                                        </div>
                                        
                                        <!-- Giá gốc -->
                                        <del>160.000đ</del>
                                    </div>
                                    <!-- giá hiệ tại -->
                                    <span class="products_details_info_price_new">100.000đ</span>
                                </div>
                                
                                

                                <div class="products_details_info_size_group">
                                    <!-- title -->
                                    <div class="products_details_info_size_title">
                                        <span>Size</span>
                                    </div>
                                
                                    <!-- clothes -->
                                    <div class="products_details_info_size_group_clothes">
                                        <div class="products_details_info_size_group_clothes_item">    
                                            <input type="checkbox" id="sizeS_clothes">
                                            <label for="sizeS_clothes">S</label>
                                        </div>
                                        <div class="products_details_info_size_group_clothes_item">
                                            <input type="checkbox" id="sizeM_clothes">
                                            <label for="sizeM_clothes">M</label>
                                        </div>
                                        <div class="products_details_info_size_group_clothes_item">
                                            <input type="checkbox" id="sizeL_clothes">
                                            <label for="sizeL_clothes">L</label>
                                        </div>
                                        <div class="products_details_info_size_group_clothes_item">
                                            <input type="checkbox" id="sizeXL_clothes">
                                            <label for="sizeXL_clothes">XL</label>
                                        </div>
                                        <div class="products_details_info_size_group_clothes_item">
                                            <input type="checkbox" id="sizeXXL_clothes">
                                            <label for="sizeXXL_clothes">XXL</label>
                                        </div>
                                    </div>
                                
                                    <!-- shoes -->
                                    <div class="products_details_info_size_group_shoes">
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size36_shoes">
                                            <label for="size36_shoes">36</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size37_shoes">
                                            <label for="size37_shoes">37</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size38_shoes">
                                            <label for="size38_shoes">38</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size39_shoes">
                                            <label for="size39_shoes">39</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size40_shoes">
                                            <label for="size40_shoes">40</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size41_shoes">
                                            <label for="size41_shoes">41</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size42_shoes">
                                            <label for="size42_shoes">42</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size43_shoes">
                                            <label for="size43_shoes">43</label>
                                        </div>
                                        <div class="products_details_info_size_group_shoes_item">
                                            <input type="checkbox" id="size44_shoes">
                                            <label for="size44_shoes">44</label>
                                        </div>
                                    </div>
                                </div>
                                
                                

                                <div class="products_details_info_color">
                                    <span>Color</span>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-red">
                                        <label for="" style="background-color: red;"></label>
                                    </li>
                                    <li class="products_details_info_color_item">
                                        <input type="checkbox" id="color-blue" >
                                        <label for="" style="background-color: blue;"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-green" >
                                        <label for="" style="background-color: green;"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-yellow" >
                                        <label for="" style="background-color: yellow;"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-purple" >
                                        <label for="" style="background-color: purple;"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-orange" >
                                        <label for="" style="background-color: orange;"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-black" >
                                        <label for="" style="background-color: rgb(0, 0, 0);"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-pink" >
                                        <label for="" style="background-color: rgb(255, 0, 204);"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-white" >
                                        <label for="" style="background-color: white;"></label>
                                    </li>
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox" id="color-gray" >
                                        <label for="" style="background-color: gray"></label>
                                    </li>
                                </div>
                                <hr>
                                <div class="products_details_info_add row">
                                    <div class="products_details_info_add_products row col-lg-4">
                                        <div class="products_details_info_add_products_minus col-lg-4">
                                            <button >
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>
                                        <div class="products_details_info_add_products_number col-lg-4">
                                            <input type="text">
                                        </div>
                                        <div class="products_details_info_add_products_plus col-lg-4">
                                            <button>
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="products_details_info_add_btn col-lg-8">
                                        <button>Thêm vào giỏ hàng</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>

                        <div class="products_details_sub_info row">
                            <div class="col-lg-6">
                                <div class="products_details_sub_info_text">
                                    <p>Freeship đơn hàng giá trị trên 1 triệu đồng</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="products_details_sub_info_text">
                                    <p>Đổi hàng chưa qua sử dụng trong vòng 30 ngày</p>
                                </div>
                            </div>
                        </div>

                        <div class="info_product">
                            <div class="info_product_title">
                                Thông tin sản phẩm
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Đề xuất -->
            <div class="container-fluid container_best_sellers">
                <!-- top -->
                <div class="best_sellers_top">
                    <h2 class="best_sellers_top_text ">Dành cho bạn</h2>
                    <div class="best_sellers_top_btn">
                        <button class="best_sellers_top_btn_left" id="prevBtnRecommend">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="best_sellers_top_btn_right" id="nextBtnRecommend">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!--products -->
                <?php 
                    $conn = connectBD();
                    $sql_best_products = mysqli_query($conn, "SELECT sp.*, dm.tendanhmuc, 
                                                                            (SELECT MIN(ha.urlhinhanh) 
                                                                            FROM hinhanhsanpham AS ha 
                                                                            WHERE ha.idSanpham = sp.idSanpham) AS urlHinhAnh, 
                                                                            SUM(cthd.soluong) AS tongSoLuongBan
                                                                    FROM sanpham AS sp
                                                                    JOIN chitietsanpham AS ctsp ON sp.idSanpham = ctsp.idSanpham
                                                                    JOIN chitiethoadon AS cthd ON ctsp.idChiTietSanPham = cthd.idChiTietSanPham
                                                                    JOIN danhmucsanpham AS dm ON sp.idDanhMuc = dm.idDanhMuc
                                                                    GROUP BY sp.idSanpham, dm.tendanhmuc
                                                                    ORDER BY tongSoLuongBan DESC");
                ?>
                
                <div class="best_sellers_products_list" id="productsListRecommend">
                    <?php 
                        while($row_best_products = mysqli_fetch_array($sql_best_products)){
                            ?>
                    <div class="best_sellers_products_list_card">
                        <img class="card-img-top best_sellers_list_card_img" src="./public/assets/images/products/<?php echo $row_best_products['urlHinhAnh']?>" alt="Card image" style="width:100%">
                        <div class="best_sellers_list_card_body">
                            <p class="best_sellers_list_card_body_title"><?php echo $row_best_products['tensanpham']?></>
                            <p class="best_sellers_list_card_body_kind"><?php echo $row_best_products['tendanhmuc']?></p>
                            <p class="best_sellers_list_card_body_price"><?php echo $row_best_products['dongia']?> đ</p>
                        </div>
                    </div>
                            
                            
                            <?php
                        }
                    ?>
                    
                    
                
                </div>
            </div>
            
        </main>