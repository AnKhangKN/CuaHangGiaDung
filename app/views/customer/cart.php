<main class="main">

            <!-- position sub -->
            <ul class="position_top">
                <li class="position_top_li_home">
                    <a href="index.php" style="text-decoration: none; color: #333;">
                        <span class="position_top_main">Trang chủ</span>
                    </a>
                </li>
                <li class="position_top_li">
                    <span class="position_top_sub">Giỏ hàng</span>
                </li> 
            </ul>

            <div class="container">
                <div class="row container_cart">
                    <div class="col-lg-8">
                        <div class="cart">
                            <div class="cart_title">
                                <p>Giỏ hàng của bạn</p>
                            </div>
                            <hr>
                            <div class="cart_contents">
                                <form action="">
                                    <div class="cart_row">
                                        <div class="cart_contents_title">
                                            <p>Bạn có
                                                <span style="font-weight: 700;" id="count_product">0</span>
                                                sản phảm trong giỏ hàng
                                            </p>
                                        </div>

                                        <?php 
                                        // Kiểm tra nếu cookie `cart` tồn tại và không trống
                                        if(isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])){
                                        
                                            // Giải mã JSON từ cookie thành mảng
                                            $cart = json_decode($_COOKIE["cart"], true);
                                        
                                            if (!empty($cart)) {
                                                ?>
                                        
                                                <div id="cart">
                                            
                                                <?php 
                                                // Duyệt qua từng sản phẩm trong giỏ hàng từ mảng $cart
                                                foreach($cart as $idSanPham => $product){
                                                    ?>
                                                    <div class="cart_contents_table" >
                                                        <span id="idSanPham_item" style="display: none;"><?php echo htmlentities($product['idSanPham'])?></span>
                                                        <div id="productAmount" style="display: none;"></div>
                                                        <div class="cart-table-thumb">
                                                            <div class="cart-table-remove">Xóa</div>
                                                            <div class="cart-table-img">
                                                                <img src="<?php echo htmlentities($product['urlHinhAnh'])?>" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="cart-table-title">
                                                            <div class="cart-table-name"><?php echo htmlentities($product['tenSP'])?></div>
                                                            <div class="cart_table_detail_group">
                                                                <div class="cart-table-size"><?php echo htmlentities($product['size'])?></div>
                                                                <div class="cart-table-color"><?php echo htmlentities($product['color'])?></div>
                                                            </div>
                                                            <div class="cart-table-unit"> 
                                                                <span class="unit_price"><?php echo htmlentities($product['gia'])?></span> đ
                                                            </div>
                                                        </div>
                                                        <div class="cart-table-group">
                                                            <div class="cart-table-price">
                                                                <span class="total_price"></span> đ
                                                            </div>
                                                            <div class="cart-table-count">
                                                                <button class="cart-table-minus">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </button>
                                                                <input type="text" value="<?php echo htmlentities($product['soluong'])?>" class="cart-table-number">
                                                                <button class="cart-table-plus">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                
                                                </div>
                                                
                                                <?php
                                            } else {
                                                echo "Giỏ hàng trống!";
                                            }
                                        } else {
                                            echo "Giỏ hàng trống!";
                                        }
                                        ?>


                                        
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>  

                    <div class="col-lg-4">
                        <div class="payment">
                            <div class="payment_title">
                                <p>Thông tin thanh toán</p>
                            </div>
                            <hr>
                            <form id="click_pay_page">
                                <div class="payment_contents">
                                    <div class="payment_contents_total">
                                        <p class="payment_contents_total_p">Tổng tiền: </p>
                                        <div class="payment_block_price">
                                                <span class="total_all_price"> </span> đ
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <ul>
                                    <li>Phí vận chuyển sẽ trong trang thanh toán</li>
                                    <li>Có thể thêm mã giảm giá trong trang thanh toán</li>
                                </ul>
                                <div class="payment_contents_action">
                                    <!-- Sẽ hiện khi có giỏ hàng trống -->
                                    <div class="payment_contents_action_erorr">
                                        <p>Giỏ hàng của bạn hiện chưa đạt mức tối thiểu để thanh toán.</p>
                                    </div>
                                    <div class="payment_contents_action_btn" >
                                    <a id="pay_page" href="index.php?page=payment" >Thanh toán</a>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>