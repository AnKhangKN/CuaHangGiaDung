<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/connect.php");

// Biến mặc định
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';


// 1. Tổng doanh thu theo ngày
$sql_revenue_per_day = "SELECT DATE(hd.ngayxuathoadon) AS date, SUM(hd.tongtien) AS total
                        FROM hoadon hd
                        WHERE (DATE(hd.ngayxuathoadon) BETWEEN ? AND ?) OR (? = '' AND ? = '')
                        GROUP BY DATE(hd.ngayxuathoadon)
                        ORDER BY date";
$stmt = $conn->prepare($sql_revenue_per_day);
$stmt->bind_param('ssss', $startDate, $endDate, $startDate, $endDate);
$stmt->execute();
$revenuePerDay = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// 2. Lượng sản phẩm bán chạy theo tháng/năm
$sql_sales_per_month = "SELECT MONTH(hd.ngayxuathoadon) AS month, YEAR(hd.ngayxuathoadon) AS year, SUM(cthd.soluong) AS total_quantity
                        FROM hoadon hd
                        JOIN chitiethoadon cthd ON hd.idHoaDon = cthd.idHoaDon
                        GROUP BY year, month
                        ORDER BY year, month";
$salesPerMonth = $conn->query($sql_sales_per_month)->fetch_all(MYSQLI_ASSOC);

// 3. Sản phẩm bán chạy
$sql_top_products = "SELECT sp.tensanpham, SUM(cthd.soluong) AS total_quantity
                    FROM chitiethoadon cthd
                    JOIN chitietsanpham ctsp ON cthd.idChiTietSanPham = ctsp.idChiTietSanPham
                    JOIN sanpham sp ON ctsp.idSanPham = sp.idSanPham
                    GROUP BY sp.idSanPham
                    ORDER BY total_quantity DESC
                    LIMIT 5";
$topProducts = $conn->query($sql_top_products)->fetch_all(MYSQLI_ASSOC);

// 4. Nhân viên ưu tú
$sql_top_employees = "SELECT nv.tennhanvien AS employee_name, COUNT(hd.idHoaDon) AS total_orders
                    FROM hoadon hd
                    JOIN nhanvien nv ON hd.idNhanVien = nv.idNhanVien
                    GROUP BY nv.idNhanVien
                    ORDER BY total_orders DESC
                    LIMIT 5";
$topEmployees = $conn->query($sql_top_employees)->fetch_all(MYSQLI_ASSOC);

// 5. Khách hàng tiềm năng
$sql_top_customers = "SELECT kh.tenkhachhang AS customer_name, COUNT(hd.idHoaDon) AS total_orders
                    FROM hoadon hd
                    JOIN khachhang kh ON hd.idKhachHang = kh.idKhachHang
                    GROUP BY kh.idKhachHang
                    ORDER BY total_orders DESC
                    LIMIT 5";
$topCustomers = $conn->query($sql_top_customers)->fetch_all(MYSQLI_ASSOC);
?>


<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Thống kê
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>
        </div>
        <div class="container__thongke">

            <!-- Form chọn khoảng thời gian -->
            <form method="POST" class="thongke_form">
                <label for="start_date">Từ ngày:</label>
                <input class="thongke_form_input" type="date" id="start_date" required name="start_date" value="<?php echo $startDate; ?>">
                <label for="end_date">Đến ngày:</label>
                <input class="thongke_form_input" type="date" id="end_date" required name="end_date" value="<?php echo $endDate; ?>">
                <input class="thongke_form_submit" type="submit" value="Hiển thị">
            </form>


            <!-- Biểu đồ thu nhỏ -->
            <div class="charts-row">
                <div class="chart-small" onclick="openModal('revenueChart')">
                    <h4>Tổng Doanh Thu</h4>
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="chart-small" onclick="openModal('salesChart')">
                    <h4>Sản Phẩm Bán Theo Tháng/Năm</h4>
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="chart-small" onclick="openModal('topProductsChart')">
                    <h4>Sản Phẩm Bán Chạy Nhất</h4>
                    <canvas id="topProductsChart"></canvas>
                </div>
                <div class="chart-small" onclick="openModal('topEmployeesChart')">
                    <h4>Nhân Viên Ưu Tú</h4>
                    <canvas id="topEmployeesChart"></canvas>
                </div>
                <div class="chart-small" onclick="openModal('topCustomersChart')">
                    <h4>Khách Hàng Tiềm Năng</h4>
                    <canvas id="topCustomersChart"></canvas>
                </div>
            </div>

            <script>
                // Dữ liệu từ PHP
                const salesData = <?php echo json_encode($salesPerMonth); ?>;
                const salesLabels = salesData.map(item => `Tháng ${item.month}/${item.year}`);
                const salesValues = salesData.map(item => item.total_quantity);

                const revenueData = <?php echo json_encode($revenuePerDay); ?>;
                const revenueLabels = revenueData.map(item => item.date);
                const revenueValues = revenueData.map(item => item.total);

                const topProductsData = <?php echo json_encode($topProducts); ?>;
                const topProductsLabels = topProductsData.map(item => item.tensanpham);
                const topProductsValues = topProductsData.map(item => item.total_quantity);

                const topEmployeesData = <?php echo json_encode($topEmployees); ?>;
                const topEmployeesLabels = topEmployeesData.map(item => item.employee_name);
                const topEmployeesValues = topEmployeesData.map(item => item.total_orders);

                const topCustomersData = <?php echo json_encode($topCustomers); ?>;
                const topCustomersLabels = topCustomersData.map(item => item.customer_name);
                const topCustomersValues = topCustomersData.map(item => item.total_orders);

                // Vẽ biểu đồ
                const ctxSales = document.getElementById('salesChart').getContext('2d');
                new Chart(ctxSales, {
                    type: 'bar',
                    data: {
                        labels: salesLabels,
                        datasets: [{
                            label: 'Số lượng',
                            data: salesValues,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }]
                    },
                });

                const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctxRevenue, {
                    type: 'line',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Doanh thu (VNĐ)',
                            data: revenueValues,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false
                        }]
                    },
                });

                const ctxTopProducts = document.getElementById('topProductsChart').getContext('2d');
                new Chart(ctxTopProducts, {
                    type: 'pie',
                    data: {
                        labels: topProductsLabels,
                        datasets: [{
                            label: 'Số lượng',
                            data: topProductsValues,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                        }]
                    },
                });

                const ctxTopEmployees = document.getElementById('topEmployeesChart').getContext('2d');
                new Chart(ctxTopEmployees, {
                    type: 'bar',
                    data: {
                        labels: topEmployeesLabels,
                        datasets: [{
                            label: 'Số hóa đơn',
                            data: topEmployeesValues,
                            backgroundColor: 'rgba(153, 102, 255, 0.6)'
                        }]
                    },
                });

                const ctxTopCustomers = document.getElementById('topCustomersChart').getContext('2d');
                new Chart(ctxTopCustomers, {
                    type: 'doughnut',
                    data: {
                        labels: topCustomersLabels,
                        datasets: [{
                            label: 'Số hóa đơn',
                            data: topCustomersValues,
                            backgroundColor: ['#FF9F40', '#FF6384', '#36A2EB', '#FFCE56', '#9966FF']
                        }]
                    },
                });
            </script>
        </div>
    </div>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/footer.php");
    ?>