<?php 
    include './app/controllers/customer/customerController.php';

    // Kiểm tra xem có idBill không và nó lớn hơn 0
    if (isset($_GET['idBill']) && intval($_GET['idBill']) > 0) {
        $idBill = intval($_GET['idBill']);
        $BillId = getBillById($idBill);
    } else {
        
        return 0;
    }
    
    // Kiểm tra xem BillId có hợp lệ không
    if ($BillId) {
        // Lấy thông tin khách hàng dựa trên idKhachHang từ hóa đơn
        $CustomerId = getCustomerById($BillId['idKhachHang']);
    } else {

        return 0;
    }
?>

<main class="main">
            <!-- position sub -->
            <div class="position_top">
                <span class="position_top_main">Trang chủ</span>
                <i class="fa-solid fa-chevron-right"></i>
                <span class="position_top_sub">Lịch sử mua hàng</span>
                <i class="fa-solid fa-chevron-right"></i>
                <span class="position_top_sub">Chi tiết hóa đơn</span>
            </div>
            
            <div class="container detail_bill_container">
                <div class="row">
                    
                    <div class="col-lg-5">
                        <div class="detail_bill">
                            <p>Họ tên khách hàng: <span><?php echo htmlentities($CustomerId['tenkhachhang'])?></span></p>
                            <p>Mã đơn hàng: <span><?php htmlentities($BillId['idHoaDon'])?></span></p>
                            <p>Tổng tiền hóa đơn: <span>400.000 đ</span></p>
                            <p>Ngày xuất hóa đơn : <span>12/12/2024</span></p>
                            <p>Ghi chú: <span>hàng chất lượng</span></p>
                            <p>Trạng thái: <span>Hoàng thành</span></p>
                            <p>Mua online</p>
                            
                            
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