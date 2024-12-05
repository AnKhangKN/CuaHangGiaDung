<?php

require_once "../../../config/connectdb.php";
require_once "all_function.php";

// Kiểm tra xem giá trị của phone có tồn tại và không phải chuỗi trống
if (isset($_POST['phone']) && !empty($_POST['phone'])) {
    $sdt = $_POST['phone'];

    // Gọi hàm tìm kiếm khách hàng
    $rowCustomer = searchCustomerByPhone($sdt);

    if (!empty($rowCustomer) && is_array($rowCustomer)) {
        // Nếu tìm thấy khách hàng
        foreach ($rowCustomer as $Row) {
            ?>
            <li class="list-group-item">
                <span><?php echo htmlentities($Row['tenkhachhang']); ?></span>
                <span><?php echo htmlentities($Row['sdt']); ?></span>
            </li>
            <?php
        }
    } else {
        // Nếu không tìm thấy khách hàng, hiển thị thông báo
        echo '<li class="list-group-item">
                <span>Không tìm thấy khách hàng.</span>
            </li>';
    }
} else {
    
}

?>
