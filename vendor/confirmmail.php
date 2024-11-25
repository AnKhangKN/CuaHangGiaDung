<?php


require_once '../config/connectdb.php';
$conn = connectBD();

if (isset($_POST['code'])) {
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);  // Bắt đầu giao dịch

    try {
        $code = $_POST['code'];

        // Chuẩn bị truy vấn để tìm OTP trong cơ sở dữ liệu
        $stmtEmailVerification = $conn->prepare('SELECT * FROM email_verification WHERE otp = ? AND tgcode < NOW()');
        
        if ($stmtEmailVerification) {
            // Liên kết tham số
            $stmtEmailVerification->bind_param('s', $code);

            $stmtEmailVerification->execute();
            $result = $stmtEmailVerification->get_result();

            // Kiểm tra xem có kết quả trả về không
            if ($result->num_rows > 0) {
                // Nếu có, lấy dữ liệu
                $record = $result->fetch_assoc();

                // Lấy email và mật khẩu từ bảng email_verification
                $email = $record['email'];
                $password = $record['matkhau'];  // Giả sử mật khẩu đã được mã hóa

                // Thêm thông tin vào bảng taikhoan
                $stmtInsertUser = $conn->prepare('INSERT INTO taikhoan (email, matkhau) VALUES (?, ?)');
                
                // Chèn thông tin vào bảng khách hàng
                $stmtInsertCustomer = $conn->prepare('INSERT INTO khachhang (idTaiKhoan) VALUES (?)');

                if ($stmtInsertUser) {
                    $stmtInsertUser->bind_param('ss', $email, $password);
                    $stmtInsertUser->execute();

                    $idAccount = $conn->insert_id; // Lấy ID của tài khoản vừa được chèn

                    // Chèn thông tin khách hàng vào bảng khachhang
                    $stmtInsertCustomer->bind_param('i', $idAccount);
                    $stmtInsertCustomer->execute();

                    // Xóa thông tin OTP khỏi bảng email_verification
                    $stmtDeleteOTP = $conn->prepare('DELETE FROM email_verification WHERE otp = ?');
                    $stmtDeleteOTP->bind_param('s', $code);
                    $stmtDeleteOTP->execute();

                    // Commit giao dịch nếu mọi thứ thành công
                    $conn->commit();
                    echo 'Xác thực thành công. Bạn đã được đăng ký tài khoản!';
                } else {
                    // Nếu không thể thêm người dùng, rollback giao dịch
                    $conn->rollback();
                    echo 'Lỗi khi thêm người dùng!';
                }
            } else {
                // Nếu mã OTP không hợp lệ hoặc đã hết hạn, rollback giao dịch
                $conn->rollback();
                echo 'Mã OTP không hợp lệ hoặc đã hết hạn!';
            }
        } else {
            // Nếu có lỗi trong câu truy vấn, rollback giao dịch
            $conn->rollback();
            echo 'Lỗi truy vấn cơ sở dữ liệu!';
        }
    } catch (Exception $e) {
        // Nếu có lỗi trong quá trình xử lý, rollback giao dịch
        $conn->rollback();
        echo 'Đã có lỗi xảy ra: ' . $e->getMessage();
    }
} else {
    echo 'Chưa được xử lý';
}
?>
