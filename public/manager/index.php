<?php

    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/config/connect.php");

    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/header.php");

    if (!isset($_GET['page'])) {
        include '../../public/manager/TrangChu.php';
    } else {
        include "../../public/manager/" . $_GET['page'] . ".php";
    }
    
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/footer.php");

?>