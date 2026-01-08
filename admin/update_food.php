<?php 
    include('config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT * FROM san_pham WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['ten_san_pham'];
            $mota = $row['mo_ta'];
            $gia = $row['gia'];
            $image_name = $row['hinh_anh'];
            $category_id = $row['danh_muc_id'];
            $featured = $row['noi_bat'];
            $active = $row['trang_thai'];
        } else {
            $_SESSION['no_food_found'] = "<div class='error'>✗ Không tìm thấy sản phẩm này!</div>";
            header('location:'.SITEURL.'admin/qly_sanpham.php');
            exit();
        }
    } else {
        $_SESSION['no_food_found'] = "<div class='error'>✗ ID không hợp lệ!</div>";
        header('location:'.SITEURL.'admin/qly_sanpham.php');
        exit();
    }
    
    if(isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $mota = mysqli_real_escape_string($conn, $_POST['mota']);
        $gia = mysqli_real_escape_string($conn, $_POST['gia']);
        $current_image = $_POST['current_image'];
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
        $active = isset($_POST['active']) ? $_POST['active'] : 'No';
        
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
 
            $image_name = $_FILES['image']['name'];
            
          
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            if(!in_array(strtolower($ext), $allowed_extensions)) {
                $_SESSION['upload'] = "<div class='error'> Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif)!</div>";
                header('location:'.SITEURL.'admin/update_food.php?id='.$id);
                exit();
            }
            
            $image_name = "San_pham_".rand(1000, 9999).".".$ext;
            
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/food/".$image_name;
            
            $upload = move_uploaded_file($source_path, $destination_path);
            
            if($upload == false) {
                $_SESSION['upload'] = "<div class='error'> Không thể upload hình!</div>";
                header('location:'.SITEURL.'admin/update_food.php?id='.$id);
                exit();
            }
            
            if($current_image != "") {
                $remove_path = "../images/food/".$current_image;
                if(file_exists($remove_path)) {
                    unlink($remove_path);
                }
            }
        } else {
            $image_name = $current_image;
        }
        
        $sql_update = "UPDATE san_pham SET 
                        ten_san_pham='$title',
                        mo_ta='$mota',
                        gia='$gia',
                        hinh_anh='$image_name',
                        danh_muc_id='$category',
                        noi_bat='$featured',
                        trang_thai='$active'
                        WHERE id='$id'
        ";
        
        $res_update = mysqli_query($conn, $sql_update);
        
        if($res_update) {
            $affected = mysqli_affected_rows($conn);
            if($affected > 0) {
                $_SESSION['update'] = "<div class='success'> Cập nhật sản phẩm thành công!</div>";
            } else {
                $_SESSION['update'] = "<div class='success'> Không có thay đổi nào!</div>";
            }
        } else {
            $_SESSION['update'] = "<div class='error'> Cập nhật thất bại: " . mysqli_error($conn) . "</div>";
        }
        
        header('location:'.SITEURL.'admin/qly_sanpham.php');
        exit();
    }
    
    include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Chỉnh sửa sản phẩm</h1>
        <br><br>
        
        <?php 
            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Tên sản phẩm:</td>
                    <td>
                        <input type="text" 
                               name="title" 
                               value="<?php echo htmlspecialchars($title); ?>" 
                               placeholder="Nhập tên sản phẩm" 
                               required
                               style="width:100%; padding:8px;">
                    </td>
                </tr>
                
                <tr>
                    <td>Mô tả:</td>
                    <td>
                        <textarea name="mota" 
                                  cols="30" 
                                  rows="5" 
                                  placeholder="Nhập mô tả sản phẩm"
                                  style="width:100%; padding:8px;"><?php echo htmlspecialchars($mota); ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>Giá:</td>
                    <td>
                        <input type="number" 
                               name="gia" 
                               value="<?php echo $gia; ?>" 
                               step="0.01" 
                               required
                               style="width:100%; padding:8px;">
                        <small style="color:#666;">VNĐ</small>
                    </td>
                </tr>
                
                <tr>
                    <td>Hình ảnh hiện tại:</td>
                    <td>
                        <?php 
                            if($image_name != "") {
                                $image_path = "../images/food/".$image_name;
                                if(file_exists($image_path)) {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                                         width="200px"
                                         style="border:2px solid #ddd; border-radius:5px; padding:5px;">
                                    <br>
                                    <small style="color:#666;">File: <?php echo $image_name; ?></small>
                                    <?php
                                } else {
                                    echo "<span style='color:red;'> Không tìm thấy file hình ảnh!</span><br>";
                                    echo "<small style='color:#666;'>Đường dẫn: " . $image_path . "</small>";
                                }
                            } else {
                                echo "<span style='color:#999;'>Chưa có hình ảnh</span>";
                            }
                        ?>
                    </td>            
                </tr>
                
                <tr>
                    <td>Chọn hình mới:</td>
                    <td>
                        <input type="file" name="image" accept="image/*">
                        <br>
                        <small style="color:#666;">Để trống nếu không muốn thay đổi hình ảnh</small>
                    </td>
                </tr>
                
                <tr>
                    <td>Danh mục:</td>
                    <td>
                        <select name="category" style="width:100%; padding:8px;">
                            <?php
                                $sql_cat = "SELECT * FROM danh_muc WHERE trang_thai='Yes'";
                                $res_cat = mysqli_query($conn, $sql_cat);
                                $count_cat = mysqli_num_rows($res_cat);
                                
                                if($count_cat > 0) {
                                    while($row_cat = mysqli_fetch_assoc($res_cat)) {
                                        $cat_id = $row_cat['id'];
                                        $cat_title = $row_cat['ten_danh_muc'];
                                        
                                        $selected = ($cat_id == $category_id) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $cat_id; ?>" <?php echo $selected; ?>>
                                            <?php echo $cat_title; ?>
                                        </option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="0">Không tìm thấy danh mục</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Nổi bật:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured == 'Yes') echo 'checked'; ?>> Yes &nbsp;&nbsp;
                        <input type="radio" name="featured" value="No" <?php if($featured == 'No') echo 'checked'; ?>> No
                    </td>
                </tr>
                
                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active == 'Yes') echo 'checked'; ?>> Yes &nbsp;&nbsp;
                        <input type="radio" name="active" value="No" <?php if($active == 'No') echo 'checked'; ?>> No
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $image_name; ?>">
                        
                        <input type="submit" name="submit" value=" Cập nhật" class="btn-secondary">
                        <a href="<?php echo SITEURL; ?>admin/qly_sanpham.php" class="btn-primary">✖ Hủy</a>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>

<?php include('part/footer.php'); ?>