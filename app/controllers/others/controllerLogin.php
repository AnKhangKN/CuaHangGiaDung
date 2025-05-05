<?php
// Bắt đầu session
session_start();

// Bao gồm các tệp cần thiết cho quản lý session và kết nối cơ sở dữ liệu
include '../../../config/session.php';
include '../../../config/connectdb.php';

// Kết nối đến cơ sở dữ liệu
$conn = connectBD();

// Nhận dữ liệu từ POST và loại bỏ khoảng trắng không cần thiết
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass = isset($_POST['password']) ? trim($_POST['password']) : '';

// Khởi tạo phản hồi mặc định
$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

// Kiểm tra dữ liệu đầu vào
if (empty($email) || empty($pass)) {
    $response['message'] = '*Hãy nhập email và mật khẩu.';
    echo json_encode($response);
    exit();
}

// Truy vấn cơ sở dữ liệu để kiểm tra email
$stmt = $conn->prepare("SELECT * FROM taikhoan WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả truy vấn
if ($result->num_rows > 0) {
    $rows = $result->fetch_assoc();

    // So sánh mật khẩu đã mã hóa
    if (password_verify($pass, $rows['matkhau'])) {
        
        $_SESSION['user_id'] = $rows['idTaiKhoan'];
        $_SESSION['quyen'] = $rows['quyen'];

        // Cập nhật phản hồi nếu đăng nhập thành công
        $response['success'] = true;

        // Chuyển hướng dựa trên quyền người dùng
        switch ($rows['quyen']) {
            case 0:
                // Kiểm tra cookie giỏ hàng
                if (!empty($_COOKIE['cart']) && json_decode($_COOKIE['cart'], true)) {
                    $response['redirect'] = '/CuaHangGiaDung/public/index.php?page=payment';
                } else {
                    $response['redirect'] = '/CuaHangGiaDung/public/index.php?page=information';
                }
                break;
            case 1:
                $response['redirect'] = '/CuaHangGiaDung/public/manager/index.php';
                break;
            case 2:
                $response['redirect'] = '/CuaHangGiaDung/public/employee/index.php';
                break;
            default:
                $response['redirect'] = '/CuaHangGiaDung/app/views/others/login.php';
                break;
        }
    } else {
        $response['message'] = '*Thông tin đăng nhập không chính xác.';
    }
} else {
    $response['message'] = '*Thông tin đăng nhập không chính xác.';
}

// Trả về phản hồi dưới dạng JSON
echo json_encode($response);

// Đóng statement và kết nối cơ sở dữ liệu
$stmt->close();
$conn->close();
?>
