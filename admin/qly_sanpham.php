
<?php 
    include('config/constants.php');
    
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    
    include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>QUẢN LÝ SẢN PHẨM</h1>
        
        <?php 
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            
            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
            if(isset($_SESSION['no_food_found'])) {
                echo $_SESSION['no_food_found'];
                unset($_SESSION['no_food_found']);
            }
        ?>
        
        <br>
        <a href="add_food.php" class="btn-primary">Thêm sản phẩm</a>
        <br><br>
        
        <?php 
            $sql = "SELECT * FROM san_pham ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            
            if($res && mysqli_num_rows($res) > 0) {
                $count = mysqli_num_rows($res);
        ?>
                <p style="color:#666;">Tổng số: <strong style="color:#28a745;"><?php echo $count; ?></strong> sản phẩm</p>
                <br/>
                <table class="tbl-full">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Nổi bật</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $stt = 1;
                            while($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $title = $row['ten_san_pham'];
                                $gia = $row['gia'];
                                $image_name = $row['hinh_anh'];
                                $featured = $row['noi_bat'];
                                $active = $row['trang_thai'];
                        ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $stt++; ?></td>
                                    <td><?php echo htmlspecialchars($title); ?></td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($gia, 0, ',', '.'); ?> VNĐ
                                    </td>
                                    <td style="text-align:center;">
                                        <?php 
                                            if($image_name != "" && file_exists("../images/food/".$image_name)) {
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                                                     width="100px" 
                                                     alt="<?php echo $title; ?>"
                                                     style="border-radius:5px;">
                                                <?php
                                            } else {
                                                echo "<span style='color:red;'>Không có hình ảnh.</span>";
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align:center;"><?php echo $featured; ?></td>
                                    <td style="text-align:center;"><?php echo $active; ?></td>
                                    <td style="text-align:center;">
                                        <a href="update_food.php?id=<?php echo $id; ?>" 
                                           class="btn-secondary"
                                           style="margin:2px;">
                                            Chỉnh sửa
                                        </a>
                                        <a href="delete_food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" 
                                           class="btn-danger"
                                           style="margin:2px;"
                                           onclick="return confirm('⚠️ Xác nhận xóa:\n\n<?php echo $title; ?>\n\nBạn có chắc chắn?');">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                        <?php 
                            } 
                        ?>
                    </tbody>
                </table>
        <?php 
            } else {
                echo '<div class="error" style="padding:20px; text-align:center;">📝 Chưa có sản phẩm nào. Hãy thêm sản phẩm mới!</div>';
            }
        ?>
        
        <br>
        <p style="color:#999; font-size:12px;"> Cập nhật: <?php echo date('H:i:s d/m/Y'); ?></p>
    </div>
</div>

<?php include('part/footer.php'); ?>