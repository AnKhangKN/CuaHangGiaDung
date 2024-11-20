<?php
require_once "../../../config/connectdb.php"; // Gọi file kết nối cơ sở dữ liệu

if (isset($_POST['action']) && $_POST['action'] == 'NoCustomerId') {
    $conn = connectBD();
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        $email = $conn->real_escape_string($_POST['email']);
        $password = '123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $tenkhachhang = $conn->real_escape_string($_POST['tenkhachhang']);
        $sdt = intval($_POST['sdt']);
        $diachi = $conn->real_escape_string($_POST['diachi']);
        $tongtien = floatval($_POST['tongtien']);
        $ghichu = $conn->real_escape_string($_POST['ghichu']);
        $idNhanVien = 3;
        $detail = json_decode($_POST['products'], true);

        if (empty($email) || empty($tenkhachhang) || empty($sdt) || empty($tongtien)) {
            throw new Exception("Thiếu thông tin cần thiết từ client.");
        }

        $stmtCheckEmail = $conn->prepare("SELECT email FROM taikhoan WHERE email = ?");
        $stmtCheckEmail->bind_param('s', $email);
        $stmtCheckEmail->execute();
        $result = $stmtCheckEmail->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("Email đã tồn tại.");
        }

        $stmtInsertAccount = $conn->prepare("INSERT INTO taikhoan (email, matkhau) VALUES (?, ?)");
        $stmtInsertAccount->bind_param('ss', $email, $hashedPassword);
        $stmtInsertAccount->execute();
        $idAccount = $conn->insert_id;

        $stmtInsertCustomer = $conn->prepare("INSERT INTO khachhang (tenkhachhang, sdt, diachi, idTaiKhoan) VALUES (?, ?, ?, ?)");
        $stmtInsertCustomer->bind_param('sisi', $tenkhachhang, $sdt, $diachi, $idAccount);
        $stmtInsertCustomer->execute();
        $idCustomer = $conn->insert_id;

        $stmtInsertBill = $conn->prepare("INSERT INTO hoadon (tongtien, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)");
        $stmtInsertBill->bind_param("dsii", $tongtien, $ghichu, $idNhanVien, $idCustomer);
        $stmtInsertBill->execute();
        $idHoaDon = $conn->insert_id;

        $stmtInsertDetail = $conn->prepare("INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)");
        $stmtUpdateSanPham = $conn->prepare("UPDATE chitietsanpham SET soluongconlai = ? WHERE idChiTietSanPham = ?");

        foreach ($detail as $item) {
            $soLuong = intval($item['soluong']);
            $idChiTietSanPham = intval($item['idChiTietSanPham']);
            $soLuongConLai = intval($item['soluongconlai']);

            if ($soLuongConLai < $soLuong) {
                throw new Exception("Số lượng không đủ cho sản phẩm ID: $idChiTietSanPham");
            }

            $stmtInsertDetail->bind_param("iii", $soLuong, $idHoaDon, $idChiTietSanPham);
            $stmtInsertDetail->execute();

            $newAmount = $soLuongConLai - $soLuong;
            $stmtUpdateSanPham->bind_param("ii", $newAmount, $idChiTietSanPham);
            $stmtUpdateSanPham->execute();
        }

        $conn->commit();
        echo json_encode(["status" => "success", "idHoaDon" => $idHoaDon]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        $conn->close();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Yêu cầu không hợp lệ!"]);
}

?>
