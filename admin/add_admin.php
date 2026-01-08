<?php include('part/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1> Thêm Nhân Viên </h1>
        <br />
        <?php
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
         ?>

        <form action="" method="POST">
        <br />
            <table class="tbl-30">
                <tr>
                    <td> Họ Tên: </td>
                    <td>
                        <input type="text" name="ho_ten" placeholder="Nhập tên Nhân viên">
                    </td>
                </tr>
                <tr>
                    <td> Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Nhập Username">
                    </td>
                </tr>
                <tr>
                    <td> Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Nhập Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" name="submit" value="Thêm Nhân viên" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>
<?php include('part/footer.php'); ?>
<?php 
include('config/constants.php');
    if(isset($_POST['submit']))
    {
       $ho_ten = $_POST['ho_ten'];
       $username = $_POST['username'];
       $password = md5($_POST['password']);

       $sql = "INSERT INTO qtv SET
            ho_ten='$ho_ten',
            username='$username',
            password='$password'
        ";
          $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        if($res) {
          $_SESSION['add'] = "<div style='color:green; padding:10px; background:#d4edda; border:1px solid #c3e6cb; margin:10px 0;'> Đã thêm nhân viên thành công!</div>";
           header("location:".SITEURL.'admin/qly_admin.php');
        } else {
            $_SESSION['add'] = "<div style='color:red; padding:10px; background:#f8d7da; border:1px solid #f5c6cb; margin:10px 0;'> Thêm thất bại!</div>";
           header("location:" .SITEURL.'admin/add_admin.php');
           exit();
        }
}
?>