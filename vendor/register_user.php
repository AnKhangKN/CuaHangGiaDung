<?php

// Đặt múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Bao gồm file gửi email
require_once 'sendmail.php';

// Kết nối cơ sở dữ liệu
require_once '../config/connectdb.php';
$conn = connectBD();
if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}

// Kiểm tra và xử lý khi người dùng gửi email và mật khẩu
if (isset($_POST['email'], $_POST['pass'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email không hợp lệ!");
    }

    // Kiểm tra email đã tồn tại trong cơ sở dữ liệu
    $stmtSelectAccount = $conn->prepare('SELECT email FROM taikhoan WHERE email = ?');
    $stmtSelectAccount->bind_param('s', $email);
    $stmtSelectAccount->execute();
    $stmtSelectAccount->store_result();
    if ($stmtSelectAccount->num_rows > 0) {
        echo 'Email đã tồn tại, hãy đổi sang email khác';
        exit;
    }
    $stmtSelectAccount->close();

    // Tạo OTP và thời gian hết hạn
    $otp = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Lưu OTP vào bảng email_verification
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO email_verification (email, matkhau, otp, tgcode) 
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE otp = ?, tgcode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $email, $passwordHash, $otp, $expiresAt, $otp, $expiresAt);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'Thông tin đã được lưu, email xác thực đang được gửi!';
    } else {
        echo 'Lỗi khi lưu thông tin.';
    }
    $stmt->close();

    // Gửi email xác thực
    $subject = 'Confirm Account';
    $body = "Mã OTP của bạn là: <b>$otp</b>. Mã này sẽ hết hạn sau 10 phút.";
    $isEmailSent = sendEmail($email, $subject, $body, 'minecraftcopyright1302@gmail.com');

    if ($isEmailSent) {
        echo 'Email xác thực đã được gửi đến ' . $email;
    } else {
        echo 'Không thể gửi email xác thực.';
    }

    // Xóa OTP đã hết hạn
    $currentTime = date('Y-m-d H:i:s');
    $stmtDeleteExpired = $conn->prepare("DELETE FROM email_verification WHERE tgcode < ?");
    $stmtDeleteExpired->bind_param("s", $currentTime);
    $stmtDeleteExpired->execute();
}

$conn->close();
?>
