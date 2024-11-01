<?php 
    
    include './app/controllers/customer/customerController.php';
    

    
    if (isset($_GET['idBill'])) {
        $idBill = $_GET['idBill'];

        $DetailBillid = getAllDetailBillByIdBill($idBill);

        $Customer = getCustomerById($_SESSION['user_id']);

        $Bill = getBillById($idBill);

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
                            <p>Mã đơn hàng: <span><?php echo htmlentities($Bill['idHoaDon'])?></span></p>
                            <p>Tổng tiền hóa đơn: <span><?php echo htmlentities($Bill['tongtien'])?></span></p>
                            <p>Ngày xuất hóa đơn : <span><?php echo htmlentities($Bill['ngayxuathoadon'])?></span></p>
                            <p>Ghi chú: <span><?php echo htmlentities($Bill['ghichu'])?></span></p>
                            <p>Trạng thái: <span>

                                <?php 
                                
                                if($Bill['trangthai'] == 0){
                                    $trangthai = 'Hoàn thành';
                                } elseif ($Bill['trangthai'] == 1){
                                    $trangthai = 'Đang chờ xử lý';
                                } elseif ($Bill['trangthai'] == 2){
                                    $trangthai = 'Đang giao hàng';
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

                                    <tr>
                                        <td><?php echo htmlentities($rowDetailBill['tensanpham'])?></td>
                                        <td><?php echo htmlentities($rowDetailBill['soluong'])?></td>
                                        <td><?php echo htmlentities($rowDetailBill['mausac'])?></td>
                                        <td><?php echo htmlentities($rowDetailBill['kichthuoc'])?></td>
                                        <td>
                                            <button class="btn_reorder">Mua lại</button>
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
            
        </main>