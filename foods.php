<?php include('part-front/header.php'); ?>
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Tìm kiếm món ăn..." required>
                <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-primary">
            </form>
        </div>
    </section>
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">TẤT CẢ SẢN PHẨM</h2>
            <div class="food-menu-grid">
            <?php
                $sql = "SELECT * FROM san_pham WHERE trang_thai='Yes' ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['ten_san_pham'];
                        $gia = $row['gia'];
                        $mota = $row['mo_ta'];
                        $image_name = $row['hinh_anh'];
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
    </section>

<?php include('part-front/footer.php'); ?>