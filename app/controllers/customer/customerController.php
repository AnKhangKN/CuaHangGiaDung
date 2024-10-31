<?php 
// Detail

    // get product detail
    function getProductById($idproduct) {
        // Kết nối đến cơ sở dữ liệu
        $conn = connectBD();
        
        // Chuyển đổi $idproduct thành số nguyên để tránh lỗi
        $idproduct = (int)$idproduct;

        // Nếu id hợp lệ, thực hiện truy vấn
        if ($idproduct > 0) {
            // Câu truy vấn
            $sql = "SELECT * FROM sanpham WHERE idSanPham = ?";

            // Chuẩn bị và thực thi câu truy vấn
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idproduct);
            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {    
            // Trả về null nếu id không hợp lệ
            return 0;
        }
    }
    
    

    // get img product detail
    function getImageUrlsByProductId($product_id) {
        global $pdo; // Sử dụng biến $pdo từ kết nối cơ sở dữ liệu
        $sql = "SELECT url FROM hinhanhsanpham WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
    
        // Tạo mảng chứa các URL ảnh
        $imageUrls = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $imageUrls[] = $row['url'];
        }
    
        return $imageUrls; // Trả về mảng URL ảnh
    }

// --------------------------------------------------------------------------------

// get product page
    function getAllProducts(){
        // Connect to the database
        $conn = connectBD();
        
        // Query to select all products from the 'sanpham' table
        $sql_all_products = mysqli_query($conn,
        "SELECT sp.*, MIN(ha.urlhinhanh) AS urlhinhanh, dm.tendanhmuc
        FROM sanpham sp
        JOIN hinhanhsanpham ha ON ha.idSanPham = sp.idSanPham
        JOIN danhmucsanpham dm ON dm.idDanhMuc = sp.idDanhMuc
        GROUP BY sp.idSanPham");
        
        // Initialize an array to store all rows
        $rows = [];

        // Loop through the result set and fetch all rows
        while($row_all_products = mysqli_fetch_array($sql_all_products)){
            $rows[] = $row_all_products;
        }

        // Return the array of all products
        return $rows;
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


    // get bill by id customer
    function getBillByIdCustomer($idCustomer) {
        $conn = connectBD();
    
        $idCustomer = (int)$idCustomer;
        if ($idCustomer > 0) {
            $sql = 'SELECT * FROM hoadon WHERE idKhachHang = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idCustomer);
            $stmt->execute();
    
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    
    

    // get bill by id
    function getBillById($idBill){
        $conn = connectBD();

        $idBill = (int)$idBill;
        if($idBill > 0){
            $sql = 'SELECT * FROM hoadon WHERE idHoaDon = ?';

            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("i", $idBill);
            $stmt -> execute();

            $result = $stmt->get_result();
            return $result-> fetch_assoc();
        }else{
            return 0;
        }
    }


?>

