<?php
// Bắt đầu session
session_start();
ob_start();
include 'C:/xampp/htdocs/CuaHangDungCu/config/session.php'; // Quản lý session
include 'C:/xampp/htdocs/CuaHangDungCu/config/connectdb.php'; // Kết nối cơ sở dữ liệu

$conn = connectBD(); // Giả sử bạn đã sửa để trả về kết nối từ hàm connectBD


include(__DIR__ . '/app/views/customer/include/header.php');

if (!isset($_GET['page'])) {
    
    include(__DIR__ . '/app/views/customer/home.php');
} else {
    $page = basename($_GET['page']);
    $pagePath = __DIR__ . '/app/views/customer/' . $page . '.php'; 

    if ($page === 'details' && isset($_GET['id'])) {
        $productId = intval($_GET['id']);
        $pagePath = __DIR__ . '/app/views/customer/details.php'; 
    } 

    if($page === 'details_bill' && isset($_GET['idBill'])){
        $billId = intval($_GET['idBill']);
        $pagePath = __DIR__ . '/app/views/customer/details_bill.php'; 
    }

    if ($page === 'information') {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: http://localhost/CuaHangDungCu/app/views/others/login.php');
            exit;
        }
    }

    // Kiểm tra nếu tệp tin tồn tại
    if (file_exists($pagePath)) {
        include($pagePath); // Bao gồm trang được yêu cầu
    } else {
        // Nếu không tìm thấy trang, bao gồm trang 404
        echo 'không tìm thấy trang';
    }
}

include(__DIR__ . '/app/views/customer/include/footer.php');

mysqli_close($conn);
?>
