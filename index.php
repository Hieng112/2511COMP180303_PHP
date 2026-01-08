<?php include('part-front/header.php'); ?>
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Tìm kiếm món ăn..." required>
                <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-primary">
            </form>
        </div>
    </section>
<?php 
        if(isset($_SESSION['order'])) {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Danh mục</h2>

            <?php
                $sql = "SELECT * FROM danh_muc WHERE trang_thai='Yes' AND noi_bat='Yes' LIMIT 3";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        
                        $id = $row['id'];
                        $title = $row['ten_danh_muc'];
                        $image_name = $row['ten_anh'];
                        ?>
                        
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    
                                    if($image_name != "") {
                                       
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/danhmuc/<?php echo $image_name; ?>" 
                                             alt="<?php echo $title; ?>" 
                                             class="img-responsive img-curve">
                                        <?php
                                    } else {
                                      
                                        echo "<div class='error'>Hình ảnh không khả dụng</div>";
                                    }
                                ?>

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                } else {
                    ?>
                    <div class="error">Chưa có danh mục nào được thêm.</div>
                    <?php
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">THỰC ĐƠN MÓN ĂN</h2>
        <div class="food-menu-grid">
        <?php
            $sql2 = "SELECT * FROM san_pham WHERE trang_thai='Yes' AND noi_bat='Yes' LIMIT 9";
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
                                         alt="<?php echo htmlspecialchars($title); ?>">
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/no-image.jpg" 
                                         alt="No Image">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo htmlspecialchars($title); ?></h4>
                            <p class="food-price"><?php echo number_format($gia, 0, ',', '.'); ?> VNĐ</p>
                            <p class="food-detail"><?php echo htmlspecialchars($mota); ?></p>          
                            <div class="btn-group">
                                <form action="<?php echo SITEURL; ?>cart.php" method="POST" style="display: inline; flex: 1; margin: 0;">
                                    <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                                    <input type="hidden" name="price" value="<?php echo $gia; ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <input type="hidden" name="image" value="<?php echo $image_name; ?>">
                                    <button type="submit" name="add_to_cart" class="btn-cart">
                                        🛒 Giỏ hàng
                                    </button>
                                </form>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" 
                                   class="btn-primary">
                                    Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div style='grid-column: 1/-1; text-align: center; padding: 40px;'>Không có món ăn nào.</div>";
            }
        ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <p class="text-center">
        <a href="<?php echo SITEURL; ?>foods.php">Xem tất cả món ăn</a>
    </p>
</section>

<?php include('part-front/footer.php'); ?>