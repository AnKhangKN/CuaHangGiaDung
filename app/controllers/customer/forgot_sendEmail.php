<?php


// Đặt múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once "../../../config/connectdb.php";
require_once "../../../vendor/sendmail.php";

$conn = connectBD();

if (isset($_POST['inputEmail'])) {

    $email = $_POST['inputEmail'];

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email không hợp lệ!'
        ]);
        exit();
    }

    $otp = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Chèn hoặc cập nhật OTP
    $query = "INSERT INTO email_verification (email, otp, tgcode) 
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE otp = ?, tgcode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $email, $otp, $expiresAt, $otp, $expiresAt);

    if ($stmt->execute()) {
        // Gửi email xác thực
        $subject = 'Confirm Account';
        $body = "Mã OTP của bạn là: <b>$otp</b>. Mã này sẽ hết hạn sau 10 phút.";
        $isEmailSent = sendEmail($email, $subject, $body, 'minecraftcopyright1302@gmail.com');

        if ($isEmailSent) {
            echo json_encode([
                'status' => 'success',
                'message' => 'OTP và email đã được gửi!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không thể gửi email xác thực!'
            ]);
        }

        // Xóa OTP đã hết hạn
        $currentTime = date('Y-m-d H:i:s');
        $stmtDeleteExpired = $conn->prepare("DELETE FROM email_verification WHERE tgcode < ?");
        $stmtDeleteExpired->bind_param("s", $currentTime);
        $stmtDeleteExpired->execute();

        $stmtDeleteExpired->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lỗi khi lưu OTP!'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu thông tin!'
    ]);
}
?>
