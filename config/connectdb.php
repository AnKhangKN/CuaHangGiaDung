<?php

function connectBD(){
    
    $server = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ql_ch_hkn"; //tên cơ sở dữ liệu

    $conn = mysqli_connect($server, $user, $pass, $dbname);

    if(!$conn){
        die("Connect failed.".mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8");

    return $conn;
}

?>