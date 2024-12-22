<?php 
// Detail

    // get product detail
    function getProductByProductId($idproduct) {
        // Kết nối đến cơ sở dữ liệu
        $conn = connectBD();
        
        // Chuyển đổi $idproduct thành số nguyên để tránh lỗi
        $idproduct = (int)$idproduct;

        // Nếu id hợp lệ, thực hiện truy vấn
        if ($idproduct > 0) {
            // Câu truy vấn
            $sql = "SELECT * FROM sanpham WHERE idSanPham = ? AND trangthai = 1";

            // Chuẩn bị và thực thi câu truy vấn
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idproduct);
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            return $result->fetch_assoc();

            // Đóng statement và kết nối
            $stmt->close();
            $conn->close();
        } else {    
            // Trả về null nếu id không hợp lệ
            return 0;
        }
    }

    // get img product detail
    function getImageUrlsByProductId($product_id) {
        $conn = connectBD();

        $product_id = (int)$product_id;

        if ($product_id > 0) {
            $sql = "SELECT * FROM hinhanhsanpham WHERE idSanPham = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id); 
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Trả về tất cả hình ảnh dưới dạng mảng
        } else {
            // Trả về mảng rỗng nếu id không hợp lệ
            return [];
        }
    }

// --------------------------------------------------------------------------------

function getAllProducts($status = 1, $offset) {
    // Kết nối cơ sở dữ liệu
    $conn = connectBD();

    // Câu lệnh SQL với LIMIT và OFFSET
    $sql = "SELECT sp.*, ha.urlhinhanh AS urlhinhanh, dm.tendanhmuc
            FROM sanpham sp
            JOIN hinhanhsanpham ha ON ha.idSanPham = sp.idSanPham
            JOIN danhmucsanpham dm ON dm.idDanhMuc = sp.idDanhMuc
            WHERE sp.trangthai = ?
            GROUP BY sp.idSanPham
            LIMIT ?, 20";  
    
    // Chuẩn bị truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $offset); 
    $stmt->execute();
    
    // Lấy kết quả
    $result = $stmt->get_result();
    $rows = [];
    
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    
    // Đóng kết nối
    $stmt->close();
    $conn->close();
    
    return $rows;
}



function countTotalProduct($status = 1, $itemsPerPage = 20) {
    // Kết nối cơ sở dữ liệu
    $conn = connectBD();
    
    // Sử dụng COUNT để tính tổng số sản phẩm
    $sql = "SELECT COUNT(*) as total FROM sanpham WHERE trangthai = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $status); // Gán giá trị trạng thái
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Tính tổng số trang
    $totalBills = (int)$row['total']; 
    return ceil($totalBills / $itemsPerPage); 
}

// --------------------------------------------------------------------------------

    // get customer by id Account
    function getCustomerById($idTaiKhoan) {
        $conn = connectBD();

        // Chuyển đổi $idTaiKhoan thành số nguyên để tránh lỗi
        $idTaiKhoan = (int)$idTaiKhoan;

        // Nếu id hợp lệ, thực hiện truy vấn
        if ($idTaiKhoan > 0) {
            // Câu truy vấn
            $sql = "SELECT * FROM khachhang WHERE idTaiKhoan = ?";

            // Chuẩn bị và thực thi câu truy vấn
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idTaiKhoan); // Bind idTaiKhoan
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Trả về thông tin khách hàng
        } else {
            // Trả về null nếu id không hợp lệ
            return null;
        }
    }


    // get all bills by customer id with pagination
function getBillsByIdCustomer($idCustomer, $begin) {
    $conn = connectBD();
    
    $idCustomer = (int)$idCustomer;
    $begin = (int)$begin;
    
    if ($idCustomer > 0) {
        // Câu lệnh SQL với LIMIT và OFFSET
        $sql = 'SELECT * FROM hoadon WHERE idKhachHang = ? ORDER BY ngayxuathoadon DESC LIMIT ?, 10';
        $stmt = $conn->prepare($sql);
        
        // Gán tham số cho câu truy vấn
        $stmt->bind_param("ii", $idCustomer, $begin);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $bills = [];
        
        // Lấy kết quả và đưa vào mảng
        while ($row = $result->fetch_assoc()) {
            $bills[] = $row;
        }
        
        return $bills;
    } else {
        return null;
    }
}

    // Hàm đếm tổng số hóa đơn
    function countTotalPagesByCustomer($idCustomer, $itemsPerPage = 10) {
        $conn = connectBD();
    
        // Đếm tổng số hóa đơn
        $sql = 'SELECT COUNT(*) as total FROM hoadon WHERE idKhachHang = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idCustomer);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        // Tính tổng số trang
        $totalBills = (int)$row['total']; 
        return ceil($totalBills / $itemsPerPage); 
    }
    // ----------------------------------------------------

    function getBillById($idBill) {
        // Kết nối đến cơ sở dữ liệu
        $conn = connectBD();
        
        // Chuyển đổi $idproduct thành số nguyên để tránh lỗi
        $idBill = (int)$idBill;

        // Nếu id hợp lệ, thực hiện truy vấn
        if ($idBill > 0) {
            // Câu truy vấn
            $sql = "SELECT * FROM hoadon
            WHERE idHoaDon = ?";

            // Chuẩn bị và thực thi câu truy vấn
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idBill);
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {    
            // Trả về null nếu id không hợp lệ
            return 0;
        }
    }
    
    function checkComment($idBill) {
        $conn = connectBD();
    
        // Đảm bảo idBill là số nguyên
        $idBill = (int)$idBill;
    
        if ($idBill > 0) {
            // SQL query để kiểm tra bình luận của hóa đơn
            $sql = "SELECT * FROM binhluan WHERE idHoaDon = ?";
    
            // Chuẩn bị câu lệnh SQL
            if ($stmt = $conn->prepare($sql)) {
                // Liên kết tham số
                $stmt->bind_param('i', $idBill);
                $stmt->execute();
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    return $result->fetch_assoc();
                } else {
                    return null;
                }
            } else {
                return false;
            }
        } else {
            return 0;
        }
    
        // Đóng kết nối cơ sở dữ liệu
        $conn->close();
    }
    

    // get all detail bill
    function getAllDetailBillByIdBill($idBill){
        $conn = connectBD();
    
        $idBill = (int)$idBill;
        if ($idBill > 0) {
            $sql = 'SELECT * FROM chitiethoadon WHERE idHoaDon = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idBill);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $detail_bills = [];
        
            while ($row = $result->fetch_assoc()) {
                $detail_bills[] = $row;
            }
        
            return $detail_bills;
        } else {
            return null;
        }
    }

    // get all detail bill
    function getAllDetailBillByIdBillWithProductName($idBill){
        $conn = connectBD();
    
        $idBill = (int)$idBill;
        if ($idBill > 0) {
            $sql = 'SELECT sp.idSanPham, sp.tensanpham, SUM(cthd.soluong) soluong ,  ms.mausac,  kt.kichthuoc
                    FROM chitiethoadon cthd
                    JOIN chitietsanpham ctsp ON ctsp.idChiTietSanPham = cthd.idChiTietSanPham
                    JOIN sanpham sp ON sp.idSanPham = ctsp.idSanPham
                    JOIN kichthuocsanpham kt ON ctsp.idKichThuoc = kt.idKichThuoc
                    JOIN mausacsanpham ms ON ms.idMauSac = ctsp.idMauSac
                    WHERE idHoaDon = ?
                    GROUP BY ctsp.idChiTietSanPham';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idBill);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $detail_bills = [];
        
            while ($row = $result->fetch_assoc()) {
                $detail_bills[] = $row;
            }
        
            return $detail_bills;
        } else {
            return null;
        }
    }

    function getAccountById($idAccount){
        $conn = connectBD();

        $idAccount = (int)$idAccount;
        if($idAccount > 0){
            $sql = 'SELECT * FROM taikhoan WHERE idTaiKhoan = ?';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i',$idAccount);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {    
            // Trả về null nếu id không hợp lệ
            return 0;
        }
        
    }

    // filter ----------------------------------------------------------------
    function getAllProductsColor() {
        $conn = connectBD();
        
        $sql = 'SELECT DISTINCT(mssp.mausac) FROM sanpham sp 
                JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
                JOIN mausacsanpham mssp ON ctsp.idMauSac = mssp.idMauSac
                WHERE sp.trangthai = 1 AND ctsp.soluongconlai > 0';
    
        $result = $conn->query($sql);
        $row_color = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row_color[] = $row;
            }
        }
    
        return $row_color;
    }
    

    function getAllCategory() {
        $conn = connectBD();
    
        $sql = 'SELECT * FROM danhmucsanpham';
        $result = $conn->query($sql);
    
        $row_category = []; 
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row_category[] = $row;
            }
        } else {
            // Xử lý lỗi khi truy vấn không thành công
            echo "Lỗi: " . $conn->error;
        }
    
        $conn->close(); // Đóng kết nối cơ sở dữ liệu
        return $row_category;
    }
    

    function getProductsSizeByCategoryName($tendanhmuc){
        $conn = connectBD();

        $sql = 'SELECT DISTINCT(ktsp.kichthuoc), dmsp.tendanhmuc FROM sanpham sp 
                JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
                JOIN kichthuocsanpham ktsp ON ctsp.idKichThuoc = ktsp.idKichThuoc
                JOIN danhmucsanpham dmsp ON dmsp.idDanhMuc = sp.idDanhMuc
                WHERE sp.trangthai = 1 AND ctsp.soluongconlai > 0 AND dmsp.tendanhmuc = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $tendanhmuc);
        $stmt->execute();

        $result = $stmt->get_result();
        $row_size = [];
    
        while ($row = $result->fetch_assoc()) {
            $row_size[] = $row;
        }
    
        return $row_size;
    }

    function getProductsSizeByProductId($idProduct){
        $conn = connectBD();

        $idProduct = (int)$idProduct;

        $sql = 'SELECT DISTINCT(ktsp.kichthuoc), sp.tensanpham FROM sanpham sp 
                JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
                JOIN kichthuocsanpham ktsp ON ctsp.idKichThuoc = ktsp.idKichThuoc
                WHERE sp.trangthai = 1 AND ctsp.soluongconlai > 0 AND sp.idSanPham = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $idProduct);
        $stmt->execute();

        $result = $stmt->get_result();
        $row_size = [];
    
        while ($row = $result->fetch_assoc()) {
            $row_size[] = $row;
        }
        return $row_size;
    }

    // get product color

    function getProductColorByProductId($productid){
        $conn = connectBD();

        $productid = (int)$productid;
        if($productid > 0){

            $sql = 'SELECT sp.* , mssp.*, ctsp.idChiTietSanPham
                FROM sanpham sp
                JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
                JOIN mausacsanpham mssp ON mssp.idMauSac = ctsp.idMauSac
                WHERE ctsp.soluongconlai > 0 AND sp.idSanPham = ?
                GROUP BY mssp.mausac';
                }
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i',$productid);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $row_color = [];
            while($row = $result->fetch_assoc()){
                $row_color[] = $row; 
            }
            return $row_color;
        }

    // category ----------------------------------------------------------------
    function getCategoryByProductId($productId){

        $conn = connectBD();

        $productId = (int)$productId;

        if($productId > 0){
        $sql = 'SELECT dmsp.* , sp.tensanpham FROM danhmucsanpham dmsp
            JOIN sanpham sp ON sp.idDanhMuc = dmsp.idDanhMuc
            WHERE sp.idSanPham = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i',$productId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
        } else {    
            // Trả về null nếu id không hợp lệ
            return 0;
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
    

    // Tìm kiếm sản phẩm
    function searchProductByName($ProductName){
        $conn = connectBD();

        // Câu SQL
        $sql = "SELECT sp.*, MIN(hasp.urlhinhanh) AS urlhinhanh
                FROM sanpham sp
                JOIN hinhanhsanpham hasp ON sp.idSanPham = hasp.idSanPham
                WHERE sp.tensanpham LIKE ?
                GROUP BY sp.idSanPham;";

        if ($ProductName) {
            // Thêm ký tự '%' vào từ khóa tìm kiếm
            $ProductName = '%' . $ProductName . '%';

            // Chuẩn bị và thực thi câu lệnh
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $ProductName);
            $stmt->execute();

            // Lấy kết quả
            $row_product = [];
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $row_product[] = $row;
            }

            // Trả về danh sách sản phẩm
            return $row_product;
        }

        // Trường hợp không có từ khóa tìm kiếm
        return [];
    }


    // update information
    function updateInfo($ChangeItem, $Item, $CustomerId) {
        $conn = connectBD();
    
        $allowedColumns = ['tenkhachhang', 'sdt', 'diachi'];
        if (!in_array($ChangeItem, $allowedColumns)) {
            return "Tên cột không hợp lệ.";
        }
    
        $sql = "UPDATE khachhang SET $ChangeItem = ? WHERE idKhachHang = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt === false) {
            return "Lỗi khi chuẩn bị câu lệnh: " . $conn->error;
        }
    
        $stmt->bind_param('si', $Item, $CustomerId);
        $stmt->execute();
    
        if ($stmt->error) {
            return "Lỗi khi thực thi câu lệnh: " . $stmt->error;
        }
    
        $stmt->close();
        $conn->close();
    
        return "Cập nhật thành công!";
    }
    
    
?>

