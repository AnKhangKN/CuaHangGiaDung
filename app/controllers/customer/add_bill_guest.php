<?php
require_once "../../../config/connectdb.php"; 

if (isset($_POST['action']) && $_POST['action'] == 'NoCustomerId') {
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        $code = $_POST['code'];
        $email = $conn->real_escape_string($_POST['email']);
        $password = '123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $tenkhachhang = $conn->real_escape_string($_POST['tenkhachhang']);
        $sdt = intval($_POST['sdt']);
        $diachi = $conn->real_escape_string($_POST['diachi']);
        $tongtien = floatval($_POST['tongtien']);
        $ghichu = $conn->real_escape_string($_POST['ghichu']);
        $idNhanVien = 3;
        $detail = json_decode($_POST['products'], true);

        if (empty($email) || empty($tenkhachhang) || empty($sdt) || empty($tongtien)) {
            throw new Exception("Thiếu thông tin cần thiết từ client.");
        }

        // Kiểm tra mã OTP
        $stmtCheckEmail = $conn->prepare("SELECT * FROM email_verification WHERE otp = ? AND tgcode > NOW()");
        $stmtCheckEmail->bind_param('s', $code);
        $stmtCheckEmail->execute();
        $result = $stmtCheckEmail->get_result();
        $row = $result->fetch_assoc();

        if (!$row || $row['otp'] != $code) {
            throw new Exception("Mã OTP không hợp lệ hoặc đã hết hạn.");
        }

        // Thêm tài khoản
        $stmtInsertAccount = $conn->prepare("INSERT INTO taikhoan (email, matkhau) VALUES (?, ?)");
        $stmtInsertAccount->bind_param('ss', $email, $hashedPassword);
        $stmtInsertAccount->execute();
        $idAccount = $conn->insert_id;

        // Thêm khách hàng
        $stmtInsertCustomer = $conn->prepare("INSERT INTO khachhang (tenkhachhang, sdt, diachi, idTaiKhoan) VALUES (?, ?, ?, ?)");
        $stmtInsertCustomer->bind_param('sisi', $tenkhachhang, $sdt, $diachi, $idAccount);
        $stmtInsertCustomer->execute();
        $idCustomer = $conn->insert_id;

        // Thêm hóa đơn
        $stmtInsertBill = $conn->prepare("INSERT INTO hoadon (tongtien, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)");
        $stmtInsertBill->bind_param("dsii", $tongtien, $ghichu, $idNhanVien, $idCustomer);
        $stmtInsertBill->execute();
        $idHoaDon = $conn->insert_id;

        // Thêm chi tiết hóa đơn và cập nhật số lượng
        $stmtInsertDetail = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");
        $stmtUpdateSanPham = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ? WHERE idChiTietSanPham = ?");

        foreach ($detail as $item) {
            $soLuong = intval($item['soluong']);
            $idChiTietSanPham = intval($item['idChiTietSanPham']);
            $soLuongConLai = intval($item['soluongconlai']);

            if ($soLuongConLai < $soLuong) {
                throw new Exception("Số lượng không đủ cho sản phẩm ID: $idChiTietSanPham.");
            }

            $stmtInsertDetail->bind_param("iii", $soLuong, $idHoaDon, $idChiTietSanPham);
            $stmtInsertDetail->execute();

            $newAmount = $soLuongConLai - $soLuong;
            $stmtUpdateSanPham->bind_param("ii", $newAmount, $idChiTietSanPham);
            $stmtUpdateSanPham->execute();
        }

        $conn->commit();
        $response = [
            'status' => 'success',
            'message' => "Hóa đơn đã được tạo thành công với mã hóa đơn: $idHoaDon.",
            'idHoaDon' => $idHoaDon
        ];
        echo json_encode($response);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    } finally {
        $conn->close();
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Yêu cầu không hợp lệ!'
    ]);
}
?>
