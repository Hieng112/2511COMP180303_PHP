<?php
    include('config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "DELETE FROM don_hang WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        
        if($res) {
            $_SESSION['delete'] = "<div class='success'> Xóa đơn hàng thành công!</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'> Xóa đơn hàng thất bại!</div>";
        }
        
        header('location:'.SITEURL.'admin/qly_donhang.php');
        exit();
        
    } else {
        header('location:'.SITEURL.'admin/qly_donhang.php');
        exit();
    }
?>