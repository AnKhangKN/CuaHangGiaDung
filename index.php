<?php
    include 'config/connectdb.php';

    // Kết nối cơ sở dữ liệu
    $conn = connectBD(); // Giả sử bạn đã sửa để trả về kết nối từ hàm connectBD

    include(__DIR__ . '/app/views/customer/include/header.php');

    if(!isset($_GET['page'])) {
        include(__DIR__ . '/app/views/customer/home.php');
    } else {
        $page = basename($_GET['page']); // Chỉ lấy tên tệp tin an toàn

        // Nếu page là details, xử lý lấy id sản phẩm
        if ($page === 'details' && isset($_GET['id'])) {
            $productId = intval($_GET['id']); // Lấy id sản phẩm từ URL và chuyển thành số nguyên
            $pagePath = __DIR__ . '/app/views/customer/details.php';
        } else {
            $pagePath = __DIR__ . '/app/views/customer/' . $page . '.php';
        }

        // Kiểm tra nếu tệp tin tồn tại
        if (file_exists($pagePath)) {
            include($pagePath);
        } else {
            include(__DIR__ . '/app/views/customer/404.php'); // Tệp tin 404 nếu không tìm thấy
        }
    }

    include(__DIR__ . '/app/views/customer/include/footer.php');

    // Đóng kết nối
    mysqli_close($conn);
?>



