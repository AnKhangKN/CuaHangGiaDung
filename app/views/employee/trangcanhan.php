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
                        <div class="title_profile ">
                            <h4>THÔNG TIN CÁ NHÂN</h4>
                            <p>Id nhân viên: <span class="info"><?php echo htmlentities($employee['idNhanVien'])?></span></p>
                            <p>Tên nhân viên: <span class="info"><?php echo htmlentities($employee['tennhanvien'])?></span></p>
                            <p>Số điện thoại: <span class="info"><?php echo htmlentities($employee['sdt'])?></span></p>
                            <p>Căn cước công dân: <span class="info"><?php echo htmlentities($employee['cccd'])?></span></p>
                            <p>Lương: <span class="info"><?php echo htmlentities($employee['luong'])?></span></p>
                            <p>Thưởng: <span class="info"><?php echo htmlentities($employee['thuong'])?></span></p>
                        </div>
                        <style>
                        /* CSS cải tiến */
                        .container_left {
                            background-color: #f9f9fb; /* Nền sáng nhẹ nhàng */
                            padding: 25px; 
                            border-radius: 15px; /* Bo góc mềm mại */
                            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng hiện đại */
                            font-family: 'Arial', sans-serif; 
                            margin: 20px 0; 
                        }

                        .title_profile h4 {
                            font-size: 26px; 
                            font-weight: bold;
                            color:rgb(35, 51, 68); /* Màu tiêu đề đậm, chuyên nghiệp */
                            border-bottom: 3px solid rgb(100, 101, 102); /* Đường kẻ màu xanh ngọc */
                            padding-bottom: 12px;
                            margin-bottom: 25px;
                        }

                        .title_profile p {
                            font-size: 18px; /* Kích thước chữ lớn hơn để dễ đọc */
                            line-height: 1.8; 
                            color:rgb(41, 59, 74); /* Màu chữ tối, dễ nhìn */
                            margin: 12px 0;
                        }

                        .title_profile .info {
                            font-weight: bold;
                            color:rgb(33, 31, 72); /* Màu xanh ngọc để làm nổi bật thông tin */
                            text-transform: capitalize; /* Viết hoa chữ cái đầu */
                        }

                      
                        </style>



                    </div>
                    <div class="container">
                    
                    </div>
                    <div class="text">
                                
                    </div>
                
                </div>
                <div class="col-lg-6">
                    <div class="container_right text-center">
                        <h3 style="margin-top: 40px;">"HKN cửa hàng dụng cụ thể thao"</h3>           
                        
                        
                    </div>
    
                    </div>

                </div>   

            
            </div>
        </div>
    </main>