<?php
// Bật hiển thị lỗi để dễ dàng gỡ lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include file kết nối cơ sở dữ liệu
include 'C:\xampp\htdocs\CuaHangDungCu\config\connectdb.php';

// Lấy email và mật khẩu từ POST
$email = $_POST['email'];
$password = $_POST['password'];

// Kết nối đến cơ sở dữ liệu
$conn = connectBD();

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

// Sử dụng prepared statement để tránh SQL Injection
$stmt = $conn->prepare("SELECT * FROM taikhoan WHERE email = ?");
$stmt->bind_param("s", $email); // Bảo vệ khỏi SQL Injection
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $rows = $result->fetch_assoc();

    // Kiểm tra mật khẩu
    if ($rows['matkhau'] === $password) {
        // Trả về phản hồi thành công với URL chuyển hướng
        echo json_encode(['success' => true, 'redirect' => 'http://localhost/CuaHangDungCu/app/views/customer/index.php']);
    } else {
        echo json_encode(['success' => false, 'message' => "Mật khẩu không đúng."]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Không tìm thấy người dùng."]);
}

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>
