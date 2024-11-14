<?php
if (isset($_POST['action']) && $_POST['action'] == 'remove' && isset($_POST['productId']) && isset($_POST['size']) && isset($_POST['color'])) {
    $productId = $_POST['productId'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    // Tạo khóa duy nhất cho sản phẩm dựa trên productId, size và color
    $key = $productId . '-' . $size . '-' . $color;

    // Kiểm tra nếu giỏ hàng tồn tại trong cookie `cart`
    if (isset($_COOKIE['cart'])) {
        // Giải mã JSON từ cookie thành mảng
        $cart = json_decode($_COOKIE['cart'], true);

        // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
        if (isset($cart[$key])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$key]);

            // Cập nhật cookie với mảng giỏ hàng mới
            setcookie('cart', json_encode($cart), time() + (86400 * 30), "/"); // Lưu lại giỏ hàng mới trong 30 ngày

            // Trả về thông báo thành công
            echo "Sản phẩm đã được xóa khỏi giỏ hàng!";
        } else {
            // Trường hợp sản phẩm không tồn tại trong giỏ hàng
            echo "Sản phẩm không có trong giỏ hàng!";
        }
    } else {
        // Trường hợp giỏ hàng không tồn tại
        echo "Giỏ hàng trống!";
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}
?>
