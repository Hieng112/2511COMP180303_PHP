<?php include('part-front/header.php'); ?>
    <section class="categories">
        <div class="container">
            <h2>DANH MỤC</h2>
            <div class="categories-grid">
                <?php
                    $sql = "SELECT * FROM danh_muc WHERE trang_thai='Yes'";
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
                                    <div class="category-image">
                                        <?php
                                            if($image_name != "") {
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/danhmuc/<?php echo $image_name; ?>" 
                                                     alt="<?php echo htmlspecialchars($title); ?>">
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/no-image.jpg" 
                                                     alt="No Image">
                                                <?php
                                            }
                                        ?>
                                        
                                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                    </div>
                                </div>
                            </a>

                            <?php
                        }
                    } else {
                        echo "<div style='grid-column: 1/-1; text-align: center; padding: 40px; color: #e74c3c;'>Không tìm thấy danh mục nào.</div>";
                    }
                ?>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>

<?php include('part-front/footer.php'); ?>