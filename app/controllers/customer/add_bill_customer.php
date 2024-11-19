<?php
require_once "../../../config/connectdb.php"; // Gọi file kết nối cơ sở dữ liệu

if (isset($_POST['action']) && $_POST['action'] == 'CustomerId') {
    // Kết nối cơ sở dữ liệu
    $conn = connectBD();
    
    // Bắt đầu giao dịch
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        // Lấy dữ liệu từ AJAX
        $idKhachHang = $_POST['idKhachHang'];
        $tongtien = $_POST['tongtien'];
        $ghichu = $_POST['ghichu'];
        $idNhanVien = 3; // Có thể thay đổi theo yêu cầu
        $detail = json_decode($_POST['products'], true); // Array chứa các chi tiết hóa đơn

        // Bước 1: Insert hóa đơn
        $stmt = $conn->prepare("INSERT INTO hoadon (tongtien, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $tongtien, $ghichu, $idNhanVien, $idKhachHang);
        $stmt->execute();

        // Lấy ID của hóa đơn vừa insert
        $idHoaDon = $conn->insert_id;

        // Bước 2: Insert chi tiết hóa đơn
        $stmt = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");

        foreach ($detail as $item) {
            $stmt->bind_param("iii", $item['soluong'], $idHoaDon, $item['idChiTietSanPham']);
            $stmt->execute();
        }

        // Commit giao dịch
        $conn->commit();

        // Trả về ID hóa đơn cho AJAX
        echo json_encode(["status" => "success", "idHoaDon" => $idHoaDon]);

    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    // Đóng kết nối sau khi xong
    mysqli_close($conn);

} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}
?>
