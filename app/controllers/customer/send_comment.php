<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if (isset($_POST['action']) && $_POST['action'] === "sendComment") {
    $CustomerId = intval($_POST['idKhachHang']);
    $ProductId = intval($_POST['productId']);
    $ContentComment = trim($_POST['comment']);

    if (empty($CustomerId) || empty($ProductId) || empty($ContentComment)) {
        echo json_encode(["status" => "error", "message" => "Lỗi bình luận hoặc bạn thiếu thông tin."]);
        exit;
    }

    $stmtComment = $conn->prepare("INSERT INTO binhluan (noidung, idSanPham, idKhachHang) 
                                    VALUES (?, ?, ?)");

    if ($stmtComment) {
        $stmtComment->bind_param('sii', $ContentComment, $ProductId, $CustomerId);
        
        if ($stmtComment->execute()) {
            echo json_encode(["status" => "success", "message" => "Bình luận thành công!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Đã xảy ra lỗi hãy thử lại lần sau!"]);
        }

        $stmtComment->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Thiếu bình luận!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi hãy thử lại sau!"]);
}

?>