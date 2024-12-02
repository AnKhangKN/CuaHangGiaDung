<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if(isset($_POST['action']) && $_POST['action'] === 'ChangePassWord'){
    $passLate = $_POST['PassWordLate'];    // Mật khẩu cũ
    $idKhachHang = $_POST['idKhachHang'];  // ID khách hàng
    $passNew = $_POST['PassWordNew'];      // Mật khẩu mới
    $passConfirm = $_POST['PassWordConfirm']; // Mật khẩu xác nhận

    // Kiểm tra xem mật khẩu mới và mật khẩu xác nhận có khớp không
    if($passNew !== $passConfirm){
        echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp']);
        exit;
    }

    // Lấy thông tin mật khẩu hiện tại của người dùng
    $stmtSelectPassWord = $conn->prepare("SELECT tk.matkhau 
                                        FROM khachhang kh
                                        JOIN taikhoan tk ON tk.idTaiKhoan = kh.idTaiKhoan
                                        WHERE kh.idKhachHang = ?");
    $stmtSelectPassWord->bind_param('i', $idKhachHang); // Chỉ cần ID khách hàng để truy vấn
    $stmtSelectPassWord->execute();
    $stmtSelectPassWord->store_result();
    
    // Kiểm tra nếu khách hàng tồn tại
    if($stmtSelectPassWord->num_rows > 0){
        $stmtSelectPassWord->bind_result($storedPassword);  // Lấy mật khẩu đã lưu trong DB
        $stmtSelectPassWord->fetch();

        // So sánh mật khẩu cũ người dùng nhập vào với mật khẩu đã lưu trong cơ sở dữ liệu
        if (password_verify($passLate, $storedPassword)) {
            // Mật khẩu cũ đúng, tiến hành thay đổi mật khẩu mới
            $hashedPasswordNew = password_hash($passNew, PASSWORD_DEFAULT); // Mã hóa mật khẩu mới

            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            $stmtUpdatePassWord = $conn->prepare("UPDATE taikhoan tk
                                                JOIN khachhang kh ON tk.idTaiKhoan = kh.idTaiKhoan
                                                SET tk.matkhau = ?
                                                WHERE kh.idKhachHang = ?");
            $stmtUpdatePassWord->bind_param('si', $hashedPasswordNew, $idKhachHang);
            $stmtUpdatePassWord->execute();

            if ($stmtUpdatePassWord->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật mật khẩu thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cập nhật mật khẩu thất bại']);
            }
            $stmtUpdatePassWord->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu cũ không đúng']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy khách hàng']);
    }

    $stmtSelectPassWord->close();
    $conn->close();
}
?>
