<?php include "../../config/connect.php"; ?>
<main class="content">
  <h2>Trang chủ</h2>
  <div class="row g-4 mt-3">
    
    <!-- Tổng danh mục -->
    <div class="col-md-6 col-lg-4">
      <div class="card card-stat shadow-sm" style="background-color: var(--blue-color);">
        <div class="card-body">
          <h5 class="card-title">Danh mục</h5>
          <p class="card-text display-6">
            <?php 
              $sql_danhmuc = "SELECT COUNT(*) AS total_rows FROM danhmucsanpham";
              $result_danhmuc = mysqli_query($conn, $sql_danhmuc);
              if ($result_danhmuc) {
                  $row_danhmuc = mysqli_fetch_assoc($result_danhmuc);
                  echo $row_danhmuc["total_rows"];
              }
            ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Tổng nhân viên -->
    <div class="col-md-6 col-lg-4">
      <div class="card card-stat shadow-sm" style="background-color: var(--green-color);">
        <div class="card-body">
          <h5 class="card-title">Nhân viên</h5>
          <p class="card-text display-6">
            <?php 
              $sql_nhanvien = "SELECT COUNT(*) AS total_rows FROM nhanvien";
              $result_nhanvien = mysqli_query($conn, $sql_nhanvien);
              if ($result_nhanvien) {
                  $row_nhanvien = mysqli_fetch_assoc($result_nhanvien);
                  echo $row_nhanvien["total_rows"];
              }
            ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Tổng khách hàng -->
    <div class="col-md-6 col-lg-4">
      <div class="card card-stat shadow-sm" style="background-color: var(--yellow-color);">
        <div class="card-body">
          <h5 class="card-title">Khách hàng</h5>
          <p class="card-text display-6">
            <?php 
              $sql_khachhang = "SELECT COUNT(*) AS total_rows FROM khachhang";
              $result_khachhang = mysqli_query($conn, $sql_khachhang);
              if ($result_khachhang) {
                  $row_khachhang = mysqli_fetch_assoc($result_khachhang);
                  echo $row_khachhang["total_rows"];
              }
            ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Tổng doanh thu -->
    <div class="col-md-6 col-lg-6">
      <div class="card card-stat shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Tổng doanh thu</h5>
          <p class="card-text display-6">
            <?php 
              $sql_tongtien = "SELECT SUM(tongtien) AS sumMoney FROM hoadon";
              $result_tongtien = mysqli_query($conn, $sql_tongtien);
              if ($result_tongtien) {
                  $row_tongtien = mysqli_fetch_assoc($result_tongtien);
                  $sumMoney = $row_tongtien["sumMoney"] ?? 0;
                  echo number_format($sumMoney, 0, ',', '.') . '₫';
              }
            ?>
          </p>
        </div>
      </div>
    </div>

  </div>
</main>