<?php 
// Bao gồm header
include(__DIR__ . '/include/header.php'); 

// Kiểm tra xem tham số 'page' có được gửi trong URL hay không
if (!isset($_GET['page']) || empty($_GET['page'])) {
    // Nếu không có tham số 'page', hiển thị trang mặc định (sanpham)
    include(__DIR__ . '/sanpham.php');
} else {
    // Lấy tên trang từ tham số 'page', sử dụng basename để bảo mật
    $page = basename($_GET['page']);
    
    // Đường dẫn đến trang, thêm một dấu '/' trước $page để đảm bảo đúng đường dẫn
    $pagePath = __DIR__ . '/' . $page . '.php'; 

    // Kiểm tra nếu tệp tin tồn tại và tránh các tệp không an toàn
    if (file_exists($pagePath) && strpos($page, '..') === false) {
        include($pagePath); // Bao gồm trang được yêu cầu
    } else {
        // Nếu không tìm thấy trang, hiển thị thông báo 404
        echo '<h2>Không tìm thấy trang</h2>';
    }
}

// Bao gồm footer
include(__DIR__ . '/include/footer.php'); 
?>

