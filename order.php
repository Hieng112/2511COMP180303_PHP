<?php include('part-front/header.php'); ?>

<?php
    if(isset($_GET['food_id'])) {
        $food_id = mysqli_real_escape_string($conn, $_GET['food_id']);
        
        $sql = "SELECT * FROM san_pham WHERE id='$food_id'";
        $res = mysqli_query($conn, $sql);
        
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['ten_san_pham'];
            $gia = $row['gia'];
            $image_name = $row['hinh_anh'];
        } else {
            $_SESSION['error'] = "<div class='error'>Không tìm thấy sản phẩm!</div>";
            header('location:'.SITEURL);
            exit();
        }
    } else {
        header('location:'.SITEURL);
        exit();
    }
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">ĐẶT HÀNG</h2>
        <form action="process-order.php" method="POST" class="order">
            <fieldset>
                <legend class="text-center text-white">Sản phẩm đã chọn</legend>

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
                    <h3><?php echo htmlspecialchars($title); ?></h3>
                    <p class="food-price">
                        <?php echo number_format($gia, 0, ',', '.'); ?> VNĐ
                    </p>
                    <div class="order-label">Số lượng</div>
                    <input type="number" name="qty" class="input-responsive" value="1" min="1" required>
                    <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                    <input type="hidden" name="price" value="<?php echo $gia; ?>">
                </div>
            </fieldset>

            <fieldset>
                <legend class="text-center text-white">Thông tin giao hàng</legend>
                
                <div class=" text-white">Họ và tên</div>
                <input type="text" name="full_name" placeholder="Nguyễn Văn A" class="input-responsive" required>

                <div class=" text-white">Số điện thoại</div>
                <input type="tel" name="contact" placeholder="0912345678" class="input-responsive" required>

                <div class=" text-white">Email</div>
                <input type="email" name="email" placeholder="abc@gmail.com" class="input-responsive" required>

                <div class="text-white">Địa chỉ</div>
                <textarea name="address" rows="10" placeholder="Số nhà, đường, quận/huyện, thành phố" class="input-responsive" required></textarea>

                <div class="text-white">Ghi chú (không bắt buộc)</div>
                <textarea name="note" rows="5" placeholder="Ghi chú về đơn hàng, ví dụ: không cay, nhiều rau..." class="input-responsive"></textarea>

                <input type="submit" name="submit" value="Xác nhận đặt hàng" class="btn btn-primary">
                
            </fieldset>
        </form>
    </div>
</section>

<?php include('part-front/footer.php'); ?>