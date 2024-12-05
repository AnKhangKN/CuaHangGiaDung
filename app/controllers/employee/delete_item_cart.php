<?php
if (isset($_POST['action']) && $_POST['action'] === 'remove_cart') {
    // Lấy và kiểm tra dữ liệu
    $productId = isset($_POST['idSanPham']) ? $_POST['idSanPham'] : null;
    $idChiTietSanPham = isset($_POST['idChiTietSanPham']) ? $_POST['idChiTietSanPham'] : null;
    $size = isset($_POST['kichthuoc']) ? $_POST['kichthuoc'] : null;
    $color = isset($_POST['mau']) ? $_POST['mau'] : null;

    if (!$productId || !$idChiTietSanPham || !$size || !$color) {
        echo "Dữ liệu không hợp lệ!"; 
        exit;
    }

    // Tạo key duy nhất cho sản phẩm
    $key = $productId . '-' . $idChiTietSanPham . '-' . $color . '-' . $size;

    // Kiểm tra giỏ hàng trong cookie
    if (isset($_COOKIE['cart_e'])) {
        $cart = json_decode($_COOKIE['cart_e'], true);

        // Kiểm tra lỗi giải mã JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Lỗi khi giải mã giỏ hàng: " . json_last_error_msg();
            exit;
        }

        // Kiểm tra sản phẩm có trong giỏ hàng không
        if (isset($cart[$key])) {
            unset($cart[$key]); // Xóa sản phẩm khỏi giỏ hàng
            $updatedCart = json_encode($cart, JSON_UNESCAPED_UNICODE);
            setcookie('cart_e', $updatedCart, time() + (86400 * 30), "/");

            echo "Sản phẩm đã được xóa khỏi giỏ hàng!";
        } else {
            echo "Sản phẩm không tồn tại trong giỏ hàng!";
        }
    } else {
        echo "Giỏ hàng trống!";
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}
?>
