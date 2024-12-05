<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}


include_once "../../app/controllers/employee/all_function.php";

if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}
?>


<main class="main">
        <div class="container-fluid">
            <div class="row">
            <div class="container">
                <input class="form-control" id="myInput" type="text" placeholder="Nhập tìm kiếm" style="margin-top: 20px; width: 50%;margin-left: 30px;">
                <br>
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày tạo</th>
                            <th>Tên khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
                    $Browse = getBrowse();
                    foreach ($Browse as $Row){
                        ?>
                    
                    <tr class="cell_product text-center">
                        <td class="idHoaDon"><?php echo htmlentities($Row['idHoaDon'])?></td>
                        <td class="ngayxuathoadon"><?php echo htmlentities($Row['ngayxuathoadon'])?></td>
                        <td class="tenkhachhang"><?php echo htmlentities($Row['tenkhachhang'])?></td>
                        <td class="tongtien"><?php echo number_format($Row['tongtien'], 0, ',', '.')?></td>
                        <td class="ghichu"><?php echo htmlentities($Row['ghichu'])?></td>
                        <td class="trangthai text-center">
                            <?php $tinhtrang = $Row['trangthai'];
                            
                            if($tinhtrang === 0){
                                ?>
                                <button class="btn btn-dark">Xác nhận</button>
                                <?php
                            }else{
                                ?>
                                <p>Đơn hàng đã được xử lý</p>
                                <?php
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