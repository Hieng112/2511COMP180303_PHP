<?php 
session_start();
include('admin/config/constants.php');

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header('location:cart.php');
    exit();
}

if(isset($_POST['place_order'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    
    $order_date = date("Y-m-d H:i:s");
    $status = "Đã đặt";
    
    $grand_total = 0;
    $cart_items = array();
    foreach($_SESSION['cart'] as $food_id => $item) {
        $subtotal = $item['price'] * $item['qty'];
        $grand_total += $subtotal;
        $cart_items[] = $item['title'] . " x" . $item['qty'];
    }
    
    $food_list = implode(", ", $cart_items);
    
    $sql = "INSERT INTO don_hang (
                san_pham, 
                gia, 
                so_luong, 
                tong_tien, 
                ngay_dat_hang, 
                trang_thai_don, 
                ten_khach_hang, 
                SDT, 
                email, 
                dia_chi,
                ghi_chu
            ) VALUES (
                '$food_list',
                '$grand_total',
                '1',
                '$grand_total',
                '$order_date',
                '$status',
                '$full_name',
                '$contact',
                '$email',
                '$address',
                '$note'
            )";
    
    $res = mysqli_query($conn, $sql);
    
    if($res) {
        unset($_SESSION['cart']);
        $_SESSION['order'] = "<div class='success text-center'>✓ Đặt hàng thành công! Mã đơn hàng: #" . mysqli_insert_id($conn) . "</div>";
        header('location:'.SITEURL);
        exit();
    } else {
        $_SESSION['order'] = "<div class='error text-center'>✗ Đặt hàng thất bại!</div>";
    }
}

include('part-front/header.php');
?>

<link rel="stylesheet" href="css/checkout.css">

<section class="checkout-section">
    <div class="container">
        <h1 class="text-center">THANH TOÁN</h1>

        <div class="checkout-wrapper">
            <!-- Thông tin đơn hàng -->
            <div class="order-summary">
                <h2>📦 Đơn hàng của bạn</h2>
                
                <div class="summary-items">
                    <?php
                    $grand_total = 0;
                    foreach($_SESSION['cart'] as $food_id => $item) {
                        $subtotal = $item['price'] * $item['qty'];
                        $grand_total += $subtotal;
                        ?>
                        <div class="summary-item">
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $item['image']; ?>" 
                                 alt="<?php echo $item['title']; ?>">
                            <div class="item-info">
                                <h4><?php echo $item['title']; ?></h4>
                                <p>Số lượng: <?php echo $item['qty']; ?> × <?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</p>
                            </div>
                            <div class="item-price">
                                <?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="summary-total">
                    <div class="total-row">
                        <span>Tạm tính:</span>
                        <span><?php echo number_format($grand_total, 0, ',', '.'); ?> VNĐ</span>
                    </div>
                    <div class="total-row">
                        <span>Phí vận chuyển:</span>
                        <span class="text-green">Miễn phí</span>
                    </div>
                    <div class="total-row grand">
                        <span>TỔNG CỘNG:</span>
                        <span><?php echo number_format($grand_total, 0, ',', '.'); ?> VNĐ</span>
                    </div>
                </div>
            </div>

            <div class="shipping-form">
                <h2>📍 Thông tin giao hàng</h2>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="full_name">Họ và tên *</label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               placeholder="Nguyễn Văn A" 
                               required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact">Số điện thoại *</label>
                            <input type="tel" 
                                   id="contact" 
                                   name="contact" 
                                   placeholder="0912345678" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   placeholder="example@gmail.com" 
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ giao hàng *</label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3" 
                                  placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố" 
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="note">Ghi chú (không bắt buộc)</label>
                        <textarea id="note" 
                                  name="note" 
                                  rows="3" 
                                  placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn"></textarea>
                    </div>

                    <div class="form-actions">
                        <a href="cart.php" class="btn-back">◀ Quay lại giỏ hàng</a>
                        <button type="submit" name="place_order" class="btn-order">
                             Đặt hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include('part-front/footer.php'); ?>