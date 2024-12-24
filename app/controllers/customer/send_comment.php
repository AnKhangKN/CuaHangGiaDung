<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if (isset($_POST['action']) && $_POST['action'] === "sendComment") {
    // Lấy dữ liệu từ POST
    $CustomerId = $_POST['idKhachHang'] ?? null;
    $ProductId = $_POST['productId'] ?? null;
    $ContentComment = $_POST['comment'] ?? null;
    $BillId = $_POST['billId'] ?? null;

    // Kiểm tra dữ liệu bắt buộc
    if (empty($CustomerId) || empty($ProductId) || empty($ContentComment)) {
        echo json_encode(["status" => "error", "message" => "Thiếu thông tin cần thiết."]);
        exit;
    }

    // Chuẩn bị câu truy vấn
    $stmtComment = $conn->prepare("INSERT INTO binhluan (noidung, idSanPham, idKhachHang, idHoaDon) 
                                VALUES (?, ?, ?, ?)");

    if ($stmtComment) {
        // Liên kết tham số và thực thi truy vấn
        $stmtComment->bind_param('siii', $ContentComment, $ProductId, $CustomerId, $BillId);

        if ($stmtComment->execute()) {
            echo json_encode(["status" => "success", "message" => "Bình luận thành công!"]);
        } else {
            // Trả về thông báo lỗi từ SQL
            echo json_encode([
                "status" => "error", 
                "message" => "Không thể thêm bình luận: " . $stmtComment->error
            ]);
        }

        $stmtComment->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Không thể chuẩn bị truy vấn."]);
    }

    $conn->close(); // Đóng kết nối
} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ."]);
}

?>
