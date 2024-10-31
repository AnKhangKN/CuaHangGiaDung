<?php
// Bắt đầu session
session_start();
include 'C:/xampp/htdocs/CuaHangDungCu/config/session.php'; // Quản lý session
include 'C:/xampp/htdocs/CuaHangDungCu/config/connectdb.php'; // Kết nối cơ sở dữ liệu

// Kết nối cơ sở dữ liệu
$conn = connectBD(); // Giả sử bạn đã sửa để trả về kết nối từ hàm connectBD

// Bao gồm header
include(__DIR__ . '/app/views/customer/include/header.php');

// Kiểm tra xem có tham số 'page' trong URL không
if (!isset($_GET['page'])) {
    // Nếu không có, hiển thị trang chính (home)
    include(__DIR__ . '/app/views/customer/home.php');
} else {
    // Lấy tên trang từ tham số 'page', sử dụng basename để bảo mật
    $page = basename($_GET['page']);
    $pagePath = __DIR__ . '/app/views/customer/' . $page . '.php'; // Đường dẫn mặc định cho trang

    // Nếu page là 'details', xử lý lấy id sản phẩm
    if ($page === 'details' && isset($_GET['id'])) {
        $productId = intval($_GET['id']); // Lấy id sản phẩm từ URL và chuyển thành số nguyên
        $pagePath = __DIR__ . '/app/views/customer/details.php'; // Đường dẫn cho trang chi tiết sản phẩm
    }

    // Nếu page là 'information', kiểm tra session
    if ($page === 'information') {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: /CuaHangDungCu/app/views/customer/login.php");
            exit();
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

// Bao gồm footer
include(__DIR__ . '/app/views/customer/include/footer.php');

// Đóng kết nối
mysqli_close($conn);
?>
