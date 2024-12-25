<?php

// Bao gồm các file của PHPMailer
include __DIR__ . '/PHPMailer/src/PHPMailer.php';
include __DIR__ . '/PHPMailer/src/SMTP.php';
include __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($toEmail, $subject, $body, $ccEmail = null) {
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->SMTPDebug = 0;  // Tắt debug (đặt 2 để bật debug chi tiết)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'minecraftcopyright1302@gmail.com';  // Email gửi
        $mail->Password = 'vfag jkcj ibdt diii';  // Mật khẩu ứng dụng
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Đặt thông tin người gửi
        $mail->setFrom('facebookcopyright1302@gmail.com', 'HKN store');
        $mail->addAddress($toEmail);  // Người nhận

        // Thêm CC nếu cần
        if ($ccEmail) {
            $mail->addCC($ccEmail);
        }

        // Đảm bảo mã hóa UTF-8
        $mail->CharSet = 'UTF-8';

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Gửi email
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Lỗi khi gửi email: " . $mail->ErrorInfo);  // Ghi log lỗi
        return false;
    }
}
