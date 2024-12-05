<?php
require_once "../../../config/connectdb.php";
require_once "all_function.php";

if (isset($_POST['action']) && $_POST['action'] === 'select') {

    // Kiểm tra các tham số đầu vào
    $size = isset($_POST['size']) ? $_POST['size'] : "không có kích thước";
    $color = isset($_POST['color']) ? $_POST['color'] : null;
    $productID = isset($_POST['productId']) ? intval($_POST['productId']) : null;

    // Kiểm tra điều kiện hợp lệ của các tham số
    if ($productID && $color) {
        // Gọi hàm lấy số lượng và ID chi tiết sản phẩm
        $result = getProductAmount($productID, $size, $color); 

        if ($result) {
            // Nếu tìm thấy, trả về số lượng và ID
            echo $result['amount'] . "|" . $result['id'];
        } else {
            // Nếu không tìm thấy sản phẩm, trả về thông báo
            echo "Không tìm thấy sản phẩm.";
        }
    } else {
        // Nếu tham số không hợp lệ
        echo "Dữ liệu đầu vào không hợp lệ.";
    }

} else {
    // Nếu không phải yêu cầu hợp lệ
    echo "Yêu cầu không hợp lệ.";
}
?>
