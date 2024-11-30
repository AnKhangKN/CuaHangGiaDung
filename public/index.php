<?php 

session_start();
ob_start();

include 'C:/xampp/htdocs/CuaHangDungCu/config/session.php';
include 'C:/xampp/htdocs/CuaHangDungCu/config/connectdb.php'; 

$conn = connectBD(); 

include (__DIR__ . '../../app/views/customer/include/header.php');
if (isset($_GET['page'])) {
    $page = basename($_GET['page']);
} else {
    $page = 'home';
}

$pagePath = __DIR__ . "../../app/views/customer/{$page}.php";

// Xử lý các trang yêu cầu tham số bổ sung
if ($page === 'details' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $pagePath = __DIR__ . '../../app/views/customer/details.php';
}

if ($page === 'details_bill' && isset($_GET['idBill'])) {
    $billId = intval($_GET['idBill']);
    $pagePath = __DIR__ . '../../app/views/customer/details_bill.php';
}

// Kiểm tra xác thực cho trang thông tin người dùng
if ($page === 'information') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /CuaHangDungCu/app/views/others/login.php');
        exit;
    }
}

// Kiểm tra nếu tệp tin tồn tại, nếu không chuyển hướng đến trang 404
if (file_exists($pagePath)) {
    include($pagePath);
} else {
    // Chuyển hướng đến trang 404 nếu tệp không tồn tại
    header('Location: /CuaHangDungCu/app/views/customer/404.php');
    exit;
}

include (__DIR__ . '../../app/views/customer/include/footer.php');

mysqli_close($conn);

?>