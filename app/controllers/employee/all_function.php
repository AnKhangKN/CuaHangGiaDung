<?php

// Lấy tất cả sản phẩm (tên, id, hình ảnh, giá)
function getProduct() {
    $conn = connectBD();

    $sql = "SELECT sp.idSanPham, sp.tensanpham, MIN(hasp.urlhinhanh) AS urlHinhAnh, sp.dongia
            FROM sanpham sp
            JOIN hinhanhsanpham hasp 
            ON hasp.idSanPham = sp.idSanPham
            GROUP BY sp.idSanPham, sp.tensanpham, sp.dongia;";
    
    $stmt = $conn->prepare($sql);

    // Kiểm tra nếu không chuẩn bị được câu lệnh
    if (!$stmt) {
        die("Chuẩn bị câu lệnh thất bại: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];

    // Lặp qua từng dòng kết quả
    while ($rowProduct = $result->fetch_assoc()) {
        $rows[] = $rowProduct;
    }

    $stmt->close();
    $conn->close();

    // Trả về danh sách sản phẩm
    return $rows;
}

function getCustomer() {
    $conn = connectBD();

    $sql = " SELECT idKhachHang, tenkhachhang, sdt 
    FROM khachhang; ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();

    $row = [];

    while ( $rowCustomer = $result->fetch_assoc()) {
        $row[] = $rowCustomer;
    }

    $stmt->close();
    $conn->close();

    return $row;
}

function getColorByProductId($ProductId) {
    // Kết nối tới cơ sở dữ liệu
    $conn = connectBD();

    // Câu truy vấn SQL để lấy các màu sắc của sản phẩm
    $sql = "SELECT DISTINCT mausacsanpham.mausac
            FROM mausacsanpham
            JOIN chitietsanpham ON mausacsanpham.idMauSac = chitietsanpham.idMauSac
            WHERE chitietsanpham.idSanPham = ?";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $ProductId); // Gắn giá trị của ProductId vào câu truy vấn

    // Thực thi câu truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    // Mảng lưu trữ kết quả màu sắc
    $colors = [];

    // Lặp qua các kết quả và thêm vào mảng
    while ($row = $result->fetch_assoc()) {
        $colors[] = $row; // Lấy giá trị màu sắc và thêm vào mảng
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();

    // Trả về mảng màu sắc (nếu không có màu sắc nào, mảng sẽ rỗng)
    return $colors;
}


function getSizeByProductId($ProductId) {
    // Kết nối tới cơ sở dữ liệu
    $conn = connectBD();

    // Câu truy vấn SQL để lấy các kích thước của sản phẩm
    $sql = "SELECT DISTINCT kichthuocsanpham.kichthuoc
            FROM kichthuocsanpham
            JOIN chitietsanpham ON kichthuocsanpham.idKichThuoc = chitietsanpham.idKichThuoc
            WHERE chitietsanpham.idSanPham = ?";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $ProductId); 

    // Thực thi câu truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    // Mảng lưu trữ kết quả kích thước
    $sizes = [];

    // Lặp qua các kết quả và thêm vào mảng
    while ($row = $result->fetch_assoc()) {
        // Đảm bảo rằng mỗi phần tử trong mảng có khóa 'kichthuoc'
        if (isset($row['kichthuoc'])) {
            $sizes[] = $row; // Thêm vào mảng kết quả
        }
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();

    // Trả về mảng kích thước (nếu không có kích thước nào, mảng sẽ rỗng)
    return $sizes;
}

function getInfo($Info) {
    // Kết nối tới cơ sở dữ liệu
    $conn = connectBD();

    // Câu lệnh SQL để lấy dữ liệu
    $sql = "SELECT nhanvien.idNhanVien, nhanvien.tennhanvien, nhanvien.sdt, nhanvien.cccd, nhanvien.luong, nhanvien.thuong
            FROM `nhanvien`
            JOIN taikhoan ON taikhoan.idTaiKhoan = nhanvien.idTaiKhoan
            WHERE taikhoan.idTaiKhoan = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($sql)) {
        // Gán tham số vào truy vấn
        $stmt->bind_param('i', $Info);

        // Thực thi câu truy vấn
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        // Trích xuất kết quả
        $data = $result->fetch_assoc();

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();

        // Trả về kết quả
        return $data;
    } else {
        // Xử lý lỗi nếu chuẩn bị câu lệnh thất bại
        die("Chuẩn bị câu lệnh thất bại: " . $conn->error);
    }
}

function getProductAmount($ProductId, $Size = "không có kích thước", $Color) {
    $conn = connectBD(); 
    
    // Kiểm tra nếu ProductId và Color hợp lệ
    if (!$ProductId || !$Color) {
        return null; // Trả về null nếu không có productId hoặc color
    }

    // Câu truy vấn linh hoạt dựa trên giá trị của $Size
    $sql = "SELECT ctsp.soluongconlai AS amount, ctsp.idChiTietSanPham AS id 
            FROM chitietsanpham ctsp
            JOIN mausacsanpham mssp ON mssp.idMauSac = ctsp.idMauSac";

    // Nếu $Size không phải là "không có kích thước", thêm JOIN và điều kiện kích thước
    if ($Size !== "không có kích thước") {
        $sql .= " JOIN kichthuocsanpham ktsp ON ktsp.idKichThuoc = ctsp.idKichThuoc
                WHERE ctsp.idSanPham = ? AND ktsp.kichthuoc = ? AND mssp.mausac = ?";
    } else {
        $sql .= " WHERE ctsp.idSanPham = ? AND mssp.mausac = ?";
    }

    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);

    // Kiểm tra nếu chuẩn bị không thành công
    if (!$stmt) {
        return null; // Trả về null nếu không thể chuẩn bị truy vấn
    }

    // Gán tham số dựa trên trường hợp của $Size
    if ($Size !== "không có kích thước") {
        $stmt->bind_param("iss", $ProductId, $Size, $Color);
    } else {
        $stmt->bind_param("is", $ProductId, $Color);
    }

    // Thực thi truy vấn
    $stmt->execute();

    // Lấy kết quả
    $stmt->bind_result($amount, $id);

    if ($stmt->fetch()) {
        return ['amount' => $amount, 'id' => $id]; // Trả về mảng chứa số lượng và ID
    } else {
        return null; // Trả về null nếu không tìm thấy kết quả
    }
}


?>
