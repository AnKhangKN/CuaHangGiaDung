<?php 
    
    include '../app/controllers/customer/customerController.php';
    

    
    if (isset($_GET['idBill'])) {
        $idBill = $_GET['idBill'];

        $DetailBillid = getAllDetailBillByIdBill($idBill);

        $Customer = getCustomerById($_SESSION['user_id']);

        $_SESSION['idKhachHang'] = $Customer['idKhachHang'];

        $Bill = getBillById($idBill);

        $comment = checkComment($idBill);

        if(!$DetailBillid){
            header('Location: http://localhost/CuaHangDungCu/index.php?page=information');
        }
    } else {
        
        header('Location: http://localhost/CuaHangDungCu/index.php?page=information');
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
                    <a href="index.php?page=information" style="text-decoration: none; color: #333;">
                    <span class="position_top_sub">Thông tin của bạn</span>
                    </a>
                </li>

                <li class="position_top_li">
                    <span class="position_top_sub">Chi tiết hóa đơn</span>
                </li> 
            </ul>
            
            
            <div class="container detail_bill_container">
                <div class="row">
                    
                    <div class="col-lg-5">
                        <div class="detail_bill">
                            <p>Họ tên khách hàng: <span><?php echo htmlentities($Customer['tenkhachhang'])?></span></p>
                            <p>Mã đơn hàng: <span id="idHoaDon_ct"><?php echo htmlentities($Bill['idHoaDon'])?></span></p>
                            <p>Tổng tiền hóa đơn: <span><?php echo number_format($Bill['tongtien'] , 0, ',', '.')?></span></p>
                            <p>Ngày xuất hóa đơn : <span><?php echo htmlentities($Bill['ngayxuathoadon'])?></span></p>
                            <p>Ghi chú: <span><?php echo htmlentities($Bill['ghichu'])?></span></p>
                            <p>Trạng thái: <span>

                                <?php 
                                
                                if($Bill['trangthai'] == 0){
                                    $trangthai = 'Đang chờ xử lý';
                                } elseif ($Bill['trangthai'] == 1){
                                    $trangthai = 'Đang chờ giao hàng';
                                } elseif ($Bill['trangthai'] == 2){
                                    $trangthai = 'Hoàn thành';
                                } else {
                                    $trangthai = 'Không xác định đơn hàng';
                                }

                                echo htmlentities($trangthai);
                                
                                ?>

                            </span></p>
                            
                            
                        </div>
                        <div class="detail_bill_active">
                            <a href="index.php?page=information"><i class="fa-solid fa-arrow-left"></i> Quay lại </a>
                            <button>Xuất hóa đơn</button>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="detail_bill_product">
                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Màu</th>
                                        <th>Kích thước</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $detailsBill = getAllDetailBillByIdBillWithProductName($idBill);

                                        foreach($detailsBill as $rowDetailBill){
                                            ?>

                                    <tr class="row_product">
                                        <td>
                                            <span class="idSanPham"><?php echo htmlentities($rowDetailBill['idSanPham'])?></span>
                                            <span class="tensanpham"><?php echo htmlentities($rowDetailBill['tensanpham'])?></span>
                                        </td>
                                        <td>
                                            <?php echo htmlentities($rowDetailBill['soluong'])?>
                                        </td>
                                        <td>
                                            <?php echo htmlentities($rowDetailBill['mausac'])?>
                                        </td>
                                        <td>
                                            <?php echo htmlentities($rowDetailBill['kichthuoc'])?>
                                        </td>
                                        <td>
                                        <?php 
                                        if($Bill['trangthai'] == 2) {
                                            // Kiểm tra nếu cả 'idSanPham' và 'idBinhLuan' đều không tồn tại
                                            if(!isset($comment['idSanPham']) && !isset($comment['idBinhLuan'])) {
                                                ?> 
                                                <button class="btn_comment btn_get_comment">Nhận xét</button>
                                                <?php 
                                            }else{
                                                echo "Đã bình luận";
                                            }
                                        } else {
                                        }
                                        ?>


                                        </td>
                                    </tr>

                                            <?php 
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                        
                        </div>

                        
                    </div>
                    
                </div>
                
                
            </div>


            <!-- modal comment -->
            <div id="container_comment" class=" position-fixed top-0 start-0 end-0 bottom-0  justify-content-center align-items-center">
                
                <div class="content_comment bg-white h-75 w-50 rounded p-3 position-relative">
                    <div class="header_comment">
                        <p class="fs-3 text">Đánh giá sản phẩm</p>
                    </div>
                    
                    <div class="content_comment mt-4">
                        <div class="img_title d-flex align-content-center">
                            <div class="content_comment_img" style="width: 100px;">
                                <img id="product_img" src="" class="w-100 h-100 object-fit-cover" alt="">
                            </div>
                            <span class="d-none" id="product_id">id san pham</span>
                            <p style="font-size: 17px;" id="product_name">Ten san pham</p>
                        </div>
                        
                        <div class="text mt-4">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"></textarea>
                                <label for="floatingTextarea2">Comments</label>
                            </div>
                        </div>
                        
                    </div>

                    <div class="footer_comment d-flex align-content-center">
                        <button id="cancel_comment" class="position-absolute btn btn-light bg-white" style="bottom: 20px; right: 200px;">Trở lại</button>
                        <button id="send_comment" class="position-absolute btn btn-dark" style="bottom: 20px; right: 20px;">Hoàn thành</button>
                    </div>
                    
                </div>
            </div>
            
        </main>