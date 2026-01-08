<?php 
    if(!isset($_SESSION['user']))
        {
            $_SESSION['no-login-message'] = "<div class='error text-center'> Vui lòng dăng nhập. </div>";
            header('location:' .SITEURL. 'admin/login.php');
        }
?>

