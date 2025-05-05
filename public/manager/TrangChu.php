<?php

include "../../config/connect.php";
    

?>
<div id="content">
            <div class="content__container">
                <div class="content__row">
                    <div style="background-color: var(--blue-color);" class="content__item">
                        <div class="content__item-container">
                            <h3 class="content__item-headding">
                                Danh mục
                            </h3>

                            <div class="content__item-body">
                                <span class="content__item-quantity">
                                    <?php 
                                        $sql_danhmuc = "SELECT COUNT(*) AS total_rows FROM danhmucsanpham";
                                        $result_danhmuc = mysqli_query($conn, $sql_danhmuc);
                                        
                                        if ($result_danhmuc) {
                                            $row_danhmuc = mysqli_fetch_assoc($result_danhmuc);
                                            echo $row_danhmuc["total_rows"];
                                        }
                                    ?>
                                </span>
    
                                <div class="content__item-logo">
                                    <i class="fa-solid fa-list content__item-logo-icon"></i>
                                </div>

                            </div>

                        </div>
                        
                    </div>

                    <div style="background-color: var(--green-color);" class="content__item">
                    <div class="content__item-container">
                            <h3 class="content__item-headding">
                                Nhân viên
                            </h3>
                            
                            <div class="content__item-body">
                                
                                <span class="content__item-quantity">
                                <?php 
                                    $sql_nhanvien = "SELECT COUNT(*) AS total_rows FROM nhanvien";
                                    $result_nhanvien = mysqli_query($conn, $sql_nhanvien);
                                        
                                    if ($result_nhanvien) {
                                        $row_nhanvien = mysqli_fetch_assoc($result_nhanvien);
                                        echo $row_nhanvien["total_rows"];
                                    }
                                ?>
                                </span>
    
                                <div class="content__item-logo">
                                    <i class="fa-solid fa-user content__item-logo-icon"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="content__row">
                    <div style="background-color: var(--yellow-color);" class="content__item">
                    <div class="content__item-container">
                            <h3 class="content__item-headding">
                                Khách hàng
                            </h3>

                            <div class="content__item-body">
                                
                                <span class="content__item-quantity">
                                <?php 
                                    $sql_khachhang = "SELECT COUNT(*) AS total_rows FROM khachhang";
                                    $result_khachhang = mysqli_query($conn, $sql_khachhang);
                                        
                                    if ($result_khachhang) {
                                        $row_khachhang = mysqli_fetch_assoc($result_khachhang);
                                        echo $row_khachhang["total_rows"];
                                    }
                                ?>
                                </span>
    
                                <div class="content__item-logo">
                                    <i class="fa-solid fa-person content__item-logo-icon"></i>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="content__item">
                    <div class="content__item-container">
                            <h3 class="content__item-headding">
                                Thống kê
                            </h3>

                            <div class="content__item-body">
                                
                                <span class="content__item-quantity">
                                    <?php 
                                        $sql_tongtien = "SELECT SUM(tongtien) AS sumMoney FROM hoadon";
                                        $result_tongtien = mysqli_query($conn, $sql_tongtien);
                                            
                                        if ($result_tongtien) {
                                            $row_tongtien = mysqli_fetch_assoc($result_tongtien);
                                            $sumMoney = $row_tongtien["sumMoney"] ? $row_tongtien["sumMoney"] : 0;
    
                                            // Định dạng số cho đẹp
                                            $formattedMoney = number_format($sumMoney, 0, ',', '.');
    
                                            echo $formattedMoney;
                                        }
                                    ?>
                                </span>
    
                                <div class="content__item-logo">
                                    <i class="content__item-logo-icon">VNĐ</i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>