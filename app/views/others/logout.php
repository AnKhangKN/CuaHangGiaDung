<?php 
    session_start();
    ob_start();

    if(isset($_SESSION['user_id'])){
        unset($_SESSION['user_id']);

        header('Location: http://localhost/CuaHangDungCu/index.php');
    }
?>