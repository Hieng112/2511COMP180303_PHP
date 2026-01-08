<?php
    include('admin/config/constants.php');
    
    if(!isset($conn)) {
        die("Lỗi: Không thể kết nối database!");
    }
    
    if(isset($_POST['submit'])) {
        $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $qty = mysqli_real_escape_string($conn, $_POST['qty']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $total = $price * $qty;
        $order_date = date("Y-m-d H:i:s");
        $status = "Đã đặt"; 
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
                    dia_chi
                ) VALUES (
                    '$title',
                    '$price',
                    '$qty',
                    '$total',
                    '$order_date',
                    '$status',
                    '$full_name',
                    '$contact',
                    '$email',
                    '$address'
                )";
        
        $res = mysqli_query($conn, $sql);
        
        if($res) {
            $_SESSION['order'] = "<div class='success text-center'> Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.</div>";
        } else {
            $_SESSION['order'] = "<div class='error text-center'> Đặt hàng thất bại. Lỗi: " . mysqli_error($conn) . "</div>";
        }
        
        header('location:'.SITEURL);
        exit();
        
    } else {
        header('location:'.SITEURL);
        exit();
    }
?>