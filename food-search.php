<?php include('part-front/header.php'); ?>
    <section class="food-search text-center">
        <div class="container">
            <?php
                $search = $_POST['search'];
            ?>       
            <h2>Tìm kiếm sản phẩm <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>
        </div>
    </section>
  
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center"> Thực đơn</h2>
            <div class="food-menu-grid">
            <?php
                
                $sql = "SELECT * FROM san_pham WHERE ten_san_pham LIKE'%$search%' OR mo_ta LIKE '%$search%'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
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
                                <p class="food-price">
                                    <?php echo number_format($gia, 0, ',', '.'); ?> VNĐ
                                </p>
                                <p class="food-detail">
                                    <?php echo htmlspecialchars($mota); ?>
                                </p>
                                <br>
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">
                                    Đặt ngay
                                </a>
                            </div>
                        </div>
            
                        <?php
                    }
                } else {
                    echo "<div class='error'> Không tìm thấy sản phẩm. </div>";
                }
                
            ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

<?php include('part-front/footer.php'); ?>