<?php
require_once "../../../config/connectdb.php"; 

if (isset($_POST['action']) && $_POST['action'] == 'CustomerId') {
    
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE); // Bắt đầu giao dịch

    try {
        // Lấy dữ liệu từ client
        $idKhachHang = intval($_POST['idKhachHang']);
        $tenKhachHang = $_POST['tenkhachhang'];
        $sodienthoai = $_POST['sodienthoai'];
        $diachi = $_POST['diachi'];
        $tongtien = floatval($_POST['tongtien']);
        $method = $_POST['method'];
        $ghichu = $conn->real_escape_string($_POST['ghichu']);
        $idNhanVien = 3; // Nhân viên ID mặc định
        $detail = json_decode($_POST['products'], true); // Chuyển đổi JSON sang mảng

        // Kiểm tra các trường bắt buộc
        if (empty($tenKhachHang) || empty($sodienthoai) || empty($diachi) || empty($tongtien) || !is_array($detail)) {
            throw new Exception("Thông tin cần thiết không đầy đủ.");
        }

        // Cập nhật thông tin khách hàng
        $stmtUpdateKhachHang = $conn->prepare("UPDATE khachhang SET tenkhachhang = ?,sdt = ?,diachi = ? WHERE idKhachHang = ?;");
        $stmtUpdateKhachHang->bind_param('sssi', $tenKhachHang, $sodienthoai, $diachi, $idKhachHang);
        $stmtUpdateKhachHang->execute();

        // Tạo hóa đơn
        $stmtInsertHoaDon = $conn->prepare("INSERT INTO hoadon (tongtien, payment_method, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?, ?)");
        $stmtInsertHoaDon->bind_param("dsisi", $tongtien, $method, $ghichu, $idNhanVien, $idKhachHang);
        $stmtInsertHoaDon->execute();
        $idHoaDon = $conn->insert_id; // Lấy ID hóa đơn vừa tạo

        // Tạo chuẩn bị câu lệnh INSERT chi tiết hóa đơn
        $stmtInsertChiTietHoaDon = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");
        $stmtUpdateSanPham = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ? WHERE idChiTietSanPham = ?");

        foreach ($detail as $item) {
            $soLuong = intval($item['soluong']);
            $idChiTietSanPham = intval($item['idChiTietSanPham']);
            $soLuongConLai = intval($item['soluongconlai']);

            // Kiểm tra tính hợp lệ số lượng
            if ($soLuong <= 0 || $soLuongConLai <= 0) {
                throw new Exception("Số lượng không hợp lệ cho sản phẩm ID: $idChiTietSanPham");
            }

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

        // Xóa cookie giỏ hàng
        if (isset($_COOKIE['cart'])) {
            setcookie('cart', '', time() - 3600, '/'); 
            unset($_COOKIE['cart']); 
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
