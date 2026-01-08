<?php include('part/menu.php'); ?>
<?php 
    include('config/constants.php');
    
    if(isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $mat_khau_hien_tai = md5($_POST['mat_khau_hien_tai']);
        $mat_khau_moi = md5($_POST['mat_khau_moi']);
        $xac_nhan_mat_khau = md5($_POST['xac_nhan_mat_khau']);
        
        if($mat_khau_moi != $xac_nhan_mat_khau) {
            $_SESSION['password'] = "<div class='error'> Mật khẩu mới và xác nhận không khớp!</div>";
            header('location:'.SITEURL.'admin/qly_admin.php');
            exit();
        }
        
        $sql = "SELECT * FROM qtv WHERE id='$id' AND password='$mat_khau_hien_tai'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $sql_update = "UPDATE qtv SET password='$mat_khau_moi' WHERE id='$id'";
            $res_update = mysqli_query($conn, $sql_update);
            
            if($res_update) {
                $_SESSION['password'] = "<div class='success'> Đổi mật khẩu thành công!</div>";
            } else {
                $_SESSION['password'] = "<div class='error'> Đổi mật khẩu thất bại!</div>";
            }
        } else {
            $_SESSION['password'] = "<div class='error'> Mật khẩu hiện tại không đúng!</div>";
        }
        
        header('location:'.SITEURL.'admin/qly_admin.php');
        exit();
    }
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
    } else {
        header('location:'.SITEURL.'admin/qly_admin.php');
        exit();
    }
    
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Đổi Mật Khẩu</h1>
        <br>
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Mật khẩu hiện tại:</td>
                    <td>
                        <input type="password" name="mat_khau_hien_tai" placeholder="Mật khẩu hiện tại" required>
                    </td>
                </tr>
                <tr>
                    <td>Mật khẩu mới:</td>
                    <td>
                        <input type="password" name="mat_khau_moi" placeholder="Mật khẩu mới" required>
                    </td>
                </tr>
                <tr>
                    <td>Xác nhận mật khẩu:</td>
                    <td>
                        <input type="password" name="xac_nhan_mat_khau" placeholder="Xác nhận mật khẩu" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Đổi mật khẩu" class="btn-secondary">
                        <a href="<?php echo SITEURL; ?>admin/qly_admin.php" class="btn-primary">Hủy</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('part/footer.php'); ?>