<?php

    include "../../config/connect.php";

    include "../../app/views/manager/includes/header.php";

    if (!isset($_GET['page'])) {
        include '../../public/manager/TrangChu.php';
    } else {
        include "../../public/manager/" . $_GET['page'] . ".php";
    }
    
    include "../../app/views/manager/includes/footer.php";

?>