<?php include('config/constants.php'); ?>

<html>
    <head>
        <title> ĐĂNG NHẬP - BẾP CỦA SÓC </title>
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="stylesheet" href="../css/login.css"> 
    </head>
    <body class="login-page">
        <div class="dn login-container">

            <h1 class="text-center"> ĐĂNG NHẬP </h1> <br>
            <?php 
                if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
                if(isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }

            ?>
            <br> <br>
            <form action="" method="POST" class="text-center form-group">
                <div class="form-group">
                <label for="username">Username:</label>
                <div class="input-wrapper username">
                    <input type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Nhập username" 
                           required>
                </div>
            </div>
               <div class="form-group">
                <label for="password">Password:</label>
                <div class="input-wrapper password">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Nhập password" 
                           required>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-login">
                Đăng nhập
            </button>
        </form>
        
        <div class="login-footer">
            Created By - <a href="<?php echo SITEURL; ?>">BẾP CỦA SÓC</a>
        </div>
    </div>

    </body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM qtv WHERE username = '$username' AND password = '$password'";
        $res = mysqli_query($conn, $sql);
        
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            $_SESSION['login'] = "<div class='success'> Đăng nhập thành công. </div>";
            $_SESSION['user'] = $username;
            header('location:' .SITEURL. 'admin/');
        } else 
        {
            $_SESSION['login'] = "<div class='error text-center'> Username hoặc Mật khẩu không đúng. </div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }


?>

