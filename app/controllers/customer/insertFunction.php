<?php

function createAccount($email, $password) {
    
    $conn = connectBD();

    $checkEmailSql = "SELECT * FROM taikhoan WHERE email = ?";
    $stmt = $conn->prepare($checkEmailSql);

    // Kiểm tra câu lệnh chuẩn bị có thành công không
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Liên kết email vào câu lệnh SQL
    $stmt->bind_param('s', $email);
    $stmt->execute();

    // Kiểm tra xem có bản ghi nào trả về không (email đã tồn tại)
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Nếu có, email đã tồn tại, trả về thông báo lỗi
        return ['success' => false, 'message' => 'Email đã tồn tại.'];
    }

    // Nếu email chưa tồn tại, tiếp tục tạo tài khoản
    $sql = "INSERT INTO taikhoan (email, matkhau) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Kiểm tra câu lệnh chuẩn bị có thành công không
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Liên kết các tham số vào câu lệnh SQL
    $stmt->bind_param('ss', $email, $password);
    $result = $stmt->execute();

    // Kiểm tra kết quả thực thi câu lệnh
    if ($result) {
        // Lấy ID của bản ghi mới vừa chèn vào
        $last_id = $conn->insert_id;

        // Trả về kết quả thành công và ID của tài khoản mới
        return ['success' => true, 'id' => $last_id];
    } else {
        // Nếu có lỗi trong quá trình tạo tài khoản, trả về lỗi
        return ['success' => false, 'message' => 'Có lỗi khi tạo tài khoản.'];
    }

    // Đóng statement và kết nối
    $stmt->close();
    $conn->close();
}

function createCustomer($hoten, $sdt, $diachi, $idTaiKhoan) {
    // Kết nối cơ sở dữ liệu
    $conn = connectBD();

    // Câu lệnh SQL để chèn thông tin khách hàng
    $sql = "INSERT INTO khachhang (tenkhachhang, sdt, diachi, idTaiKhoan) VALUES (?, ?, ?, ?)";
    
    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Liên kết các tham số vào câu lệnh SQL
    $stmt->bind_param('sssi', $hoten, $sdt, $diachi, $idTaiKhoan);

    // Thực thi câu lệnh SQL
    $result = $stmt->execute();

    // Xử lý kết quả thực thi
    if ($result) {
        // Lấy ID của bản ghi mới vừa chèn vào
        $last_id = $conn->insert_id;

        // Trả về kết quả thành công và ID của khách hàng mới
        return ['success' => true, 'id' => $last_id];
    } else {
        // Trả về thông báo lỗi nếu có vấn đề
        return ['success' => false, 'message' => 'Có lỗi khi tạo khách hàng.'];
    }

    // Đảm bảo đóng statement và kết nối trong trường hợp có lỗi hoặc thành công
    $stmt->close();
    $conn->close();
}

// function createBill($tongtien, $ghichu, $idNhanVien, $idKhachHang) {
//     // Kết nối cơ sở dữ liệu
//     $conn = connectBD();

//     // Câu lệnh SQL để chèn thông tin hóa đơn
//     $sql = "INSERT INTO hoadon (tongtien, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)";

//     // Chuẩn bị câu lệnh SQL
//     $stmt = $conn->prepare($sql);

//     if ($stmt === false) {
//         die("Error preparing statement: " . $conn->error);
//     }

//     // Kiểm tra nếu $tongtien là số nguyên và $idNhanVien, $idKhachHang là số nguyên
//     if (!is_int($tongtien) || !is_int($idNhanVien) || !is_int($idKhachHang)) {
//         return ['success' => false, 'message' => 'Dữ liệu không hợp lệ.'];
//     }

//     // Liên kết các tham số vào câu lệnh SQL (thông qua bind_param)
//     // 'i' cho số nguyên (int), 's' cho chuỗi (string)
//     $stmt->bind_param('isii', $tongtien, $ghichu, $idNhanVien, $idKhachHang);

//     // Thực thi câu lệnh SQL
//     $result = $stmt->execute();

//     // Xử lý kết quả thực thi
//     if ($result) {
//         // Lấy ID của bản ghi mới vừa chèn vào
//         $last_id = $conn->insert_id;

//         // Trả về kết quả thành công và ID của hóa đơn mới
//         return ['success' => true, 'id' => $last_id];
//     } else {
//         // Trả về thông báo lỗi nếu có vấn đề
//         return ['success' => false, 'message' => 'Không thể tạo hóa đơn.'];
//     }

//     // Đảm bảo đóng statement và kết nối trong trường hợp có lỗi hoặc thành công
//     $stmt->close();
//     $conn->close();
// }



function createBillDetailsBatch($details, $idHoaDon) {
    // Kết nối cơ sở dữ liệu
    $conn = connectBD();

    // Câu lệnh SQL để chèn thông tin chi tiết hóa đơn
    $sql = "INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)";
    
    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bắt đầu giao dịch (transaction) để đảm bảo tính toàn vẹn dữ liệu
    $conn->begin_transaction();

    // Lặp qua các chi tiết hóa đơn và chèn từng cái một
    foreach ($details as $detail) {
        // Kiểm tra dữ liệu hợp lệ
        if (!is_numeric($detail['soluong']) || !is_int($detail['idChiTietSanPham'])) {
            // Nếu dữ liệu không hợp lệ, quay lại và hủy giao dịch
            $conn->rollback();
            return false;
        }

        // Liên kết tham số vào câu lệnh SQL
        $stmt->bind_param('iii', $detail['soluong'], $idHoaDon, $detail['idChiTietSanPham']);
        
        // Thực thi câu lệnh SQL
        if (!$stmt->execute()) {
            // Nếu có lỗi trong quá trình chèn, quay lại và hủy giao dịch
            $conn->rollback();
            return false;
        }
    }

    // Commit giao dịch sau khi tất cả đã thành công
    $conn->commit();

    // Đóng statement và kết nối
    $stmt->close();
    $conn->close();

    return true;
}


function createBill($tongtien, $ghichu, $idNhanVien, $idKhachHang, $products) {
    // Kết nối cơ sở dữ liệu
    $conn = connectBD();

    // Câu lệnh SQL để chèn thông tin hóa đơn
    $sql = "INSERT INTO hoadon (tongtien, ghichu, idNhanVien, idKhachHang) VALUES (?, ?, ?, ?)";
    
    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Kiểm tra nếu $tongtien là số và các ID là số nguyên
    if (!is_numeric($tongtien) || !is_int($idNhanVien) || !is_int($idKhachHang)) {
        return ['success' => false, 'message' => 'Dữ liệu không hợp lệ.'];
    }

    // Liên kết các tham số vào câu lệnh SQL
    // 'd' cho số thực (float), 's' cho chuỗi (string), 'i' cho số nguyên
    $stmt->bind_param('dsii', $tongtien, $ghichu, $idNhanVien, $idKhachHang);

    // Thực thi câu lệnh SQL
    $result = $stmt->execute();

    // Xử lý kết quả thực thi
    if ($result) {
        // Lấy ID của bản ghi mới vừa chèn vào
        $last_id = $conn->insert_id;

        // Kiểm tra nếu $products là một mảng hợp lệ và không rỗng
        if (!empty($products)) {
            // Tiến hành thêm chi tiết hóa đơn vào bảng chitiethoadon
            foreach ($products as $product) {
                $idChiTietSanPham = $product['idChiTietSanPham'];
                $soluong = $product['soluong'];

                // Câu lệnh SQL để thêm chi tiết hóa đơn
                $sql_detail = "INSERT INTO chitiethoadon (soluong, idHoaDon, idChiTietSanPham) VALUES (?, ?, ?)";
                $stmt_detail = $conn->prepare($sql_detail);

                if ($stmt_detail === false) {
                    die("Error preparing statement: " . $conn->error);
                }

                // Liên kết các tham số vào câu lệnh SQL cho chi tiết hóa đơn
                $stmt_detail->bind_param('iii', $soluong, $last_id,  $idChiTietSanPham);

                // Thực thi câu lệnh chèn chi tiết hóa đơn
                $stmt_detail->execute();
                $stmt_detail->close();
            }
        }

        // Trả về kết quả thành công và ID của hóa đơn mới
        return ['success' => true, 'id' => $last_id];
    } else {
        // Trả về thông báo lỗi nếu có vấn đề
        return ['success' => false, 'message' => 'Không thể tạo hóa đơn.'];
    }

    // Đảm bảo đóng statement và kết nối trong trường hợp có lỗi hoặc thành công
    $stmt->close();
    $conn->close();
}


?>