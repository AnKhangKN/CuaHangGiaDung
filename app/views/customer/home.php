


<main class="main">
            <div class="container-fluid">
                <div class="home_slider">
                    <a href="#">
                        <img src="./public/assets/images/sliders/slider_demo_1.jpg" alt="slider1" class="home_slider_img">
                    </a>
                </div>
                <div class="home_slider">
                    <a href="#"></a>
                        <img src="./public/assets/images/sliders/slider_demo_2.jpg" alt="slider2" class="home_slider_img">
                    </a>
                </div>
                <div class="home_slider"></div>
                    <a href="#">
                        <img src="./public/assets/images/sliders/slider_demo_3.jpg" alt="slider3" class="home_slider_img">
                    </a>
                </div>
            </div>

            <!-- best sellers -->
            <div class="container-fluid container_best_sellers">
                <!-- top -->
                <div class="best_sellers_top">
                    <h2 class="best_sellers_top_text ">Ưa Thích Nhất</h2>
                    <div class="best_sellers_top_btn">
                        <button class="best_sellers_top_btn_left" id="prevBtn">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="best_sellers_top_btn_right" id="nextBtn">
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
                
                <div class="best_sellers_products_list" id="productsList">
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

            <!-- banner -->
                
                <div class="container_banner">
                    <div class="banner text-center">
                        <div class="banner_title">
                            <p>giảm mạnh 40%</p>
                        </div>
                        <div class="banner_content">
                            <p>lựa chọn theo phong cách của bạn</p>
                        </div>
                        <?php
                        $conn = connectBD();

                        $sql_category = mysqli_query($conn, "select * from danhmucsanpham");

                        
                            while ($row_categories = mysqli_fetch_array($sql_category)) {
                                ?>
                                <div class="banner_btn">
                                    <button class="banner_btn_item"><?php echo htmlspecialchars($row_categories['tendanhmuc']); ?></button>
                                </div>
                                <?php
                            }
                        
                        ?>

                    </div>
                </div>
            

            <!-- new products -->
            <div class="container_new_products">
                <!-- top -->
                <div class="new_products_top">
                    <h2 class="new_products_top_text text-center">Sản Phẩm Mới</h2>
                </div>
                <?php
                    $conn = connectBD();
                    $sql_new_products = mysqli_query($conn, "SELECT sp.*, MIN(ha.urlhinhanh) AS urlhinhanh, dm.tendanhmuc
                                                            FROM sanpham AS sp
                                                            JOIN hinhanhsanpham AS ha ON sp.idSanpham = ha.idSanPham
                                                            JOIN danhmucsanpham AS dm ON sp.idDanhMuc = dm.idDanhMuc
                                                            GROUP BY sp.idSanpham, dm.tendanhmuc
                                                            ORDER BY sp.ngaytao DESC

                                                            LIMIT 10");
                ?>
                <!-- prroducts -->
                <div class="container_new_products_list">
                    <!-- btnPrev -->
                    <button class="new_products_list_btn_left" id="newPrevBtn">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <div class="new_products_list" id="newProductsList">
                        <?php 
                        while($row_new_products = mysqli_fetch_array($sql_new_products)){
                            
                            
                            ?>
                            
                        <!-- list new product -->
                        <div class="new_products_list_card">
                            <img class="card-img-top new_products_list_card_img" src="./public/assets/images/products/<?php echo $row_new_products['urlhinhanh']; ?>" alt="Card image" style="width:100%">
                            <div class="new_products_list_card_body">
                                <p class="new_products_list_card_body_title"><?php echo $row_new_products['tensanpham']; ?></p>
                                <p class="new_products_list_card_body_kind"><?php echo $row_new_products['tendanhmuc']; ?></p>
                                <p class="new_products_list_card_body_price"><?php echo $row_new_products['dongia']; ?> đ</p>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                    </div>
                    <!-- btnNext -->
                    <button class="new_products_list_btn_right" id="newNextBtn">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </main>