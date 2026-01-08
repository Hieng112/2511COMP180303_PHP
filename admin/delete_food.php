<?php 
    include('config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);  
        $sql_get = "SELECT hinh_anh FROM san_pham WHERE id='$id'";
        $res_get = mysqli_query($conn, $sql_get);
        
        if($res_get && mysqli_num_rows($res_get) > 0) {
            $row = mysqli_fetch_assoc($res_get);
            $image_name = $row['hinh_anh'];
            
            if($image_name != "") {
                $path = "../images/food/".$image_name;
                
                if(file_exists($path)) {
                    unlink($path);
                }
            }
            
            $sql = "DELETE FROM san_pham WHERE id='$id'";
            $res = mysqli_query($conn, $sql);
            
            if($res && mysqli_affected_rows($conn) > 0) {
                $_SESSION['delete'] = "<div class='success'> Xóa sản phẩm thành công!</div>";
            } else {
                $_SESSION['delete'] = "<div class='error'> Xóa thất bại: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $_SESSION['delete'] = "<div class='error'> Không tìm thấy danh mục này!</div>";
        }
    } else {
        $_SESSION['delete'] = "<div class='error'> Thiếu thông tin ID!</div>";
    }
    
    header('location:'.SITEURL.'admin/qly_sanpham.php');
    exit();
?>