<?php

require_once "../../../config/connectdb.php";
require_once "../../../vendor/sendmail.php";

if(isset($_POST['action']) && $_POST['action'] === 'add_customer'){

    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        // Lấy dữ liệu từ form
        $ten = $_POST['ten'];
        $sdt = $_POST['sdt'];
        $diachi = $_POST['diachi'];
        $email = $_POST['email'];

        // Tạo mật khẩu ngẫu nhiên
        $matkhau = bin2hex(random_bytes(8)); // Tạo mật khẩu ngẫu nhiên 16 ký tự
        $passhash = password_hash($matkhau, PASSWORD_DEFAULT);

        // Kiểm tra email trùng lặp
        $stmtCheckMail = $conn->prepare("SELECT 1 FROM taikhoan WHERE email = ?");
        $stmtCheckMail->bind_param('s', $email);
        $stmtCheckMail->execute();
        $resultCheckMail = $stmtCheckMail->get_result();

        if ($resultCheckMail->num_rows > 0) {
            throw new Exception("Email đã được sử dụng.");
        }

        // Tạo tài khoản
        $stmtInsertAccount = $conn->prepare("INSERT INTO taikhoan (email, matkhau) VALUES (?, ?)");
        $stmtInsertAccount->bind_param('ss', $email, $passhash);
        $stmtInsertAccount->execute();

        $idAccount = $conn->insert_id;

        // Tạo khách hàng
        $stmtInsertCustomer = $conn->prepare("INSERT INTO khachhang (tenkhachhang, sdt, diachi, idTaiKhoan) VALUES (?, ?, ?, ?)");
        $stmtInsertCustomer->bind_param('sssi', $ten, $sdt, $diachi, $idAccount);
        $stmtInsertCustomer->execute();

        // Gửi email xác nhận
        $tieuDe = 'Xác nhận tài khoản';
        $noiDung = "<b>HKN Store xin cảm ơn bạn đã đăng ký tài khoản</b><br><br>
                    Email của bạn: $email<br>
                    Mật khẩu của bạn: $matkhau <br><br>
                    
                    Vui lòng truy cập vào trang web của chúng tôi để đăng nhập và thay đổi mật khẩu của bạn.";
        $emailGuiThanhCong = sendEmail($email, $tieuDe, $noiDung, 'minecraftcopyright1302@gmail.com');

        if (!$emailGuiThanhCong) {
            throw new Exception("Không thể gửi email xác nhận.");
        }

        // Commit giao dịch
        $conn->commit();

        $response = [
            'status' => 'success',
            'message' => "Tạo khách hàng thành công."
        ];
        echo json_encode($response);

    } catch (Exception $e) {
        $conn->rollback(); // Rollback giao dịch
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
        echo json_encode($response);
    } finally {
        $conn->close();
    }

}
?>
