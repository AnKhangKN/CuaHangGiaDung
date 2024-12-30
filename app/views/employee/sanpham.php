<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}


include_once "../../app/controllers/employee/all_function.php";

if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
    $info = getInfo($id);
}


?>



<main class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="container_left">
                        <!-- Phan lam -->
                        <div class="search-container">
                            <h5 class="text-center p-4">SẢN PHẨM</h5>
                            <div class="search-box-sp">
                                <input type="text" id="search" placeholder="Nhập từ khóa tìm kiếm">                    
                            </div>
                        </div>
<!-- ---------------------------------------------------------------- -->
                        <div class="container_table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>

                                <tbody id="product_container">
                                    <?php
                                    $Product = getProduct();

                                    foreach ($Product as $Row){
                                        ?>
                                        
                                    <tr class="cell_product">
                                        <td class="idSanPham"><?php echo htmlentities($Row['idSanPham'])?></td>
                                        <td class="tenSanPham"><?php echo htmlentities($Row['tensanpham'])?></td>
                                        <td >
                                            <div class="product_img" style="width: 90px;">
                                                <img class="w-100 h-100 object-fit-cover imgSanPham" 
                                                src="../../public/assets/images/products/<?php echo htmlentities($Row['urlHinhAnh'])?>" alt="">
                                            </div>
                                        </td>
                                        <td class="giaSanPham"><?php echo number_format($Row['dongia'], 0, ',', '.')?></td>
                                    </tr>
                                        
                                        <?php
                                    }
                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>

                        <!-- modal detail -->
                        <div id="modal_product_detail">
                            <div class="container_product w-50 h-75 bg-white rounded-2">
                                <div class="product_detail p-5  ">
                                    <div class="product_detail_header d-flex align-content-center">
                                        <div class="product_img w-25">
                                            <img id="imgProduct" class="w-100 h-100 object-fit-cover" src="../../public/assets/images/products/ao-the-thao-nam-demo.jpg" alt="">
                                        </div>
                                        <div class="product_name">
                                            <span  id="idSanPham" class="d-none"></span>
                                            <p id="ProductName" style="font-weight: 500;font-size: 22px; margin-left: 40px;"></p>
                                        </div>
                                    </div>

                                    <div id="product_detail_body">
                                        
                                    </div >
                                    <div style="font-weight: 500; " class="d-flex">
                                        <p style="width: 155px">Giá sản phẩm: </p>
                                        <span  id="ProductPrice" style="font-weight: 400;"></span>
                                    </div>
                                    
                                    <div class="idchitietsanpham d-none">
                                        <p style="font-weight: 500;">Id chi tiết sản phẩm: </p>
                                        <span id="idchitietsanpham">0</span>
                                    </div>
                                    <div class="soluongconlai d-flex">
                                        
                                        <p style="font-weight: 500; width: 155px" >Số lượng còn lại: </p>
                                        <span id="late_amount">0</span>
                                    </div>
                                        
                                    <div class="amount d-flex">
                                    <p style="font-weight: 500; margin-top: 7px; width: 155px">Số lượng: </p>
                                        <button class="btn btn-light" id="down_product">
                                            <i  class="fa-solid fa-minus "></i>
                                        </button>

                                        <input style="width: 8%; text-align: center; border: none;" type="text" id="amount_product" value="0">
                                        
                                        <button class="btn btn-light"  id="up_product">
                                            <i class="fa-solid fa-plus " ></i>
                                        </button >
                                    </div>
                                    

                                    <div class="product_detail_footer d-flex justify-content-between align-content-center mt-4">
                                        <button class="btn btn-light" id="close">Trở lại</button>
                                        <button class="btn btn-dark" id="add">Thêm vào mua hàng</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

<!-- ---------------------------------------------------------------- -->
                    </div>
                </div>
                <div class="col-lg-6" id="Payment_send">
                    <div class="container_right">
                        <div class="search-container">
                            <div class="search-box-pay">
                                <input class="form-control" id="myInput" type="text" placeholder="Nhập số điện khách hàng">
                                <br>
                                <ul class="list-group" id="myList">
                                    
                                </ul>      
                                            
                            </div>
                                                    
                        </div>
                    </div>
                        <div id="container_payment ">
                            <h5 class="text-center mb-5">THANH TOÁN</h5>

                            <div class="text-end">
                                <p class="">Khách hàng không có thông tin</p>
                                <input type="checkbox" class="" id="status_customer" value="0">
                            </div>
                            
                            <div class="title_payment">
                                <span id="idKhach" class="d-none"></span>
                                <p>Tên khách hàng: <span id="tenKhach"></span> </p> 
                                <p>Số điện thoại: <span id="sdtKhach"></span> </p>  
                                <p>Nhân viên bán hàng: <?php echo htmlentities($info['tennhanvien'])?></p>
                                <span id="idNhanVien" class="d-none"><?php echo htmlentities($info['idNhanVien'])?></span> 
                            </div>

                           

                            <div class="content_payment">
                            <table class="table">
                                <thead>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá </th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php 
                                if (isset($_COOKIE['cart_e'])) {  
                                    $cart = json_decode($_COOKIE['cart_e'], true);

                                    if (!empty($cart)) {
                                        foreach ($cart as $key => $product) {
                                ?>
                                <tr class="SanPham_buy">
                                    <td class="d-flex flex-column">
                                        <span class="idSanPham_buy d-none"><?php echo htmlentities($product['idSanPham']); ?></span>
                                        <span class="idChiTietSanPham_buy d-none"><?php echo htmlentities($product['idChiTietSanPham']); ?></span >
                                        <span class="tenSanPham_buy"><?php echo htmlentities($product['tenSanPham']); ?></span>
                                        <span class="mau_buy"><?php echo htmlentities($product['mau']); ?></span>
                                        <span class="kichthuoc_buy"><?php echo htmlentities($product['kichthuoc']); ?></span>
                                        
                                    </td>
                                    <td >
                                        <?php echo htmlentities($product['dongia']); ?> 
                                    </td>
                                    <td >
                                        <span class="soluongSP text-center" ><?php echo htmlentities($product['soluong']); ?></span>
                                        <span class="soluongconlai d-none">90</span>
                                        

                                    </td>
                                    <td class="don_gia">
                                        <?php echo htmlentities($product['dongia'] * $product['soluong']);?>000
                                    </td>
                                    <td>
                                        <button class="remove_cart" style="border: none;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>

                                </tbody>
                                
                            </table>
                            </div>

                            <div id="total_price" style="margin: 0px 30px; text-align: end;">
                                <span>Tổng tiền: </span>
                                <span id="tong_don_gia">0</span>
                            </div>

                            <div class="action_payment">
                                <button type="button" class="btn bg-dark text-white">Tạm tính</button>
                                <button id="ThanhToan" type="button" class="btn bg-dark text-white">Thanh toán</button>
                            </div>  

                        </div>    
                                    
                    </div>
                </div>   

            
            </div>
        </div>
        
</main>