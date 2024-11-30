<?php

// Đặt múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once "../../../config/connectdb.php";
require_once "../../../vendor/sendmail.php";

if (isset($_POST['email'])) {
    $conn = connectBD();

    try {
        $email = $_POST['email'];

        // Kiểm tra định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email không hợp lệ. Vui lòng nhập đúng định dạng email.");
        }

        // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
        $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("Email đã tồn tại trong hệ thống.");
            exit;
        }

        // Tạo mã OTP ngẫu nhiên
        $otp = rand(100000, 999999);
        $thoiGianHetHan = date('Y-m-d H:i:s', strtotime('+10 minutes'));  // Lấy thời gian hết hạn cộng thêm 10 phút

        // Lưu mã OTP vào cơ sở dữ liệu
        $query = "INSERT INTO email_verification (email, otp, tgcode) 
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE otp = ?, tgcode = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $email, $otp, $thoiGianHetHan, $otp, $thoiGianHetHan);
        $stmt->execute();

        if ($stmt->affected_rows <= 0) {
            throw new Exception('Lỗi khi lưu thông tin vào cơ sở dữ liệu.');
        }

        // Gửi email xác thực
        $tieuDe = 'Confirm Account';
        $noiDung = "Mã OTP của bạn là: <b>$otp</b>. Mã này sẽ hết hạn sau 10 phút.";
        $emailGuiThanhCong = sendEmail($email, $tieuDe, $noiDung, 'minecraftcopyright1302@gmail.com');

        if (!$emailGuiThanhCong) {
            throw new Exception('Không thể gửi email xác thực. Vui lòng thử lại sau.');
        }

        // Xóa các mã OTP đã hết hạn
        $thoiGianHienTai = date('Y-m-d H:i:s');
        $stmtXoaOTP = $conn->prepare("DELETE FROM email_verification WHERE tgcode < ?");
        $stmtXoaOTP->bind_param("s", $thoiGianHienTai);
        $stmtXoaOTP->execute();

        // Phản hồi thành công
        echo "Email xác thực đã được gửi thành công đến địa chỉ: $email.";
        echo " Vui lòng kiểm tra email của bạn để nhận mã OTP.";

    } catch (Exception $e) {
        // Phản hồi lỗi
        echo "Đã xảy ra lỗi: " . $e->getMessage();
        exit;
    }
} else {
    // Phản hồi khi không tìm thấy email
    echo "Không tìm thấy địa chỉ email. Vui lòng nhập email.";
}

?>
