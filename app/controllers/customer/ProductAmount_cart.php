<!-- cart -->

<?php

    require_once "customerController.php";
    require_once "../../../config/connectdb.php";

    if (isset($_POST['size']) && isset($_POST['color']) && isset($_POST['productId'])) {
    $size = $_POST['size'];
    $color = $_POST['color'];
    $productID = $_POST['productId'];

    $Amount = getProductAmount($productID, $size, $color);

    if ($Amount) {
        echo $Amount;  
    } else {
        echo '0';
    }

    }else{
        echo 'Không có số lượng';
    }

?>