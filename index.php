<?php

include(__DIR__ . '/app/views/customer/include/header.php');

if(!isset($_GET['page'])){
    include(__DIR__ . '/app/views/customer/home.php');
} else{
    include(__DIR__ . '/app/views/customer/' .  $_GET['page'].'.php');
}

include(__DIR__ . '/app/views/customer/include/footer.php');