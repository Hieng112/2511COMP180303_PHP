<?php include('part/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1> Thêm sản phẩm</h1>
        
        <br> <br>
        <?php
          if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
            <tr>
                <td> Tên sản phẩm: </td>
                <td>
                    <input type="text" name="title" placeholder="Tên sản phẩm">
                </td>
            </tr>
            <tr>
                <td> Mô tả: </td>
                <td>
                    <textarea name="mota" cols="30" rows="5" placeholder="Nhập mô tả cho sản phẩm"></textarea>
                </td>
            </tr>
            <tr>
                <td>Giá: </td>
                <td>
                    <input type="number" name="gia">
                </td>
            </tr>
            <tr>
                <td> Hình ảnh: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Danh mục: </td>
                <td>
                    <select name="category">
                        <?php
                            $sql="SELECT * FROM danh_muc WHERE trang_thai='Yes'";
                            $res=mysqli_query($conn, $sql);
                            $count=mysqli_num_rows($res);
                            if($count > 0)
                            {
                                 while($rows=mysqli_fetch_assoc($res)){
                                    $id = $rows['id'];
                                    $title = $rows['ten_danh_muc'];
                                   ?>
                                    <option value="<?php echo $id; ?>"> <?php echo $title; ?> </option>
                                   <?php
                                 }
                            } else {
                                ?>
                                <option value="0"> Không tìm thấy danh mục. </option>
                                <?php
                            }
                        ?>
                        
                    </select>
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
                        <input type="submit" name="submit" value="Thêm sản phẩm" class="btn-secondary"> 
                    </td>
                </tr>
        </table>
        </form>
        <?php 
            if(isset($_POST['submit']))
            {
               $title = $_POST['title'];
               $mota = $_POST['mota'];
               $gia = $_POST['gia'];
               $danhmuc = $_POST['category'];
               if(isset($_POST['featured']))
               {
                $featured=$_POST['featured'];
               } else {
                    $featured = "No";
               }
               if(isset($_POST['active']))
                {
    
                    $active = $_POST['active']; 
                }
                else
                {
                    $active = "No"; 
                }
               if(isset($_FILES['image']['name']))
                {
                    $image_name=$_FILES['image']['name'];
                    $ext_array = explode('.', $image_name);
                    $ext = end($ext_array);
                    $image_name = "San_pham_".rand(000, 999). '.'. $ext;
                    
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/food/".$image_name;
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
                 $sql2 = "INSERT INTO san_pham SET
                ten_san_pham='$title',
                mo_ta='$mota',
                gia='$gia',
                hinh_anh='$image_name',
                danh_muc_id='$danhmuc',
                noi_bat='$featured',
                trang_thai='$active'
                ";
                $res2 = mysqli_query($conn, $sql2);
                if($res2 ==true)
                {
                    $_SESSION['add'] = "<div class='success'> Thêm sản phẩm thành công. </div>";
                    header('location:' .SITEURL. 'admin/qly_sanpham.php');
                } else {
                    $_SESSION['add'] = "<div class='error'> Thêm sản phẩm thất bại. </div>";
                    header('location:' .SITEURL. 'admin/qly_sanpham.php');

                }
            }
        ?>
    </div>
</div>
<?php include('part/footer.php'); ?>