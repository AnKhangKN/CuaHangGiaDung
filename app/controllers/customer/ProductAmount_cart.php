<?php

require_once "customerController.php";
require_once "../../../config/connectdb.php";

if (isset($_POST['size']) && isset($_POST['color']) && isset($_POST['productId'])) {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $productID = $_POST['productId'];

    // Gọi hàm để lấy số lượng và ID chi tiết sản phẩm
    $result = getProductAmount($productID, $size, $color);

    if ($result) {
        // Trả về số lượng và ID, phân tách bởi dấu '|'
        echo $result['amount'] . "|" . $result['id'];
    } else {
        echo '0|0'; // Trả về '0|0' nếu không có sản phẩm
    }

} else {
    echo 'Dữ liệu đầu vào không hợp lệ';
}

?>
