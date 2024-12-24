<?php
require_once "../../../config/connectdb.php"; 

if (isset($_POST['action']) && $_POST['action'] == 'CustomerId') {
    
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE); // Bắt đầu giao dịch

    try {
        // Lấy dữ liệu từ client
        $idKhachHang = intval($_POST['idKhachHang']);
        $tongtien = floatval($_POST['tongtien']);
        $idNhanVien = $_POST['idNhanVien']; 
        $detail = json_decode($_POST['products'], true); 

        // Tạo hóa đơn
        $stmtInsertHoaDon = $conn->prepare("INSERT INTO hoadon (tongtien, idNhanVien, idKhachHang) VALUES (?, ?, ?)");
        $stmtInsertHoaDon->bind_param("dsi", $tongtien, $idNhanVien, $idKhachHang);
        $stmtInsertHoaDon->execute();
        $idHoaDon = $conn->insert_id; // Lấy ID hóa đơn vừa tạo

        // Tạo chuẩn bị câu lệnh INSERT chi tiết hóa đơn
        $stmtInsertChiTietHoaDon = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");
        $stmtUpdateSanPham = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ? WHERE idChiTietSanPham = ?");

        foreach ($detail as $item) {
            $soLuong = intval($item['soluong']);
            $idChiTietSanPham = intval($item['idChiTietSanPham']);

            // Lấy số lượng còn lại trong kho
            $stmtCheckStock = $conn->prepare("SELECT soluongconlai FROM chitietsanpham WHERE idChiTietSanPham = ?");
            $stmtCheckStock->bind_param("i", $idChiTietSanPham);
            $stmtCheckStock->execute();
            $result = $stmtCheckStock->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $soLuongConLai = $row['soluongconlai'];

                // Kiểm tra số lượng còn lại trong kho
                if ($soLuongConLai < $soLuong) {
                    throw new Exception("Số lượng còn lại không đủ cho sản phẩm ID: $idChiTietSanPham");
                }

                // Thêm chi tiết hóa đơn
                $stmtInsertChiTietHoaDon->bind_param("iii", $soLuong, $idHoaDon, $idChiTietSanPham);
                $stmtInsertChiTietHoaDon->execute();

                // Cập nhật số lượng còn lại trong kho
                $newAmount = $soLuongConLai - $soLuong;
                $stmtUpdateSanPham->bind_param("ii", $newAmount, $idChiTietSanPham);
                $stmtUpdateSanPham->execute();
            } else {
                throw new Exception("Không tìm thấy sản phẩm ID: $idChiTietSanPham trong kho.");
            }
        }

        // Xóa cookie giỏ hàng
        if (isset($_COOKIE['cart_e'])) {
            setcookie('cart_e', '', time() - 3600, '/'); 
            unset($_COOKIE['cart_e']); 
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
        if (isset($stmtCheckStock)) $stmtCheckStock->close();

        // Đóng kết nối
        $conn->close();
    }

} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]); 
}
?>
