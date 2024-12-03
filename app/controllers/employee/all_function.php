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
        $colors[] = $row['mausac']; // Lấy giá trị màu sắc và thêm vào mảng
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
        $sizes[] = $row['kichthuoc']; // Lấy giá trị kích thước và thêm vào mảng
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();

    // Trả về mảng kích thước (nếu không có kích thước nào, mảng sẽ rỗng)
    return $sizes;
}


?>