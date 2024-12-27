<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/connect.php");

// Bật chế độ ngoại lệ cho MySQLi
$conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSanPham = $_POST['idSanPham'] ?? null;
}

$sql_chitietsanpham = "SELECT * FROM chitietsanpham WHERE idSanPham = " . $idSanPham;
$result_chitietsanpham = mysqli_query($conn, $sql_chitietsanpham);

try {


    if ($result_chitietsanpham->num_rows > 0) {
        $stmt1 = $conn->prepare("DELETE FROM chitietsanpham WHERE idSanPham = ?");
        $stmt1->bind_param("i", $idSanPham);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM SanPham WHERE idSanPham = ?");
        $stmt2->bind_param("i", $idSanPham);
        $stmt2->execute();
    } else {
        $stmt2 = $conn->prepare("DELETE FROM SanPham WHERE idSanPham = ?");
        $stmt2->bind_param("i", $idSanPham);
        $stmt2->execute();
    }

    header("location: /CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham");
} catch (Exception $e) {
    // Nếu xảy ra lỗi, hiển thị thông báo và quay lại trang ban đầu
    if (!($result_chitietsanpham->num_rows) > 0) {
        header("location: /CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham");
    } else {
        $conn->rollback();
        echo "<script>
            alert('Không thể xóa sản phẩm đã được bán');
            window.location.href = '/CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham';
            </script>";
    }
}
