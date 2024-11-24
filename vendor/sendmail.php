<?php

// Bao gồm các file của PHPMailer
include __DIR__ . '/PHPMailer/src/PHPMailer.php';
include __DIR__ . '/PHPMailer/src/SMTP.php';
include __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $stmtSelectAccount->store_result();  // Lưu kết quả
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
    
    // Kiểm tra nếu thông tin đã được lưu thành công
    if ($stmt->affected_rows > 0) {
        echo 'Thông tin đã được lưu, email xác thực đang được gửi!';
    } else {
        echo 'Lỗi khi lưu thông tin.';
    }
    $stmt->close();

    // Gửi email xác thực
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->SMTPDebug = 0;  // Để debug xem chi tiết quá trình gửi (để bật lên chọn 2)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'minecraftcopyright1302@gmail.com';  // Thay bằng email bạn muốn gửi
        $mail->Password = 'vfag jkcj ibdt diii';  // Mật khẩu email của bạn
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Gửi email
        $mail->setFrom('facebookcopyright1302@gmail.com', 'HKN store');  // Thay bằng email người gửi
        $mail->addAddress($email, 'User');  // Gửi email tới người dùng đã nhập

        // CC hoặc BCC
        $mail->addCC('minecraftcopyright1302@gmail.com');  // Email gửi cho chính chủ

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'Confirm Account';
        $mail->Body = "Mã OTP của bạn là: <b>$otp</b>. Mã này sẽ hết hạn sau 10 phút.";

        // Gửi email
        $mail->send();
        echo 'Email xác thực đã được gửi đến ' . $email;

    } catch (Exception $e) {
        echo 'Không thể gửi email. Lỗi: ', $mail->ErrorInfo;
    }

    // Kiểm tra và xóa OTP nếu đã hết hạn
    $currentTime = date('Y-m-d H:i:s');  // Lấy thời gian hiện tại
    $stmtDeleteExpired = $conn->prepare("DELETE FROM email_verification WHERE tgcode < ?");
    $stmtDeleteExpired->bind_param("s", $currentTime);
    $stmtDeleteExpired->execute();
}

$conn->close();
?>
