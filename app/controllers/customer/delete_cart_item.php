<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'remove' && isset($_POST['productId']) && isset($_POST['size']) && isset($_POST['color'])) {
    $productId = $_POST['productId'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    // Tạo khóa duy nhất cho sản phẩm dựa trên productId, size và color
    $key = $productId . '-' . $size . '-' . $color;

    // Kiểm tra nếu giỏ hàng tồn tại trong session
    if (isset($_SESSION['cart'][$key])) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$key]);

        // Trả về thông báo thành công
        echo "Sản phẩm đã được xóa khỏi giỏ hàng!";
    } else {
        // Trường hợp sản phẩm không tồn tại trong giỏ hàng
        echo "Sản phẩm không có trong giỏ hàng!";
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}
?>



