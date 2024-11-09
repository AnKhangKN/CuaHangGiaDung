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
                                                <span style="font-weight: 700;" id="count_product"></span>
                                                sản phảm trong giỏ hàng
                                            </p>
                                        </div>

                                        <div id="cart">
                                            <!-- sp 1 -->
                                            <div class="cart_contents_table" style="margin: 5px 0px;">

                                                <div class="cart-table-thumb">
                                                    <div class="cart-table-remove">Xóa</div>
                                                    <div class="cart-table-img">
                                                        <img src="../public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="cart-table-title">
                                                    <div class="cart-table-name">Áo thun nam</div>
                                                    <div class="cart-table-size">S</div>
                                                    <div class="cart-table-unit"> <span class="unit_price">230000</span> đ</div>
                                                </div>
                                                <div class="cart-table-group">
                                                    <div class="cart-table-price">
                                                        <span class="total_price"></span> đ
                                                    </div>
                                                    <div class="cart-table-count">
                                                        <button class="cart-table-minus">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                        <input type="text" value="1" class="cart-table-number">
                                                        <button class="cart-table-plus">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    
                                                </div>

                                            </div>

                                            <!-- sp 2 -->
                                            <div class="cart_contents_table" style="margin: 5px 0px;">

                                                <div class="cart-table-thumb">
                                                    <div class="cart-table-remove">Xóa</div>
                                                    <div class="cart-table-img">
                                                        <img src="../public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="cart-table-title">
                                                    <div class="cart-table-name">Áo thun nam</div>
                                                    <div class="cart-table-size">S</div>
                                                    <div class="cart-table-unit"> <span class="unit_price">230000</span> đ</div>
                                                </div>
                                                <div class="cart-table-group">
                                                    <div class="cart-table-price">
                                                        <span class="total_price"></span> đ
                                                    </div>
                                                    <div class="cart-table-count">
                                                        <button class="cart-table-minus">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                        <input type="text" value="1" class="cart-table-number">
                                                        <button class="cart-table-plus">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    
                                                </div>

                                            </div>

                                        </div>

                                        
                                    </div>
                                    <div class="cart_row">
                                        <div class="cart_contents_note">
                                            <div class="cart_contents_note_title">
                                                <span>Ghi chú đơn hàng</span>
                                            </div>
                                            <div class="cart_contents_note_contents">
                                                <textarea class="form-control" id="note" name="note" rows="5"></textarea>
                                            </div>
                                        </div>
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
                            <form action="">
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
                                    <div class="payment_contents_action_btn">
                                        <button>Thanh toán</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>