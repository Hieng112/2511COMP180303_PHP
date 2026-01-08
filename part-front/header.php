<?php include('admin/config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE BẾP CỦA SÓC</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
  
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php" title="Logo">
                    <img src="images/logo.jpg" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

           <div class="menu text-right">
    <ul>
        <li><a href="<?php echo SITEURL; ?>index.php">Trang chủ</a></li>
        <li><a href="<?php echo SITEURL; ?>categories.php">Danh mục</a></li>
        <li><a href="<?php echo SITEURL; ?>foods.php">Sản phẩm</a></li>
        <li>
            <a href="<?php echo SITEURL; ?>cart.php" class="cart-link">
                Giỏ hàng 
                <?php 
                if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    echo '<span class="cart-badge">' . count($_SESSION['cart']) . '</span>';
                }
                ?>
            </a>
        </li>
        <li><a href="<?php echo SITEURL; ?>contact.php">Liên hệ</a></li>
    </ul>
</div>

            <div class="clearfix"></div>
        </div>
    </section>