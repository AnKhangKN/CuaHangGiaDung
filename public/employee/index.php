<?php

include "../../config/connectdb.php";

include '../../app/views/employee/include/header.php';

// Kiểm tra và xử lý giá trị 'page'
if (isset($_GET['page'])) {
    $page = basename($_GET['page']); // Loại bỏ ký tự không hợp lệ để tránh LFI
} else {
    $page = 'sanpham'; // Trang mặc định
}

// Đường dẫn tới file
$pagePath = "../../app/views/employee/{$page}.php";

// Kiểm tra file có tồn tại không
if (file_exists($pagePath)) {
    include $pagePath; // Bao gồm nội dung file
} else {
    echo "<p>Trang không tồn tại. Vui lòng kiểm tra lại URL.</p>";
}

include '../../app/views/employee/include/footer.php';

?>
