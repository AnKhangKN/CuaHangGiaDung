<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if (isset($_POST['action']) && $_POST['action'] === 'getProductComment') {
    $CustomerId = $_POST['idKhachHang'];
    $ProductId = $_POST['ProductId'];
    $ProductName = $_POST['ProductName'];

    $stmtSelectImg = $conn->prepare("SELECT * FROM hinhanhsanpham hasp
                                    WHERE hasp.idSanPham = ?
                                    LIMIT 1");  
    $stmtSelectImg->bind_param('i', $ProductId);
    $stmtSelectImg->execute();

    $result = $stmtSelectImg->get_result();

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc(); 

        echo json_encode([
            'status' => 'success',
            'idSanPham' => $ProductId,
            'tenSanPham' => $ProductName,
            'hinhanh' => "../public/assets/images/products/". $image['urlhinhanh']
        ]);
    } else {
        echo json_encode([
            'status' => 'failed',
            'message' => 'Không tìm thấy hình ảnh cho sản phẩm'
        ]);
    }

    $stmtSelectImg->close();
} else {
    echo json_encode([
        'status' => 'failed',
        'message' => 'Chưa có sản phẩm'
    ]);
}

$conn->close(); 

?>




