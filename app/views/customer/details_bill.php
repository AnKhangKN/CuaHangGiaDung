<?php 
    
    include './app/controllers/customer/customerController.php';
    

    
    if (isset($_GET['idBill'])) {
        $idBill = $_GET['idBill'];

        $DetailBillid = getAllDetailBillByIdBill($idBill);
        
        $Billid = getBillById($idBill);
    } else {
        
        return 0;
    }

?>

<main class="main">
            
            
            <div class="container detail_bill_container">
                <div class="row">
                    
                    <div class="col-lg-5">
                        <div class="detail_bill">
                            <p>Họ tên khách hàng: <span>phan</span></p>
                            <p>Mã đơn hàng: <span><?php echo htmlentities($Billid['idHoaDon'])?></span></p>
                            <p>Tổng tiền hóa đơn: <span><?php echo htmlentities($Billid['tongtien'])?></span></p>
                            <p>Ngày xuất hóa đơn : <span><?php echo htmlentities($Billid['ngayxuathoadon'])?></span></p>
                            <p>Ghi chú: <span><?php echo htmlentities($Billid['ghichu'])?></span></p>
                            <p>Trạng thái: <span>
                            <?php

                                if($Billid['trangthai'] == 0){
                                    $trangthai = 'Hoàn thành';
                                } elseif($Billid['trangthai'] == 1){
                                    $trangthai = 'Đang chờ xử lý';
                                } elseif ($Billid['trangthai']== 2){
                                    $trangthai = 'Đang giao hàng';
                                }

                                echo ($trangthai)?>
                            </span></p>
                            
                            
                        </div>
                        <div class="detail_bill_active">
                            <a href="#"><i class="fa-solid fa-arrow-left"></i> Quay lại </a>
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
                                    <tr>
                                        <td>1</td>
                                        <td>Doe</td>
                                        <td>john@example.com</td>
                                        <td>john@example.com</td>
                                        <td>
                                            <button class="btn_reorder">Mua lại</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        
                        </div>

                        
                    </div>
                    
                </div>
                
                
            </div>
            
        </main>