<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/config/connect.php");

// Bật chế độ ngoại lệ cho MySQLi
$conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSanPham = $_POST['idSanPham'] ?? null;
    $idChiTietSanPham = $_POST['idChiTietSanPham'] ?? null;
}

$stmt_ctsp_cthd = $conn->prepare("SELECT * FROM chitiethoadon cthd, chitietsanpham ctsp 
                    WHERE cthd.idChiTietSanPham = ctsp.idChiTietSanPham 
                    AND ctsp.idSanPham = ?
                    AND ctsp.idChiTietSanPham = ?");
$stmt_ctsp_cthd->bind_param("ii", $idSanPham, $idChiTietSanPham);
$stmt_ctsp_cthd->execute();
$result_ctsp_cthd = $stmt_ctsp_cthd->get_result();




if (!$result_ctsp_cthd->num_rows > 0) {
    $stmt3 = $conn->prepare("DELETE hasp FROM hinhanhsanpham hasp JOIN chitietsanpham ctsp 
    ON hasp.idSanPham = ctsp.idSanPham
    WHERE hasp.idSanPham = ?
    AND ctsp.idChiTietSanPham = ?");
    $stmt3->bind_param("ii", $idSanPham, $idChiTietSanPham);
    $stmt3->execute();

    $stmt1 = $conn->prepare("DELETE ctsp FROM chitietsanpham ctsp WHERE ctsp.idChiTietSanPham = ? AND ctsp.idSanPham = ?");
    $stmt1->bind_param("ii",$idChiTietSanPham, $idSanPham);
    $stmt1->execute();

    $stmt2 = $conn->prepare("DELETE sp FROM sanpham sp JOIN chitietsanpham ctsp
    ON sp.idSanPham = ctsp.idSanPham 
    WHERE ctsp.idChiTietSanPham = ?");
    $stmt2->bind_param("i", $idChiTietSanPham);
    $stmt2->execute();

    echo "<script>
            alert('Đã xóa sản phẩm thành công');
            window.location.href = '/CuaHangDungCu/public/manager/index.php?page=sanpham';
            </script>";
} else {
    echo "<script>
            alert('Không thể xóa sản phẩm đã được bán');
            window.location.href = '/CuaHangDungCu/public/manager/index.php?page=sanpham';
            </script>";
}
