<?php

session_start();

include '../app/controllers/customer/customerController.php';

if(isset($_SESSION['user_id'])) {

    $id = $_SESSION['user_id'];
    $Customer = getCustomerById($id);
    $Account = getAccountById($id);
    
} else{
    echo 0;
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
                                <a href="index.php?page=cart" style="text-decoration: none; color: #333;">
                                <span class="position_top_sub">Giỏ hàng</span>
                                </a>
                            </li>

                            <li class="position_top_li">
                                <span class="position_top_sub">Thanh toán</span>
                            </li> 
                        </ul>

            <div class="container">
                <div class="row">
                    <div class="col-lg-7 container_left">
                        
                        <div class="title">
                            <p>HKN STORE VIETNAM</p>
                        </div>
                        <div class="container_infor_payment">
                            <div class="infor_payment_title">
                                <p>Thông tin giao hàng</p>
                            </div>
                            
                            <?php 
                            
                            if(isset($_SESSION['user_id'])){

                                ?>
                                
                            <form>
                                <div class="form-group" style="margin-top: 30px;">
                                    <label for="name">Họ và Tên</label>
                                    <input type="name" value="<?php echo htmlentities($Customer['tenkhachhang'])?>" class="form-control" placeholder="Họ và Tên" name="name" id="name" required>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group" style="margin-top: 10px;">
                                            <label for="email">Email</label>
                                            <input type="email" value="<?php echo htmlentities($Account['email'])?>" class="form-control" placeholder="Email" name="email" id="email" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group" style="margin-top: 10px;">
                                            <label for="phone">Số điện thoại</label>
                                            <input type="phone" value="0<?php echo htmlentities($Customer['sdt'])?>" class="form-control" placeholder="Số điện thoại" name="phone" id="phone" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="address">Địa chỉ</label>
                                    <input type="address" value="<?php echo htmlentities($Customer['diachi'])?>" class="form-control" placeholder="Địa chỉ" name="address" id="address" required>
                                </div>
                                
                            </form>
                                
                                <?php
                            }else{
                                ?>

                            <div class="infor_payment_login">
                                    Bạn đã có tài khoản? <a href="http://localhost/CuaHangDungCu/public/login.php">Đăng nhập</a>
                            </div>
                            <p>Hãy nhập thông tin tài khoản để có thể tiến hành thanh toán.</p>
                                
                            <form>
                                <div class="form-group" style="margin-top: 30px;">
                                    <label for="name">Họ và Tên</label>
                                    <input type="name" class="form-control" placeholder="Họ và Tên" name="name" id="name" required>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group" style="margin-top: 10px;">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group" style="margin-top: 10px;">
                                            <label for="phone">Số điện thoại</label>
                                            <input type="phone" class="form-control" placeholder="Số điện thoại" name="phone" id="phone" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="address">Địa chỉ</label>
                                    <input type="address" class="form-control" placeholder="Địa chỉ" name="address" id="address" required>
                                </div>
                                
                            </form>

                                <?php
                            }
                            
                            ?>

                            


                            <div class="form-group" style="margin-top: 40px;">
                                <label for="exampleFormControlTextarea1">Ghi chú</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>

                            <div class="infor_payment_method">
                                <div class="infor_payment_method_title">
                                    <p>Phương thức thanh toán</p>
                                </div>
                                <div class="infor_payment_method_content">
                                    <div class="infor_payment_method_content_choose">
                                        <input type="radio">
                                        <span>Thanh toán khi giao hàng (COD)</span>
                                    </div>
                                    <div class="infor_payment_method_content_choose">
                                        <input type="radio">
                                        <i class="fa-regular fa-credit-card"></i>
                                        <span>Chuyển khoản qua ngân hàng</span>
                                        <div class="content_transfer">
                                            <p>Nội dung chuyển khoản bạn vui lòng điền theo CÚ PHÁP như sau: 
                                                MÃ ĐƠN HÀNG + SĐT + TÊN để Degrey xác nhận thanh toán nhanh chóng cho bạn.
                                            </p>
                                            <p>TÀI KHOẢN CỦA SHOP :</p>
                                            <p>Ngân hàng Vietinbank chi nhánh Lâm Đồng</p>
                                            <p>Số tài khoản: 110884899999</p>
                                            <p>Tên tài khoản: CONG TY TNHH DEGREY</p>
                                            <p>Nếu có vấn đề vui lòng chat qua http://m.me/degrey.saigon hoặc 
                                                hotline: 03363.11117 để gặp nhân viên hỗ trợ
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            
                        </div>
                        
                    </div>
                    <div class="col-lg-5">
                        <div class="container_infor_products_payment">

                        <!-- sản phẩm ----------------------------------------------------- -->
                        <?php
                        // Kiểm tra session 'cart' có tồn tại không
                        if (isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) {
                            
                            // Giải mã JSON từ cookie thành mảng
                            $cart = json_decode($_COOKIE["cart"], true);

                            if (!empty($cart)) {
                        
                            // Lặp qua các sản phẩm trong giỏ hàng
                            foreach ($cart as $idSanPham => $product) {
                                ?>
                                <div class="list_infor_products_payment_item">
                                <span id="idSanPham_item" style="display: none;"><?php echo htmlentities($product['idSanPham'])?></span>
                                    <div class="infor_payment_item_group_product">
                                        <div class="img_infor_payment_item">
                                            <img src="<?php echo htmlentities($product['urlHinhAnh']) ?>" alt="">
                                        </div>
                                        <div class="text_infor_payment_item">
                                            <span style="font-size: 18px; color: #333;"><?php echo htmlentities($product['tenSP']) ?></span>
                                            <span>

                                                <?php echo htmlentities($product['size']) ?>

                                            </span> 
                                            <span><?php echo htmlentities($product['color']) ?></span>
                                            <span><?php echo htmlentities($product['soluong']) ?></span>
                                        </div>
                                    </div>

                                    <div class="price_infor_payment_item">
                                        <span><?php echo htmlentities($product['gia']) ?> đ</span>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>Giỏ hàng của bạn đang trống!</p>";
                        }
                        }
                        ?>


                            
                            <hr>

                            <div class="all_expense">
                                <div class="expense_item">
                                    <span>Tạm tính: </span>
                                    <p ><span id="expense_item_price" style="color:#333;">16000000</span> đ</p> 
                                </div>
                                <div class="expense_item">
                                    <span>Phí vận chuyển: </span>
                                    <p><span id="expense_item_express" style="color: #333;">30.000</span> đ</p> 
                                </div>
                            </div>

                            <hr>
                            
                            <div class="total_bill">
                                <div class="total_bill_label">
                                    <span>Tổng cộng: </span>
                                </div>
                                <div class="total_bill_due">
                                    <span>VND</span>
                                    <span class="total_bill_due_price">430.000</span>
                                    <span>đ</span>
                                </div>
                                
                            </div>

                            <hr>

                            <div class="infor_payment_btn">
                                <div class="infor_payment_btn_cart">
                                    <a href="index.php?page=cart">Giỏ hàng</a>
                                </div>
                                <div class="infor_payment_btn_continue">
                                    <button>Hoàn thành đơn hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>