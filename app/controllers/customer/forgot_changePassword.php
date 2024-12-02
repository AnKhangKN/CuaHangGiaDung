<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if (isset($_POST['action']) && $_POST['action'] === 'forgotPass') {

    $email = $_POST['email'];
    $code = $_POST['code'];
    $newPass = $_POST['newPass'];

    // Kiểm tra email của tài khoản
    $stmtCheckAccount = $conn->prepare("SELECT * FROM taikhoan WHERE email = ?");
    $stmtCheckAccount->bind_param('s', $email);
    $stmtCheckAccount->execute();

    $result_acc = $stmtCheckAccount->get_result();
    if ($result_acc->num_rows > 0) {
        $record = $result_acc->fetch_assoc();

        $email_acc = $record['email'];

        // Kiểm tra mã OTP
        $stmtCheckOtp = $conn->prepare("SELECT * FROM email_verification WHERE email = ? AND otp = ? AND tgcode > NOW()");
        $stmtCheckOtp->bind_param('ss', $email, $code);
        $stmtCheckOtp->execute();

        $result_otp = $stmtCheckOtp->get_result();
        if ($result_otp->num_rows > 0) {
            $record_otp = $result_otp->fetch_assoc();

            $email_otp = $record_otp['email'];

            if ($email_acc === $email_otp) {
                $pass_change = password_hash($newPass, PASSWORD_DEFAULT);

                $stmtUpdatePassword = $conn->prepare("UPDATE taikhoan SET matkhau = ? WHERE email = ?");
                $stmtUpdatePassword->bind_param('ss', $pass_change, $email);
                if ($stmtUpdatePassword->execute()) {
                    echo "Mật khẩu đã được thay đổi thành công!";
                } else {
                    echo "Có lỗi xảy ra khi cập nhật mật khẩu!";
                }
            } else {
                echo "Email và OTP không khớp!";
            }
        } else {
            echo "OTP không hợp lệ hoặc đã hết hạn!";
        }
    } else {
        echo "Email không tồn tại!";
    }

    $stmtCheckAccount->close();
    $stmtCheckOtp->close();
    $stmtUpdatePassword->close();
} else {
    echo "Không thể thay đổi mật khẩu!";
}

?>
