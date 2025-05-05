<?php 
<<<<<<< HEAD
include 'C:\xampp\htdocs\CuaHangGiaDung\config\connectdb.php';
=======
include '../../../config/connectdb.php';
>>>>>>> b2f6cfd84423ea88131c163e446690d8d38d2e96

if (isset($_POST['action'])) {
    $Product = 'SELECT DISTINCT sp.idSanPham, sp.tensanpham, sp.dongia, hasp.urlhinhanh, dmsp.tendanhmuc
                FROM sanpham sp 
                JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
                JOIN hinhanhsanpham hasp ON sp.idSanPham = hasp.idSanPham
                JOIN danhmucsanpham dmsp ON sp.idDanhMuc = dmsp.idDanhMuc
                JOIN mausacsanpham mssp ON ctsp.idMauSac = mssp.idMauSac
                JOIN kichthuocsanpham ktsp ON ktsp.idKichThuoc = ctsp.idKichThuoc
                WHERE sp.trangthai = 1 AND ctsp.soluongconlai > 0';

    $filtersApplied = false;

    if (isset($_POST['color']) && !empty($_POST['color'])) {
        $color_filter = implode("','", array_map('htmlspecialchars', $_POST['color']));
        $Product .= " AND mssp.mausac IN ('$color_filter')";
        $filtersApplied = true;
    }

    if (isset($_POST['size']) && !empty($_POST['size'])) {
        $size_filter = implode("','", array_map('htmlspecialchars', $_POST['size']));
        $Product .= " AND ktsp.kichthuoc IN ('$size_filter')";
        $filtersApplied = true;
    }

    if (isset($_POST['price']) && !empty($_POST['price'])) {
        $price_filters = $_POST['price'];
        $price_conditions = [];

        foreach ($price_filters as $price) {
            switch ($price) {
                case '0-100000':
                    $price_conditions[] = "sp.dongia < 100000";
                    break;
                case '100000-250000':
                    $price_conditions[] = "sp.dongia BETWEEN 100000 AND 250000";
                    break;
                case '250000-500000':
                    $price_conditions[] = "sp.dongia BETWEEN 250000 AND 500000";
                    break;
                case '500000-800000':
                    $price_conditions[] = "sp.dongia BETWEEN 500000 AND 800000";
                    break;
                case '800000-1500000':
                    $price_conditions[] = "sp.dongia BETWEEN 800000 AND 1500000";
                    break;
                case '1500000':
                    $price_conditions[] = "sp.dongia > 1500000";
                    break;
            }
        }

        if (!empty($price_conditions)) {
            $Product .= " AND (" . implode(' OR ', $price_conditions) . ")";
            $filtersApplied = true;
        }
    }

    if (isset($_POST['arrange']) && !empty($_POST['arrange'])) {
        $arrange_conditions = [];
    
        foreach ($_POST['arrange'] as $arrange) {
            switch ($arrange) {
                case 'nameA-nameZ':
                    $arrange_conditions[] = "sp.tensanpham ASC";
                    break;
                case 'nameZ-nameA':
                    $arrange_conditions[] = "sp.tensanpham DESC";
                    break;
                case 'minPrice-maxPrice':
                    $arrange_conditions[] = "sp.dongia ASC";
                    break;
                case 'maxPrice-minPrice':
                    $arrange_conditions[] = "sp.dongia DESC";
                    break;
            }
        }
    
        // Kết hợp các điều kiện thành một chuỗi
        if (!empty($arrange_conditions)) {
            $arrange_condition = " ORDER BY " . implode(", ", $arrange_conditions);
        } else {
            $arrange_condition = "";
        }
    } else {
        $arrange_condition = "";
    }

    $Product .= ' GROUP BY sp.idSanPham ' . $arrange_condition ;


    $conn = connectBD();
    $stmt = $conn->prepare($Product);
    $stmt->execute();
    $result = $stmt->get_result();

    $rowProduct = '';
    if ($result->num_rows > 0) {
        while ($Row = $result->fetch_assoc()) {
            $rowProduct .= '
                <div class="col">
                    <div class="all_products_card filter_data" id="product-list">
                        <a href="index.php?page=details&id=' . htmlspecialchars($Row['idSanPham']) . '" class="all_products_card_link">
                            <img class="card-img-top all_products_card_img" 
                            src="../public/assets/images/products/' . htmlspecialchars($Row['urlhinhanh']) . '" 
                            alt="Card image" style="width:100%">
                            <div class="card-body">
                                <p class="all_products_card_title">' . htmlspecialchars($Row['tensanpham']) . '</p>
                                <p class="all_products_card_category">
                                    <span class="all_products_card_category">' . htmlspecialchars($Row['tendanhmuc']) . '</span>
                                </p>
                                <p class="all_products_card_price">
                                    <span class="all_products_card_new_price">' . number_format($Row['dongia'], 0, ',', '.') . ' đ</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            ';
        }
    } else {
        $rowProduct .= "<p style='text-align: center;'>Không tìm thấy sản phẩm.</p>";
    }

    echo $rowProduct;
}
?>
