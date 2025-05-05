<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

// Bật chế độ ngoại lệ cho MySQLi
$conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDanhMuc = $_POST['idDanhMuc'] ?? null;
}


try {
    $sql_delete_danhmuc = "DELETE FROM danhmucsanpham WHERE idDanhMuc = ?";
    $stmt_delete_danhmuc = $conn->prepare($sql_delete_danhmuc);
    $stmt_delete_danhmuc->bind_param("i", $idDanhMuc);
    $stmt_delete_danhmuc->execute();

    echo "<script>
    alert('Đã xóa danh mục thành công');
    window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=danhmuc';
    </script>";
} catch (Exception $e) {
    // Nếu xảy ra lỗi, hiển thị thông báo và quay lại trang ban đầu
    echo "<script>
    alert('Không thể xóa danh mục đã được sử dụng.');
    window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=danhmuc';
    </script>";
}
