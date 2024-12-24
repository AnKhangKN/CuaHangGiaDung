<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "../../app/controllers/employee/all_function.php";

if(isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $employee = getInfo($id);
}

?>



<main class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="container_left">
                        <!-- Phan lam -->
                        <div class="title_profile">
                          <h4>THÔNG TIN CÁ NHÂN</h4>  
                          <p>Id nhân viên: <span style="font-weight: 400;"><?php echo htmlentities($employee['idNhanVien'])?></span></p>
                          <p>Tên nhân viên: <span style="font-weight: 400;"><?php echo htmlentities($employee['tennhanvien'])?></span></p>
                          <p>Số điện thoại: <span style="font-weight: 400;"><?php echo htmlentities($employee['sdt'])?></span> </p>
                          <p>Căn cước công dân: <span style="font-weight: 400;"><?php echo htmlentities($employee['cccd'])?></span></p>
                          <p>Lương: <span style="font-weight: 400;"><?php echo htmlentities($employee['luong'])?></span></p>
                          <p>Thưởng:<span style="font-weight: 400;"><?php echo htmlentities($employee['thuong'])?></span></p> 
                        </div>
                       

                    </div>
                    <div class="container">
                    
                    </div>
                    <div class="text">
                                
                    </div>
                
                </div>
                <div class="col-lg-6">
                    <div class="container_right">
                    
                    </div>
                </div>   

            
            </div>
        </div>
    </main>