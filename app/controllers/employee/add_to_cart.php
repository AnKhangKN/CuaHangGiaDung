<?php

if (isset($_POST['action']) && $_POST['action'] === 'add_cart') {
    
    $idSanPham = $_POST['idSanPham'];
    $tenSanPham = $_POST['tenSanPham'];
    $soluong = $_POST['soluong'];
    $dongia = $_POST['dongia'];
    $idChiTietSanPham = $_POST['idChiTietSanPham'];
    $mau = $_POST['mau'];
    $kichthuoc = $_POST['kichthuoc'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($idSanPham) || empty($tenSanPham) || empty($soluong) || empty($dongia) || empty($idChiTietSanPham) || empty($mau) || empty($kichthuoc)) {
        echo "Thiếu dữ liệu sản phẩm hoặc thuộc tính!";
        exit;
    }

    // Đọc giỏ hàng từ cookie nếu có
    $cart = array();
    if (isset($_COOKIE['cart_e'])) {
        // Giải mã JSON từ cookie thành mảng
        $cart = json_decode($_COOKIE['cart_e'], true);
    }

    // Tạo khóa duy nhất cho mỗi sự kết hợp sản phẩm dựa trên idSanPham, idChiTietSanPham, màu và kích thước
    $key = $idSanPham . '-' . $idChiTietSanPham . '-' . $mau . '-' . $kichthuoc;

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($cart[$key])) {
        // Nếu sản phẩm đã có trong giỏ hàng, cộng thêm số lượng
        $cart[$key]['soluong'] += $soluong;
    } else {
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới với các chi tiết đầy đủ
        $cart[$key] = array(
            'idSanPham' => $idSanPham,
            'idChiTietSanPham' => $idChiTietSanPham,
            'tenSanPham' => $tenSanPham,  
            'dongia' => $dongia,          
            'soluong' => $soluong,
            'mau' => $mau,
            'kichthuoc' => $kichthuoc
        );
    }

    // Mã hóa mảng giỏ hàng thành JSON và lưu vào cookie
    setcookie('cart_e', json_encode($cart), time() + (86400 * 30), "/"); // Cookie có thời hạn 30 ngày

    echo "Sản phẩm đã được thêm vào giỏ hàng!";
} else {
    echo "Thiếu dữ liệu sản phẩm!";
}
?>
