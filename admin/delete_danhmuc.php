<?php 
    include('config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql_count = "SELECT COUNT(*) as total FROM san_pham WHERE danh_muc_id='$id'";
        $res_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($res_count);
        $total_foods = $row_count['total'];
        
        if($total_foods > 0) {
            $sql_disable_foods = "UPDATE san_pham SET trang_thai='No' WHERE danh_muc_id='$id'";
            mysqli_query($conn, $sql_disable_foods);
        }
        
        $sql_get = "SELECT ten_anh FROM danh_muc WHERE id='$id'";
        $res_get = mysqli_query($conn, $sql_get);
        
        if($res_get && mysqli_num_rows($res_get) > 0) {
            $row = mysqli_fetch_assoc($res_get);
            $image_name = $row['ten_anh'];
            
            if($image_name != "") {
                $path = "../images/danhmuc/".$image_name;
                
                if(file_exists($path)) {
                    unlink($path);
                }
            }
            
            $sql = "DELETE FROM danh_muc WHERE id='$id'";
            $res = mysqli_query($conn, $sql);
            
            if($res && mysqli_affected_rows($conn) > 0) {
                if($total_foods > 0) {
                    $_SESSION['delete'] = "<div class='success'> Đã xóa danh mục và tắt $total_foods món ăn!</div>";
                } else {
                    $_SESSION['delete'] = "<div class='success'> Xóa danh mục thành công!</div>";
                }
            } else {
                $_SESSION['delete'] = "<div class='error'> Xóa thất bại: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $_SESSION['delete'] = "<div class='error'> Không tìm thấy danh mục này!</div>";
        }
    } else {
        $_SESSION['delete'] = "<div class='error'> Thiếu thông tin ID!</div>";
    }
    
    header('location:'.SITEURL.'admin/qly_danhmuc.php');
    exit();
?>