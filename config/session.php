<?php
// Chỉ cần gọi session_start() một lần trong file này
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
