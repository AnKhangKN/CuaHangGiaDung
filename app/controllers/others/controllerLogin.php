<?php
// Bắt đầu session
session_start();
include 'C:/xampp/htdocs/CuaHangDungCu/config/session.php'; // Quản lý session
include 'C:/xampp/htdocs/CuaHangDungCu/config/connectdb.php'; // Kết nối cơ sở dữ liệu

// Kết nối cơ sở dữ liệu
$conn = connectBD();

// Nhận dữ liệu từ POST
$email = isset($_POST['email']) ? $_POST['email'] : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';

// Khởi tạo phản hồi mặc định
$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

// Kiểm tra xem email và mật khẩu có hợp lệ không
if (empty($email) || empty($pass)) {
    $response['message'] = '*Hãy nhập email và mật khẩu.';
    echo json_encode($response);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM taikhoan WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $rows = $result->fetch_assoc();

    // So sánh mật khẩu
    if ($pass === $rows['matkhau']) {
        // Thiết lập session
        $_SESSION['user_id'] = $rows['idTaiKhoan'];
        $_SESSION['email'] = $rows['email'];
        $_SESSION['quyen'] = $rows['quyen'];

        // Chuyển hướng đến trang thông tin
        $response['success'] = true;

        if ($rows['quyen'] == 0) {
            $response['redirect'] = '/CuaHangDungCu/index.php?page=information';
        } elseif ($rows['quyen'] == 1) {
            $response['redirect'] = '/CuaHangDungCu/admin/index.php';
        } elseif ($rows['quyen'] == 2) {
            $response['redirect'] = '/CuaHangDungCu/employee/index.php';
        } else{
            $response['redirect'] = '/CuaHangDungCu/app/views/others/login.php';
        }

    } else {
        $response['message'] = '*Thông tin đăng nhập không chính xác.';
    }
} else {
    $response['message'] = '*Thông tin đăng nhập không chính xác.';
}

// Trả về phản hồi dưới dạng JSON
echo json_encode($response);

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>
