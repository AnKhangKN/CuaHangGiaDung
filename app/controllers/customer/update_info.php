<?php
require_once "customerController.php";
require_once "../../../config/connectdb.php";

// Kiểm tra nếu yêu cầu có action là 'changeInfo'
if (isset($_POST['action']) && $_POST['action'] === 'changeInfo') {
    // Lấy dữ liệu từ POST
    $changeItem = $_POST['inputName'] ?? null;
    $itemValue = $_POST['inputValue'] ?? null;
    $customerId = $_POST['idKhachHang'] ?? null;

    // Kiểm tra các giá trị có tồn tại hay không
    if (!$changeItem || !$itemValue || !$customerId) {
        // Trả về lỗi nếu dữ liệu không hợp lệ
        echo json_encode([
            'success' => false,
            'message' => 'Thiếu dữ liệu cần thiết để cập nhật thông tin.'. $changeItem . $itemValue . $customerId
        ]);
        exit;
    }

    // Gọi hàm updateInfo để xử lý cập nhật
    $updateResult = updateInfo($changeItem, $itemValue, $customerId);

    // Trả về kết quả
    if ($updateResult) {
        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Cập nhật thông tin thất bại. Vui lòng thử lại sau.'
        ]);
    }
}
?>


