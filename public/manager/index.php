<?php

    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/header.php");

    if (!isset($_GET['page'])) {
        include '../../public/manager/TrangChu.php';
    } else {
        include "../../public/manager/" . $_GET['page'] . ".php";
    }
    
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/footer.php");

?>