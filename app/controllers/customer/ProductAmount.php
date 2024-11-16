
<!-- product detail -->
<?php

    require_once "customerController.php";
    include "../../../config/connectdb.php";

    if (isset($_POST['action']) && $_POST['action'] == 'select') {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $productID = $_POST['productId'];

    $Amount = getProductAmount($productID, $size, $color);

    if ($Amount) {
        echo $Amount;  // In ra số lượng sản phẩm còn lại
    } else {
        echo '0';
    }

    }else{
        echo 'không có số lượng';
    }

?>

