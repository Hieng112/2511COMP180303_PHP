<?php
include('config/constants.php');

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);  
    $sql = "DELETE FROM lien_he WHERE id='$id'";
    $res = mysqli_query($conn, $sql);
    
    if($res) {
        $_SESSION['delete'] = "<div class='success'> Xóa liên hệ thành công!</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'> Xóa liên hệ thất bại!</div>";
    }
    
    header('location:'.SITEURL.'admin/qly_lienhe.php');
    exit();
} else {
    header('location:'.SITEURL.'admin/qly_lienhe.php');
    exit();
}
?>