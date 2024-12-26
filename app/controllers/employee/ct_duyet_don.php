<?php

require_once "../../../config/connectdb.php";
require_once "all_function.php";

if (isset($_POST['action']) && $_POST['action'] === 'ct_duyet_don') {
    // Kiểm tra và lấy dữ liệu từ POST
    $idHoaDon = isset($_POST['BillId']) ? intval($_POST['BillId']) : 0;

    if ($idHoaDon > 0) {
        // Lấy danh sách sản phẩm trong hóa đơn
        $Product = getApprove_orders($idHoaDon);

        if (!empty($Product)) {
            // Duyệt qua từng sản phẩm để hiển thị
            foreach ($Product as $Row) {
                ?>
                <tr class="order_product">
                    <td class="idSanPham"><?php echo htmlentities($Row['idSanPham'] ?? ''); ?></td>
                    <td class="tensanpham d-flex flex-column">
                        <span><?php echo htmlentities($Row['tensanpham'] ?? ''); ?></span>
                        <span><?php echo htmlentities($Row['kichthuoc'] ?? ''); ?></span>
                        <span><?php echo htmlentities($Row['mausac'] ?? ''); ?></span>
                    </td>
                    <td class="soLuong"><?php echo htmlentities($Row['soluong'] ?? ''); ?></td>
                    <td class="thanhTien"><?php echo number_format($Row['thanhtien'] ?? 0, 0, ',', '.'); ?> VND</td>
                </tr>
                <?php
            }
        } else {
            // Không có sản phẩm nào trong hóa đơn
            echo '<tr><td colspan="7">Không có sản phẩm trong hóa đơn này.</td></tr>';
        }
    } else {
        // Lỗi nếu ID hóa đơn không hợp lệ
        echo '<tr><td colspan="7">ID hóa đơn không hợp lệ.</td></tr>';
    }
}
?>
