<?php

    include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/connect.php");

    include(__DIR__. '/includes/header.php');

    if (!isset($_GET['page'])) {
        include(__DIR__. '/TrangChu.php');
    }
    else {
        include(__DIR__. '/'. $_GET['page']. '.php');
    }

    include(__DIR__. '/includes/footer.php');

?>