<?php 
    include('config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT * FROM don_hang WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $san_pham = $row['san_pham'];
            $gia = $row['gia'];
            $so_luong = $row['so_luong'];
            $tong_tien = $row['tong_tien'];
            $trang_thai = $row['trang_thai_don'];
            $ten_kh = $row['ten_khach_hang'];
            $sdt = $row['SDT'];
            $email = $row['email'];
            $dia_chi = $row['dia_chi'];
        } else {
            $_SESSION['order'] = "<div class='error'>Không tìm thấy đơn hàng!</div>";
            header('location:'.SITEURL.'admin/qly_donhang.php');
            exit();
        }
    } else {
        header('location:'.SITEURL.'admin/qly_donhang.php');
        exit();
    }
    
    if(isset($_POST['submit'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $trang_thai = mysqli_real_escape_string($conn, $_POST['trang_thai']);
        
        $sql_update = "UPDATE don_hang SET 
                        trang_thai_don='$trang_thai'
                        WHERE id='$id'
        ";
        
        $res_update = mysqli_query($conn, $sql_update);
        
        if($res_update) {
            $_SESSION['update'] = "<div class='success'> Cập nhật đơn hàng thành công!</div>";
        } else {
            $_SESSION['update'] = "<div class='error'> Cập nhật thất bại!</div>";
        }
        
        header('location:'.SITEURL.'admin/qly_donhang.php');
        exit();
    }
    
    include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Cập nhật đơn hàng</h1>
        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Sản phẩm:</td>
                    <td><b><?php echo $san_pham; ?></b></td>
                </tr>

                <tr>
                    <td>Giá:</td>
                    <td><b><?php echo number_format($gia, 0, ',', '.'); ?> VNĐ</b></td>
                </tr>

                <tr>
                    <td>Số lượng:</td>
                    <td><b><?php echo $so_luong; ?></b></td>
                </tr>

                <tr>
                    <td>Tổng tiền:</td>
                    <td><b><?php echo number_format($tong_tien, 0, ',', '.'); ?> VNĐ</b></td>
                </tr>

                <tr>
                    <td>Khách hàng:</td>
                    <td><b><?php echo $ten_kh; ?></b></td>
                </tr>

                <tr>
                    <td>Số điện thoại:</td>
                    <td><b><?php echo $sdt; ?></b></td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td><b><?php echo $email; ?></b></td>
                </tr>

                <tr>
                    <td>Địa chỉ:</td>
                    <td><b><?php echo $dia_chi; ?></b></td>
                </tr>

                <tr>
                    <td>Trạng thái:</td>
                    <td>
                        <select name="trang_thai" style="padding: 8px; width: 200px;">
                            <option value="Đã đặt" <?php if($trang_thai == "Đã đặt") echo "selected"; ?>>Đã đặt</option>
                            <option value="Đang giao" <?php if($trang_thai == "Đang giao") echo "selected"; ?>>Đang giao</option>
                            <option value="Đã giao" <?php if($trang_thai == "Đã giao") echo "selected"; ?>>Đã giao</option>
                            <option value="Đã hủy" <?php if($trang_thai == "Đã hủy") echo "selected"; ?>>Đã hủy</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value=" Cập nhật" class="btn-secondary">
                        <a href="<?php echo SITEURL; ?>admin/qly_donhang.php" class="btn-primary">✖ Hủy</a>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>

<?php include('part/footer.php'); ?>