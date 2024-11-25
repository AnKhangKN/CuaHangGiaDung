<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['idKhachHang']) && isset($_SESSION['user_id'])){
    echo json_encode([
        'status' => 'logged_in',
        'idKhachHang' => $_SESSION['idKhachHang']
    ]);
}else{
    echo json_encode([
        'status' => 'guest',
        'message' => 'No account'
    ]);
}

?>