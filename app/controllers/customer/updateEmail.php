<?php
// Set Vietnam timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once "../../../config/connectdb.php";
require_once "../../../vendor/sendmail.php";

$conn = connectBD();

if (isset($_POST["action"]) && $_POST["action"] === "sendCode") {
    $newEmail = trim($_POST["newEmail"]); // Sanitize input

    // Check if email already exists
    $stmtSelectAccount = $conn->prepare('SELECT email FROM taikhoan WHERE email = ?');
    $stmtSelectAccount->bind_param('s', $newEmail);
    $stmtSelectAccount->execute();
    $stmtSelectAccount->store_result();
    if ($stmtSelectAccount->num_rows > 0) {
        echo 'Email đã tồn tại, hãy đổi sang email khác';
        exit;
    }
    $stmtSelectAccount->close();

    // Generate OTP and expiry time
    $otp = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Save or update OTP in the database
    $stmtEmail = $conn->prepare("INSERT INTO email_verification (email, otp, tgcode) 
                                VALUES (?, ?, ?)
                                ON DUPLICATE KEY UPDATE otp = ?, tgcode = ?");
    $stmtEmail->bind_param('sssss', $newEmail, $otp, $expiresAt, $otp, $expiresAt);
    $stmtEmail->execute();

    if ($stmtEmail->affected_rows > 0) {
        echo 'Thông tin đã được lưu, email xác thực đang được gửi!';
    } else {
        echo 'Lỗi khi lưu thông tin.';
    }
    $stmtEmail->close();

    // Send verification email
    $subject = 'Confirm New Email';
    $body = "Mã OTP dành cho email mới của bạn là: <b>$otp</b>. Mã này sẽ hết hạn sau 10 phút.";
    $isEmailSent = sendEmail($newEmail, $subject, $body, 'minecraftcopyright1302@gmail.com');

    if ($isEmailSent) {
        echo 'Email xác thực đã được gửi đến ' . $newEmail;
    } else {
        echo 'Không thể gửi email xác thực.';
    }

    // Delete expired OTPs
    $currentTime = date('Y-m-d H:i:s');
    $stmtDeleteExpired = $conn->prepare("DELETE FROM email_verification WHERE tgcode < ?");
    $stmtDeleteExpired->bind_param("s", $currentTime);
    $stmtDeleteExpired->execute();
    $stmtDeleteExpired->close();
}
?>

<?php

// Set Vietnam timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once "../../../config/connectdb.php";

$conn = connectBD();

if(isset($_POST['action']) && $_POST['action'] === 'updateEmail'){

    $newEmail = $_POST['newEmail'];
    $code = $_POST['code'];
    $idKhachHang = $_POST['idKhachHang'];

    $stmtSelectCheck = $conn->prepare("SELECT * FROM email_verification WHERE email = ? AND otp = ? AND tgcode > NOW()");
    $stmtSelectCheck->bind_param('ss', $newEmail, $code);
    $stmtSelectCheck->execute();
    $stmtSelectCheck->store_result();

    if($stmtSelectCheck->num_rows > 0){
        $stmtUpdateNewEmail = $conn->prepare("UPDATE taikhoan tk
                                            JOIN khachhang kh ON kh.idTaiKhoan = tk.idTaiKhoan
                                            SET tk.email = ?
                                            WHERE kh.idKhachHang = ?");
    
        $stmtUpdateNewEmail->bind_param('si',$newEmail, $idKhachHang);
        $stmtUpdateNewEmail->execute();

        
        echo "Cập nhật email thành công!";
    }else{
        echo "OTP không đúng hoặc đã hết hạn hãy kiểm tra lại!";
    }

    $stmtUpdateNewEmail->close();
    $stmtSelectCheck->close();

    $conn->close();

} else{
    echo "Hãy kiểm tra lại thông tin của bạn";
}
?>
