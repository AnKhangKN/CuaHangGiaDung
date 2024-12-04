<?php

if (isset($_POST['action']) && $_POST['action'] === 'InfoSanPham') {

    // Lấy thông tin sản phẩm từ yêu cầu POST
    $idSanPham = $_POST['idSanPham'];
    $tenSanPham = $_POST['tenSanPham'];
    $imgSanPham = $_POST['imgSanPham'];
    $giaSanPham = $_POST['giaSanPham'];

    // Trả về thông tin sản phẩm dưới dạng JSON
    echo json_encode([
        'status' => 'success',
        'idSanPham' => $idSanPham,
        'tenSanPham' => $tenSanPham,
        'imgSanPham' => $imgSanPham,
        'giaSanPham' => $giaSanPham,
    ]);

}

?>
