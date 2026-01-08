<?php 
    include('config/constants.php');
    
    if(isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $sql = "UPDATE qtv SET ho_ten='$ho_ten', username='$username' WHERE id='$id'";
        $res = mysqli_query($conn, $sql);

        if($res && mysqli_affected_rows($conn) > 0) {
            $_SESSION['update'] = "<div class='success'> Cập nhật thành công!</div>";
        } else {
            $_SESSION['update'] = "<div class='error'> Cập nhật thất bại!</div>";
        }
        
        header('location:'.SITEURL.'admin/qly_admin.php');
        exit();
    }
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT * FROM qtv WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $ho_ten = $row['ho_ten'];
            $username = $row['username'];
        } else {
            $_SESSION['update'] = "<div class='error'>Không tìm thấy!</div>";
            header('location:'.SITEURL.'admin/qly_admin.php');
            exit();
        }
    } else {
        header('location:'.SITEURL.'admin/qly_admin.php');
        exit();
    }
    
    include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>CẬP NHẬT THÔNG TIN NHÂN VIÊN</h1>
        <br>
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Họ Tên:</td>
                    <td><input type="text" name="ho_ten" value="<?php echo htmlspecialchars($ho_ten); ?>" required></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Cập nhật" class="btn-secondary">
                        <a href="<?php echo SITEURL; ?>admin/qly_admin.php" class="btn-primary">Hủy</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('part/footer.php'); ?>