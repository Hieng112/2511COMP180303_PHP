<?php 
session_start();
include('admin/config/constants.php');

if(isset($_POST['add_to_cart'])) {
    $food_id = $_POST['food_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $image = $_POST['image'];
    
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if(isset($_SESSION['cart'][$food_id])) {
        $_SESSION['cart'][$food_id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$food_id] = array(
            'title' => $title,
            'price' => $price,
            'qty' => $qty,
            'image' => $image
        );
    }
    
    $_SESSION['cart_message'] = "<div class='success'> Đã thêm vào giỏ hàng!</div>";
    header('location:' . $_SERVER['HTTP_REFERER']);
    exit();
}

if(isset($_POST['update_cart'])) {
    foreach($_POST['qty'] as $food_id => $qty) {
        if($qty > 0) {
            $_SESSION['cart'][$food_id]['qty'] = $qty;
        } else {
            unset($_SESSION['cart'][$food_id]);
        }
    }
    $_SESSION['cart_message'] = "<div class='success'> Cập nhật giỏ hàng thành công!</div>";
    header('location:cart.php');
    exit();
}

if(isset($_GET['remove'])) {
    $food_id = $_GET['remove'];
    unset($_SESSION['cart'][$food_id]);
    $_SESSION['cart_message'] = "<div class='success'> Đã xóa sản phẩm!</div>";
    header('location:cart.php');
    exit();
}

include('part-front/header.php');
?>

<link rel="stylesheet" href="css/cart.css">

<section class="cart-section">
    <div class="container">
        <h1 class="text-center">GIỎ HÀNG CỦA BẠN</h1>
        
        <?php 
            if(isset($_SESSION['cart_message'])) {
                echo $_SESSION['cart_message'];
                unset($_SESSION['cart_message']);
            }
        ?>

        <?php
        if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            ?>
            <form action="" method="POST" class="cart-form">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên món</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grand_total = 0;
                        foreach($_SESSION['cart'] as $food_id => $item) {
                            $subtotal = $item['price'] * $item['qty'];
                            $grand_total += $subtotal;
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $item['image']; ?>" 
                                         alt="<?php echo $item['title']; ?>" 
                                         class="cart-img">
                                </td>
                                <td class="cart-title"><?php echo $item['title']; ?></td>
                                <td class="cart-price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <input type="number" 
                                           name="qty[<?php echo $food_id; ?>]" 
                                           value="<?php echo $item['qty']; ?>" 
                                           min="1" 
                                           class="qty-input">
                                </td>
                                <td class="cart-price"><?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $food_id; ?>" 
                                       class="btn-remove"
                                       onclick="return confirm('Xóa sản phẩm này?')">❌</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>TỔNG CỘNG:</strong></td>
                            <td colspan="2" class="grand-total">
                                <strong><?php echo number_format($grand_total, 0, ',', '.'); ?> VNĐ</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="btn-update">
                         Cập nhật giỏ hàng
                    </button>
                    <a href="<?php echo SITEURL; ?>foods.php" class="btn-continue">
                        ◀ Tiếp tục mua hàng
                    </a>
                    <a href="checkout.php" class="btn-checkout">
                        Thanh toán ▶
                    </a>
                </div>
            </form>
            <?php
        } else {
            ?>
            <div class="empty-cart">
                <img src="images/empty-cart.png" alt="Empty Cart" style="width: 200px; opacity: 0.5;">
                <h2>Giỏ hàng trống</h2>
                <p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="<?php echo SITEURL; ?>foods.php" class="btn-shop">
                    🛒 Mua sắm ngay
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<?php include('part-front/footer.php'); ?>