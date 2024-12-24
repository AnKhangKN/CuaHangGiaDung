<?php
require_once "../../../config/connectdb.php";

if (isset($_POST['action']) && $_POST['action'] == 'NoAcc') {
    
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE); // Bắt đầu giao dịch

    try {
        // Khai báo giá trị mặc định
        $tenKH = "Khách vãng lai";
        $status = 0;
        $bill_status = 2;
        $tongtien = floatval($_POST['tongtien']);
        $idNhanVien = $_POST['idNhanVien']; 
        $detail = json_decode($_POST['products'], true);

        // Tạo khách hàng
        $stmtInsertKhachHang = $conn->prepare("INSERT INTO khachhang (tenkhachhang, trangthaithongtin, idTaiKhoan) VALUES (?, ?, ?)");
        $stmtInsertKhachHang->bind_param('sii', $tenKH, $status, $taiKhoan);
        if (!$stmtInsertKhachHang->execute()) {
            throw new Exception("Không thể tạo khách hàng vãng lai.");
        }
        $idKhachHang = $conn->insert_id;

        // Tạo hóa đơn
        $stmtInsertHoaDon = $conn->prepare("INSERT INTO hoadon (tongtien, trangthai, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)");
        $stmtInsertHoaDon->bind_param("diii", $tongtien, $bill_status, $idNhanVien, $idKhachHang);
        if (!$stmtInsertHoaDon->execute()) {
            throw new Exception("Không thể tạo hóa đơn.");
        }
        $idHoaDon = $conn->insert_id;

        // Chuẩn bị câu lệnh SQL cho chi tiết hóa đơn và cập nhật kho
        $stmtInsertChiTietHoaDon = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");
        $stmtUpdateSanPham = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ? WHERE idChiTietSanPham = ?");

        foreach ($detail as $item) {
            $soLuong = intval($item['soluong']);
            $idChiTietSanPham = intval($item['idChiTietSanPham']);

            if ($soLuong <= 0) {
                throw new Exception("Số lượng sản phẩm phải lớn hơn 0.");
            }

            // Lấy số lượng còn lại trong kho
            $stmtCheckStock = $conn->prepare("SELECT soluongconlai FROM chitietsanpham WHERE idChiTietSanPham = ?");
            $stmtCheckStock->bind_param("i", $idChiTietSanPham);
            $stmtCheckStock->execute();
            $result = $stmtCheckStock->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $soLuongConLai = $row['soluongconlai'];
                if ($soLuongConLai < $soLuong) {
                    throw new Exception("Số lượng còn lại không đủ cho sản phẩm ID: $idChiTietSanPham");
                }

                // Thêm chi tiết hóa đơn
                $stmtInsertChiTietHoaDon->bind_param("iii", $soLuong, $idHoaDon, $idChiTietSanPham);
                $stmtInsertChiTietHoaDon->execute();

                // Cập nhật số lượng trong kho
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
        }

        // Commit giao dịch
        $conn->commit();
        echo json_encode(["status" => "success", "idHoaDon" => $idHoaDon]);

    } catch (Exception $e) {
        // Rollback giao dịch nếu có lỗi
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        // Đóng statement và kết nối
        if (isset($stmtInsertKhachHang)) $stmtInsertKhachHang->close();
        if (isset($stmtInsertHoaDon)) $stmtInsertHoaDon->close();
        if (isset($stmtInsertChiTietHoaDon)) $stmtInsertChiTietHoaDon->close();
        if (isset($stmtUpdateSanPham)) $stmtUpdateSanPham->close();
        if (isset($stmtCheckStock)) $stmtCheckStock->close();
        $conn->close();
    }

} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}
?>
