<?php
require_once "../../../config/connectdb.php"; 

if (isset($_POST['action']) && $_POST['action'] == 'CustomerId') {
    
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE); // Bắt đầu giao dịch

    try {
        $idKhachHang = intval($_POST['idKhachHang']);
        $tongtien = floatval($_POST['tongtien']);
        $ghichu = $conn->real_escape_string($_POST['ghichu']);
        $idNhanVien = 3; 
        $detail = json_decode($_POST['products'], true); // Chuyển đổi JSON sang mảng

        // Tạo hóa đơn
        $stmtInsertHoaDon = $conn->prepare("INSERT INTO hoadon (tongtien, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)");
        $stmtInsertHoaDon->bind_param("dsii", $tongtien, $ghichu, $idNhanVien, $idKhachHang);
        $stmtInsertHoaDon->execute();
        $idHoaDon = $conn->insert_id; // Lấy ID hóa đơn vừa tạo

        // Tạo chuẩn bị câu lệnh INSERT chi tiết hóa đơn
        $stmtInsertChiTietHoaDon = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");
        $stmtUpdateSanPham = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ? WHERE idChiTietSanPham = ?");

        foreach ($detail as $item) {
            $soLuong = intval($item['soluong']);
            $idChiTietSanPham = intval($item['idChiTietSanPham']);
            $soLuongConLai = intval($item['soluongconlai']);

            // Thêm chi tiết hóa đơn
            $stmtInsertChiTietHoaDon->bind_param("iii", $soLuong, $idHoaDon, $idChiTietSanPham);
            $stmtInsertChiTietHoaDon->execute();

            // Cập nhật số lượng còn lại trong kho
            $newAmount = $soLuongConLai - $soLuong;
            if ($newAmount < 0) {
                throw new Exception("Số lượng còn lại không đủ cho sản phẩm ID: $idChiTietSanPham");
            }
            $stmtUpdateSanPham->bind_param("ii", $newAmount, $idChiTietSanPham);
            $stmtUpdateSanPham->execute();
        }

        // Commit giao dịch
        $conn->commit();
        echo json_encode(["status" => "success", "idHoaDon" => $idHoaDon]);

    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        // Đóng tất cả statement
        if (isset($stmtInsertHoaDon)) $stmtInsertHoaDon->close();
        if (isset($stmtInsertChiTietHoaDon)) $stmtInsertChiTietHoaDon->close();
        if (isset($stmtUpdateSanPham)) $stmtUpdateSanPham->close();

        // Đóng kết nối
        $conn->close();
    }

} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}
?>
