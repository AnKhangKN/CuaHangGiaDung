<?php 
    include '../app/controllers/customer/customerController.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $ProductId = getProductByProductId($id);

        if(!$ProductId){
            header('Location: /CuaHangGiaDung/public/index.php?page=products');
            exit;
        }
        
    }  else{
        header('Location: /CuaHangGiaDung/public/index.php?page=products');
        exit;
    }

?>

<main class="main">
            <!-- position sub -->
            <ul class="position_top">
                <li class="position_top_li_home">
                    <a href="index.php" style="text-decoration: none; color: #333;">
                        <span class="position_top_main">Trang chủ</span>
                    </a>
                </li>
                
                <li class="position_top_item">
                    <a href="index.php?page=products" style="text-decoration: none; color: #333;">
                    <span class="position_top_sub">Sản phẩm</span>
                    </a>
                </li>

                <li class="position_top_li">
                    <span class="position_top_sub"><?php echo htmlentities($ProductId['tensanpham'])?></span>
                </li> 
            </ul>
            
            <!-- details -->
            <div class="container">
                <div class="row product_info_to_cart">

                    <div class="col-lg-6">

                        <div class="row">

                            <div class="col-lg-2">
                            <a href="index.php?page=products" style="text-decoration: none; color: #333;">
                                <div class="back_home">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </div>
                            </a>
                            
                            <?php 

                            $imgAll = getImageUrlsByProductId($ProductId['idSanPham']);

                            $imageUrls = [];

                                foreach($imgAll as $rowImg){ 
                                    $imageUrls[] = "../public/assets/images/products/" . htmlentities($rowImg['urlhinhanh']);
                                    ?>

                                <div class="all_img">
                                        <img src="<?php echo $imageUrls[count($imageUrls) - 1]; ?>" 
                                        alt="Ảnh <?php echo htmlentities($ProductId['tensanpham'])?>"
                                        onclick="changeImage(this)">
                                </div>
                                <?php
                                }
                            ?>
                            </div>
                            <div class="col-lg-10 main_img_show">
                                
                                <div class="main_img_show_list" id="main_img_show_list_id">

                                <button class="main_img_show_btn_left" id="main_img_show_btn_left_id" onclick="prevImage()">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>

                                    <div class="img_main">
                                    <img id="largeImg" src="<?php echo $imageUrls[0]; ?>" 
                                    alt="Ảnh <?php echo htmlentities($ProductId['tensanpham'])?>">
                                    </div>
                            
                                <button class="main_img_show_btn_right" id="main_img_show_btn_right_id" onclick="nextImage()">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>


                                </div>
                                
                            </div>

                                

                                
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="products_details_info">
                            <form >
                                <div class="products_details_info_title">
                                    <span class="products_details_info_title_name"><?php echo htmlentities($ProductId['tensanpham'])?></span>
                                </div>
                                <div class="products_details_info_price">
                                    <!-- <div class="products_details_info_price_under">
                                        <div class="products_details_info_price_under_promotion">
                                            
                                            <span>40%</span>
                                        </div>
                                        
                                        
                                        <del>160.000đ</del>
                                    </div> -->
                                    <!-- giá hiệ tại -->
                                    <span class="products_details_info_price_new">
                                    <?php echo number_format($ProductId['dongia'],0,',','.') ?> 
                                    </span><span>đ</span>
                                </div>

                                
                                <div id="Productsize">
                                <?php 
                                    $Category = getCategoryByProductId($id);
                                    if($Category['tendanhmuc'] === 'Máy ép'){
                                        ?>
                                        
                                <div class="products_details_info_size_group">
                                    <!-- title -->
                                    <div class="products_details_info_size_title">
                                        <span>Size </span>
                                    </div>
                                    <!-- clothes -->
                                    <div class="products_details_info_size_group">

                                    <?php 
                                        $Size = getProductsSizeByProductId($id);

                                        foreach($Size as $rowSize){
                                            ?>
                                            
                                            <div class="products_details_info_size_group_item">    
                                                <input type="checkbox" value="<?php echo htmlentities($rowSize['kichthuoc'])?>" 
                                                class="products_details_info_size_group_item_input" 
                                                id="size<?php echo htmlentities($rowSize['kichthuoc'])?>_clothes">
                                                <label for="size<?php echo htmlentities($rowSize['kichthuoc'])?>_clothes">
                                                    <?php echo htmlentities($rowSize['kichthuoc'])?>
                                                </label>
                                            </div>
                                            
                                            <?php
                                        }

                                    ?>

                                    </div>
                                </div>
                                        
                                        <?php 
                                    } elseif($Category['tendanhmuc'] === 'Nồi'){
                                        
                                        ?>
                                <div class="products_details_info_size_group">
                                    <!-- title -->
                                    <div class="products_details_info_size_title">
                                        <span>Size </span>
                                    </div>
                                    <!-- clothes -->
                                    <div class="products_details_info_size_group">

                                    <?php 
                                        $Size = getProductsSizeByProductId($id);

                                        foreach($Size as $rowSize){
                                            ?>
                                            
                                            <div class="products_details_info_size_group_item">    
                                                <input type="checkbox" value="<?php echo htmlentities($rowSize['kichthuoc'])?>"
                                                class="products_details_info_size_group_item_input"
                                                id="size<?php echo htmlentities($rowSize['kichthuoc'])?>_clothes">
                                                <label for="size<?php echo htmlentities($rowSize['kichthuoc'])?>_clothes">
                                                    <?php echo htmlentities($rowSize['kichthuoc'])?>
                                                </label>
                                            </div>
                                            
                                            <?php
                                        }
                                    ?>
                                        
                                    </div>
                                </div>
                                        <?php
                                    } else {

                                        ?>
                                        
                                        <?php
                                    }
                                ?>
                                </div>
                                    
                                <div class="products_details_info_color">
                                <span>Color</span>
                                <?php 
                                    $Color = getProductColorByProductId($id);
                                    
                                    foreach($Color as $rowColor){
                                        ?>
                                        
                                    <li class="products_details_info_color_item" >
                                        <input type="checkbox"
                                        value="<?php echo htmlentities($rowColor['mausac'])?>"
                                        id="color-<?php echo htmlentities($rowColor['mausac'])?>"
                                        class="products_details_info_color_item_input">
                                        <label style="background-color: <?php echo htmlentities($rowColor['mausac'])?>;"></label>
                                    </li>

                                        <?php 
                                    }
                                    ?>
                                    
                                </div>
                                <div id="ProductAmount" style="display: none;">0</div>
                                <hr>
                                <div class="products_details_info_add row">
                                    <div class="products_details_info_add_products row col-lg-4">
                                        <button class="products_details_info_add_products_minus">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                            <input type="text" value="0" class="products_details_info_add_products_input">
                                        <button class="products_details_info_add_products_plus">
                                        <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="products_details_info_add_btn col-lg-8">
                                        <button class="add_cart">Thêm vào giỏ hàng</button>
                                        
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
                                <p>Thông tin sản phẩm</p>
                            </div>
                            <div class="info_product_content">
                                <div id="ProductId" style="display: none;"><?php echo htmlentities($id)?></div>
                                <p><?php echo htmlentities($ProductId['mota'])?></p>
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
                                                                    WHERE sp.idSanPham > 0 AND sp.trangthai > 0
                                                                    GROUP BY sp.idSanpham, dm.tendanhmuc
                                                                    ORDER BY tongSoLuongBan DESC");
                ?>
                
                <div class="best_sellers_products_list" id="productsListRecommend">
                    <?php 
                        while($row_best_products = mysqli_fetch_array($sql_best_products)){
                            ?>
                    
                    <div class="best_sellers_products_list_card">
                    <a style="color: #333; text-decoration: none;" href="index.php?page=details&id=<?php echo htmlentities($row_best_products['idSanPham'])?>">
                        <img class="card-img-top best_sellers_list_card_img" src="../public/assets/images/products/<?php echo $row_best_products['urlHinhAnh']?>" alt="Card image" style="width:100%">
                        <div class="best_sellers_list_card_body">
                            <p class="best_sellers_list_card_body_title"><?php echo $row_best_products['tensanpham']?></>
                            <p class="best_sellers_list_card_body_kind"><?php echo $row_best_products['tendanhmuc']?></p>
                            <p class="best_sellers_list_card_body_price"><?php echo number_format($row_best_products['dongia'],0,',','.') ?> đ</p>
                        </div>
                        </a>
                    </div>
                    
                            
                            <?php
                        }
                    ?>
                    
                    
                
                </div>
            </div>
            
        </main>

        <script>
        // Xuất mảng ảnh sang một biến JavaScript toàn cục
        window.imageUrlsFromPhp = <?php echo json_encode($imageUrls); ?>; 

        </script>