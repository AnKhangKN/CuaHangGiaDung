<?php

    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/config/connect.php");

    include '../../app/views/manager/includes/header.php';

    if (!isset($_GET['page'])) {
        include '../../app/views/manager/TrangChu.php';
    } else {
        include "../../app/views/manager/" . $_GET['page'] . ".php";
    }
    
    include '../../app/views/manager/includes/footer.php';

?>