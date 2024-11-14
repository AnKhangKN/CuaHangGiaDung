<?php
session_start(); // Bắt đầu session

// Kiểm tra dữ liệu gửi từ client (jQuery)
if (isset($_POST['productId'], $_POST['tenSP'], $_POST['gia'], $_POST['size'], $_POST['color'], $_POST['soluong'])) {
    
    // Lấy dữ liệu từ POST
    $urlHinhAnh = $_POST['urlHinhAnh'];
    $tenSP = $_POST['tenSP'];
    $gia = $_POST['gia'];
    $size = $_POST['size'];
    $mau = $_POST['color'];
    $soluong = $_POST['soluong'];
    $idSanPham = $_POST['productId'];

    // Kiểm tra nếu giỏ hàng chưa tồn tại trong session thì tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array(); 
    }

    // Tạo khóa duy nhất cho mỗi sự kết hợp sản phẩm dựa trên idSanPham, size và color
    $key = $idSanPham . '-' . $size . '-' . $mau;

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($_SESSION['cart'][$key])) {
        // Nếu sản phẩm đã có trong giỏ hàng và có cùng size và color, cộng thêm số lượng
        $_SESSION['cart'][$key]['soluong'] += $soluong;
    } else {
        // Nếu sản phẩm có size và color khác, thêm mới với các chi tiết đầy đủ
        $_SESSION['cart'][$key] = array(
            'idSanPham' => $idSanPham,
            'tenSP' => $tenSP,
            'gia' => $gia,
            'size' => $size,
            'color' => $mau,
            'soluong' => $soluong,
            'urlHinhAnh' => $urlHinhAnh,
        );
    }

    echo "Sản phẩm đã được thêm vào giỏ hàng!";
} else {
    echo "Thiếu dữ liệu sản phẩm!";
}
?>
