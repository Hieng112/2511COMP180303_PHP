<?php include('part-front/header.php'); ?>

<?php
    if(isset($_GET['category_id'])) {
        $category_id = mysqli_real_escape_string($conn, $_GET['category_id']);
        
        $sql = "SELECT ten_danh_muc FROM danh_muc WHERE id='$category_id'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $category_title = $row['ten_danh_muc'];
        } else {
            header('location:'.SITEURL);
            exit();
        }
    } else {
        header('location:'.SITEURL);
        exit();
    }
?>
    <section class="food-search text-center">
        <div class="container">
            <h2>Món ăn trong danh mục <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
        </div>
    </section>
    <section class="food-menu">
        <div class="container">
            
            <h2 class="text-center">Thực đơn</h2>
            <div class="food-menu-grid">
            <?php
                $sql2 = "SELECT * FROM san_pham WHERE danh_muc_id='$category_id' AND trang_thai='Yes'";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                if($count2 > 0) {
           
                    while($row2 = mysqli_fetch_assoc($res2)) {
                        $id = $row2['id'];
                        $title = $row2['ten_san_pham'];
                        $gia = $row2['gia']; 
                        $mota = $row2['mo_ta'];
                        $image_name = $row2['hinh_anh'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name != "" && file_exists("images/food/".$image_name)) {
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                                             alt="<?php echo htmlspecialchars($title); ?>" 
                                             class="img-responsive img-curve">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/no-image.jpg" 
                                             alt="No Image" 
                                             class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo htmlspecialchars($title); ?></h4>
                                <p class="food-price"><?php echo number_format($gia, 0, ',', '.'); ?> VNĐ</p>
                                <p class="food-detail">
                                    <?php echo htmlspecialchars($mota); ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" 
                                   class="btn btn-primary">Đặt ngay</a>
                            </div>
                        </div>
                     
                        <?php
                    }
                } else {
                  
                    echo "<div class='error'>Không có sản phẩm nào trong danh mục này.</div>";
                }
            ?>
                </div>
            <div class="clearfix"></div>
        </div>
    </section>

<?php include('part-front/footer.php'); ?>