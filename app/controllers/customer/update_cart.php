<?php

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Kiểm tra và lấy dữ liệu từ POST
    $productId = $_POST['productId'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $quantity = (int) $_POST['quantity'];

    // Đọc giỏ hàng từ cookie
    $cart = array();
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
    }

    // Tạo khóa duy nhất cho sản phẩm dựa trên id, size, và color (để phân biệt các sản phẩm giống nhau nhưng khác size, color)
    $key = $productId . '-' . $size . '-' . $color;

    // Cập nhật số lượng cho sản phẩm trong giỏ hàng
    if (isset($cart[$key])) {
        // Cập nhật số lượng của sản phẩm
        $cart[$key]['soluong'] = $quantity; // Cập nhật số lượng mới
        
        if($quantity <= 0){
            unset($cart[$key]);

            // Cập nhật cookie với mảng giỏ hàng mới
            setcookie('cart', json_encode($cart), time() + (86400 * 30), "/"); // Lưu lại giỏ hàng mới trong 30 ngày

            echo "Sản phẩm đã được xóa khỏi giỏ hàng!";
        }
    }

    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/"); 

    echo "Giỏ hàng đã được cập nhật!";
} else {
    echo "Không có dữ liệu giỏ hàng!";
}
?>

