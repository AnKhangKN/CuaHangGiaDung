<?php

require_once "../../../config/connectdb.php";
require_once "all_function.php";

// Kiểm tra xem giá trị của query có tồn tại và không phải chuỗi trống
if (isset($_POST['query']) && $_POST['query'] !== "") {
    // Nếu có từ khóa tìm kiếm
    $ProductName = $_POST['query'];

    // Gọi hàm tìm kiếm sản phẩm
    $rowProduct = searchProductByName($ProductName);

    if (!empty($rowProduct) && is_array($rowProduct)) {
        // Nếu tìm thấy sản phẩm
        foreach ($rowProduct as $Row) {
            ?>
            <tr class="cell_product">
                <td class="idSanPham"><?php echo htmlentities($Row['idSanPham']); ?></td>
                <td class="tenSanPham"><?php echo htmlentities($Row['tensanpham']); ?></td>
                <td>
                    <div class="product_img" style="width: 90px;">
                        <img class="w-100 h-100 object-fit-cover imgSanPham" 
                            src="../../public/assets/images/products/<?php echo htmlentities($Row['urlhinhanh']); ?>" alt="Hình sản phẩm">
                    </div>
                </td>
                <td class="giaSanPham"><?php echo number_format($Row['dongia'], 0, ',', '.'); ?></td>
            </tr>
            <?php
        }
    } else {
        // Nếu không tìm thấy sản phẩm, hiển thị thông báo
        echo "<tr><td colspan='4'>Không tìm thấy sản phẩm phù hợp</td></tr>";
    }
} else {
    // Nếu không có từ khóa tìm kiếm (chuỗi trống hoặc không có giá trị), hiển thị tất cả sản phẩm
    $rowAllProduct = getProduct();

    if (!empty($rowAllProduct)) {
        // Hiển thị tất cả sản phẩm
        foreach ($rowAllProduct as $product) {
            ?>
            <tr class="cell_product">
                <td class="idSanPham"><?php echo htmlentities($product['idSanPham']); ?></td>
                <td class="tenSanPham"><?php echo htmlentities($product['tensanpham']); ?></td>
                <td>
                    <div class="product_img" style="width: 90px;">
                        <img class="w-100 h-100 object-fit-cover imgSanPham" 
                            src="../../public/assets/images/products/<?php echo htmlentities($product['urlHinhAnh']); ?>" alt="Hình sản phẩm">
                    </div>
                </td>
                <td class="giaSanPham"><?php echo number_format($product['dongia'], 0, ',', '.'); ?></td>
            </tr>
            <?php
        }
    } else {
        // Nếu không có sản phẩm nào trong hệ thống
        echo "<tr><td colspan='4'>Không có sản phẩm nào trong hệ thống</td></tr>";
    }
}
?>
