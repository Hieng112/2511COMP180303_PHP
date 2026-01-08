<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!defined('SITEURL')) {
        define('SITEURL', 'http://localhost/food/');
    }
    
    if(!defined('LOCALHOST')) {
        define('LOCALHOST', 'localhost');
    }
    
    if(!defined('DB_USERNAME')) {
        define('DB_USERNAME', 'root');
    }
    
    if(!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', '');
    }
    
    if(!defined('DB_NAME')) {
        define('DB_NAME', 'food');
    }

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    mysqli_set_charset($conn, "utf8mb4");
    
    if(!$conn) {
        die("Kết nối database thất bại: " . mysqli_connect_error());
    }
?>