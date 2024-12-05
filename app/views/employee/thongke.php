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
                <div class="col-lg-6">
                    <div class="container_left">
                        <!-- Phan lam -->
                        <table class="table table-bordered text-center">
                            <h4 style="margin: 30px;">Danh sách sản phẩm bán chạy</h4>
                            <thead>
                              <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>                                         
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                               $Statistical = getStatistical();
                               foreach ($Statistical as $Row){
                                ?>
                                <tr>
                                <td class="tensanpham"><?php echo htmlentities($Row['tensanpham'])?></td>    
                                <td class="total_quantity"><?php echo htmlentities($Row['total_quantity'])?></td>                                     
                                </tr>
                                <?php

                               }
                              ?>
                              
                              
                             
                            </tbody>
                          </table>
                            
                    </div>
                    <div class="container_statistical">
                      
                          <button type="button" class="btn_statistical bg-dark text-white">Ngày</button>
                          <button type="button" class="btn_statistical bg-dark text-white">Tuần</button>
                          <button type="button" class="btn_statistical bg-dark text-white">Tháng</button>
                      
                    </div>
                    <div class="text">
                      <h4>Doanh thu:</h4>                                        
                    </div>
              
                      
                
                </div>
                <div class="col-lg-6">
                    <div class="container_right">
                        
                          <div class="container_report">   
                          <button type="button" class="btn_report bg-dark text-white">Xuất báo cáo</button>
                          </div>              
                    </div>
                </div>   

            
            </div>
        </div>
         
    </main>