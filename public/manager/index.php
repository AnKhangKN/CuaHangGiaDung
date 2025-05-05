<?php

<<<<<<< HEAD
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/header.php");
=======
    include "../../config/connect.php";

    include "../../app/views/manager/includes/header.php";
>>>>>>> 5096cfbe63074b4db946ac854d3be1cfcf5c2769

    if (!isset($_GET['page'])) {
        include '../../public/manager/TrangChu.php';
    } else {
        include "../../public/manager/" . $_GET['page'] . ".php";
    }
    
<<<<<<< HEAD
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/footer.php");
=======
    include "../../app/views/manager/includes/footer.php";
>>>>>>> 5096cfbe63074b4db946ac854d3be1cfcf5c2769

?>