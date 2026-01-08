<?php include('part/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1> Thêm Danh mục</h1>
        <br> <br>
        <?php
        if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }    
        if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }    
        ?>
        <br> <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td> Tên danh mục: </td>
                    <td>
                        <input type="text" name="title" placeholder="Tên danh mục">
                    </td>
                </tr>
                <tr>
                    <td> Hình ảnh: </td>
                    <td> 
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td> Nổi bật: </td>
                    <td> 
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td> Trạng thái: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Thêm Danh mục" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>
        <?php 
            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                } else {
                    $featured = "No";
                }
                if(isset($_POST['active'])) 
                {
                    $active = $_POST['active'];
                } else {
                    $active = "No";
                }
                if(isset($_FILES['image']['name']))
                {
                    $image_name=$_FILES['image']['name'];
                    $ext = end(explode('.', $image_name));
                    $image_name = "Danh mục món ăn_".rand(000, 999). '.'. $ext;
                    
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/danhmuc/".$image_name;
                    $upload = move_uploaded_file($source_path, $destination_path);
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "<div class='error'> Tải hình ảnh thất bại. </div>";
                        header('location:' .SITEURL. 'admin/add_danhmuc.php');
                        die();
                    }
                } else {
                    $image_name="";
                }
                $sql = "INSERT INTO danh_muc SET
                ten_danh_muc='$title',
                ten_anh='$image_name',
                noi_bat='$featured',
                trang_thai='$active'
                ";
                $res = mysqli_query($conn, $sql);
                if($res==true)
                {
                    $_SESSION['add'] = "<div class='success'> Thêm danh mục thành công. </div>";
                    header('location:' .SITEURL. 'admin/qly_danhmuc.php');
                } else {
                     $_SESSION['add'] = "<div class='error'> Thêm danh mục thất bại. </div>";
                    header('location:' .SITEURL. 'admin/add_danhmuc.php');
                }
            }
        ?>

    </div>
</div>

<?php include('part/footer.php'); ?>
