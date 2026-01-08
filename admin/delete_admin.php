<?php 
    include('config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $check_sql = "SELECT * FROM qtv WHERE id='$id'";
        $check_res = mysqli_query($conn, $check_sql);
        
        if(mysqli_num_rows($check_res) > 0) {
            $sql = "DELETE FROM qtv WHERE id='$id'";
            $res = mysqli_query($conn, $sql);
            
            if($res && mysqli_affected_rows($conn) > 0) {
                $_SESSION['delete'] = "<div style='color:green; padding:10px; background:#d4edda; border:1px solid #c3e6cb; margin:10px 0;'> Đã xóa nhân viên thành công!</div>";
            } else {
                $_SESSION['delete'] = "<div style='color:red; padding:10px; background:#f8d7da; border:1px solid #f5c6cb; margin:10px 0;'> Không thể xóa!</div>";
            }
        } else {
            $_SESSION['delete'] = "<div style='color:orange; padding:10px; background:#fff3cd; border:1px solid #ffeeba; margin:10px 0;'>⚠ ID này không tồn tại hoặc đã bị xóa!</div>";
        }
    }
    header('location:'.SITEURL.'admin/qly_admin.php?refresh='.time());
    exit();
?>