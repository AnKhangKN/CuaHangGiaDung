<?php
require_once "../../../config/connectdb.php"; 
require_once "../../../vendor/sendmail.php";

if (isset($_POST['action']) && $_POST['action'] == 'NoCustomerId') {
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        // Lấy dữ liệu từ client
        $code = $_POST['code'];
        $email = $conn->real_escape_string($_POST['email']);
        $password = '123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $tenkhachhang = $conn->real_escape_string($_POST['tenkhachhang']);
        $sdt = intval($_POST['sdt']);
        $diachi = $conn->real_escape_string($_POST['diachi']);
        $tongtien = floatval($_POST['tongtien']);
        $method = $_POST['method'];
        $ghichu = $conn->real_escape_string($_POST['ghichu']);
        $idNhanVien = 3; // Nhân viên ID mặc định
        $detail = json_decode($_POST['products'], true);

        // Kiểm tra thông tin cần thiết từ client
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

        // Kiểm tra xem email có đã tồn tại trong hệ thống chưa
        $stmtCheckExistingUser = $conn->prepare("SELECT * FROM taikhoan WHERE email = ?");
        $stmtCheckExistingUser->bind_param('s', $email);
        $stmtCheckExistingUser->execute();
        $existingUserResult = $stmtCheckExistingUser->get_result();
        if ($existingUserResult->num_rows > 0) {
            throw new Exception("Email đã được sử dụng.");
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
        $stmtInsertBill = $conn->prepare("INSERT INTO hoadon (tongtien, payment_method, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?, ?)");
        $stmtInsertBill->bind_param("dsiii", $tongtien, $method, $ghichu, $idNhanVien, $idCustomer);
        $stmtInsertBill->execute();
        $idHoaDon = $conn->insert_id;

        // Thêm chi tiết hóa đơn và cập nhật số lượng sản phẩm
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

        // Gửi email xác nhận
        $tieuDe = 'Confirm Account';
        $noiDung = "<b>HKN store xin chân thành cảm ơn bạn đã mua hàng</b><br><br>
                    Mật khẩu của bạn: <b>$password</b><br>
                    Email của bạn: $email<br><br>
                    Hãy đăng nhập để có thể được hỗ trợ tốt hơn." ;
        $emailGuiThanhCong = sendEmail($email, $tieuDe, $noiDung, 'minecraftcopyright1302@gmail.com');

        // Xóa cookie giỏ hàng
        if (isset($_COOKIE['cart'])) {
            setcookie('cart', '', time() - 3600, '/'); 
            unset($_COOKIE['cart']); 
        }

        // Commit giao dịch
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
