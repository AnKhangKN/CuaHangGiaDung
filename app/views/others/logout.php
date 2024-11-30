<?php 
    session_start();
    ob_start();

    if(isset($_SESSION['user_id']) && isset($_SESSION['quyen'])){
        unset($_SESSION['user_id']);
        unset($_SESSION['quyen']);
        

        header('Location: http://localhost/CuaHangDungCu/public/index.php');
    }
?>