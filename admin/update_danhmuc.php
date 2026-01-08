<?php 
    include('config/constants.php');
    
    if(isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $current_image = $_POST['current_image'];
        $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
        $active = isset($_POST['active']) ? $_POST['active'] : 'No';
        
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $image_name = $_FILES['image']['name'];
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "Danh_muc_".rand(000, 999).".".$ext;
            
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/danhmuc/".$image_name;
            
            $upload = move_uploaded_file($source_path, $destination_path);
            
            if($upload == false) {
                $_SESSION['upload'] = "<div class='error'>✗ Không thể upload hình!</div>";
                header('location:'.SITEURL.'admin/qly_danhmuc.php');
                exit();
            }
            
            if($current_image != "") {
                $remove_path = "../images/danhmuc/".$current_image;
                if(file_exists($remove_path)) {
                    unlink($remove_path);
                }
            }
        } else {
            $image_name = $current_image;
        }
        
        $sql = "UPDATE danh_muc SET 
                ten_danh_muc='$title',
                ten_anh='$image_name',
                noi_bat='$featured',
                trang_thai='$active'
                WHERE id='$id'
        ";
        
        $res = mysqli_query($conn, $sql);
        
        if($res) {
            if($active == 'No') {
                $sql_disable_foods = "UPDATE san_pham SET trang_thai='No' WHERE danh_muc_id='$id'";
                $res_disable = mysqli_query($conn, $sql_disable_foods);
                $affected_foods = mysqli_affected_rows($conn);
                
                if($affected_foods > 0) {
                    $_SESSION['update'] = "<div class='success'> Đã cập nhật danh mục và tắt $affected_foods món ăn trong danh mục này!</div>";
                } else {
                    $_SESSION['update'] = "<div class='success'> Cập nhật danh mục thành công!</div>";
                }
            } else {
                if(mysqli_affected_rows($conn) > 0) {
                    $_SESSION['update'] = "<div class='success'> Cập nhật thành công!</div>";
                } else {
                    $_SESSION['update'] = "<div class='success'> Không có gì thay đổi!</div>";
                }
            }
        } else {
            $_SESSION['update'] = "<div class='error'>✗ Lỗi: " . mysqli_error($conn) . "</div>";
        }
        
        header('location:'.SITEURL.'admin/qly_danhmuc.php');
        exit();
    }
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        $sql = "SELECT * FROM danh_muc WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['ten_danh_muc'];
            $image_name = $row['ten_anh'];
            $featured = $row['noi_bat'];
            $active = $row['trang_thai'];
        } else {
            $_SESSION['no_category_found'] = "<div class='error'>Không tìm thấy danh mục!</div>";
            header('location:'.SITEURL.'admin/qly_danhmuc.php');
            exit();
        }
    } else {
        header('location:'.SITEURL.'admin/qly_danhmuc.php');
        exit();
    }
 include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Chỉnh sửa danh mục</h1>
      
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Tên danh mục:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Hình ảnh hiện tại:</td>
                    <td>
                        <?php 
                            if($image_name != "") {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/danhmuc/<?php echo $image_name; ?>" width="150px">
                                <?php
                            } else {
                                echo "Chưa có hình ảnh";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Chọn hình mới:</td>
                    <td>
                        <input type="file" name="image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Nổi bật:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if($featured == 'No') echo 'checked'; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($active == 'No') echo 'checked'; ?>> No
                        <br>
                        <small style="color: #fd5441ff;"> Lưu ý: Chuyển sang "No" sẽ tự động ẩn TẤT CẢ món ăn trong danh mục này!</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $image_name; ?>">
                        <input type="submit" name="submit" value="Cập nhật" class="btn-secondary">
                        <a href="<?php echo SITEURL; ?>admin/qly_danhmuc.php" class="btn-primary">Hủy</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('part/footer.php'); ?>