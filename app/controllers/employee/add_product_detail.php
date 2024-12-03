<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if (isset($_POST['action']) && $_POST['action'] === 'InfoSanPham') {

    // Retrieve product details from POST request
    $idSanPham = $_POST['idSanPham'];
    $tenSanPham = $_POST['tenSanPham'];
    $imgSanPham = $_POST['imgSanPham'];
    $giaSanPham = $_POST['giaSanPham'];

    // Query for product sizes
    $stmtSelectSize = $conn->prepare("
        SELECT kichthuocsanpham.kichthuoc
        FROM kichthuocsanpham
        JOIN chitietsanpham ON kichthuocsanpham.idKichThuoc = chitietsanpham.idKichThuoc
        WHERE chitietsanpham.idSanPham = ?
    ");
    $stmtSelectSize->bind_param('i', $idSanPham);
    $stmtSelectSize->execute();
    $resultSize = $stmtSelectSize->get_result();

    // Collect all sizes into an array
    $kichThuocList = [];
    while ($row = $resultSize->fetch_assoc()) {
        $kichThuocList[] = $row['kichthuoc'];
    }
    $stmtSelectSize->close();

    // Query for product colors
    $stmtSelectColor = $conn->prepare("
        SELECT mausacsanpham.mausac
        FROM mausacsanpham
        JOIN chitietsanpham ON mausacsanpham.idMauSac = chitietsanpham.idMauSac
        WHERE chitietsanpham.idSanPham = ?
        GROUP BY mausacsanpham.mausac
    ");
    $stmtSelectColor->bind_param('i', $idSanPham);
    $stmtSelectColor->execute();
    $resultColor = $stmtSelectColor->get_result();

    // Collect all colors into an array
    $mauSacList = [];
    while ($row = $resultColor->fetch_assoc()) {
        $mauSacList[] = $row['mausac'];
    }
    $stmtSelectColor->close();

    // Return the data as a JSON response
    echo json_encode([
        'status' => 'success',
        'kichthuoc' => $kichThuocList,  // List of sizes
        'mausac' => $mauSacList,        // List of colors
        'idSanPham' => $idSanPham,      // Single product ID
        'tenSanPham' => $tenSanPham,    // Single product name
        'urlHinhAnh' => $imgSanPham,    // Single image URL
        'giaSanPham' => $giaSanPham     // Single product price
    ]);
}

$conn->close();
?>
