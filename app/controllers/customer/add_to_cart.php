<?php
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

    // Đọc giỏ hàng từ cookie nếu có
    $cart = array();
    if (isset($_COOKIE['cart'])) {
        // Giải mã JSON từ cookie thành mảng
        $cart = json_decode($_COOKIE['cart'], true);
    }

    // Tạo khóa duy nhất cho mỗi sự kết hợp sản phẩm dựa trên idSanPham, size và color
    $key = $idSanPham . '-' . $size . '-' . $mau;

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($cart[$key])) {
        // Nếu sản phẩm đã có trong giỏ hàng và có cùng size và color, cộng thêm số lượng
        $cart[$key]['soluong'] += $soluong;
    } else {
        // Nếu sản phẩm có size và color khác, thêm mới với các chi tiết đầy đủ
        $cart[$key] = array(
            'idSanPham' => $idSanPham,
            'tenSP' => $tenSP,
            'gia' => $gia,
            'size' => $size,
            'color' => $mau,
            'soluong' => $soluong,
            'urlHinhAnh' => $urlHinhAnh,
        );
    }

    // Mã hóa mảng giỏ hàng thành JSON và lưu vào cookie
    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/"); // Cookie có thời hạn 30 ngày

    echo "Sản phẩm đã được thêm vào giỏ hàng!";
} else {
    echo "Thiếu dữ liệu sản phẩm!";
}
?>
