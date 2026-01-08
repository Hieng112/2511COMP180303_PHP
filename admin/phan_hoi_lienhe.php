<?php 
include('config/constants.php');

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM lien_he WHERE id='$id'";
    $res = mysqli_query($conn, $sql);
    
    if($res && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $ten = $row['ten'];
        $email = $row['email'];
        $sdt = $row['sdt'];
        $tieu_de = $row['tieu_de'];
        $noi_dung = $row['noi_dung'];
        $ngay_gui = $row['ngay_gui'];
        $phan_hoi = isset($row['phan_hoi']) ? $row['phan_hoi'] : '';
    } else {
        $_SESSION['reply'] = "<div class='error'>Không tìm thấy liên hệ!</div>";
        header('location:'.SITEURL.'admin/qly_lienhe.php');
        exit();
    }
} else {
    header('location:'.SITEURL.'admin/qly_lienhe.php');
    exit();
}

if(isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $phan_hoi = mysqli_real_escape_string($conn, $_POST['phan_hoi']);
    $gui_email = isset($_POST['gui_email']) ? true : false;
    
    $sql_update = "UPDATE lien_he SET 
                    phan_hoi='$phan_hoi',
                    trang_thai='Đã phản hồi',
                    ngay_phan_hoi=NOW()
                    WHERE id='$id'
    ";
    
    $res_update = mysqli_query($conn, $sql_update);
    
    if($res_update) {
        if($gui_email) {
            
            $to = $email;
            $subject = "Phản hồi: " . $tieu_de;
            $message = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background: #667eea; color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; background: #f9f9f9; }
                        .footer { padding: 20px; text-align: center; color: #666; font-size: 12px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>WowFood Restaurant</h2>
                        </div>
                        <div class='content'>
                            <p>Xin chào <strong>$ten</strong>,</p>
                            <p>Cảm ơn bạn đã liên hệ với chúng tôi. Dưới đây là phản hồi của chúng tôi:</p>
                            <div style='background: white; padding: 15px; border-left: 4px solid #667eea; margin: 20px 0;'>
                                " . nl2br($phan_hoi) . "
                            </div>
                            <p>Nếu bạn có bất kỳ câu hỏi nào khác, vui lòng liên hệ lại với chúng tôi.</p>
                            <p>Trân trọng,<br><strong>WowFood Team</strong></p>
                        </div>
                        <div class='footer'>
                            <p>© 2025 WowFood Restaurant. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: noreply@wowfood.com" . "\r\n";
            
            // Gửi email
            $email_sent = mail($to, $subject, $message, $headers);
            
            if($email_sent) {
                $_SESSION['reply'] = "<div class='success'> Phản hồi thành công và đã gửi email!</div>";
            } else {
                $_SESSION['reply'] = "<div class='success'> Phản hồi thành công! (Email chưa gửi được - cần cấu hình mail server)</div>";
            }
        } else {
            $_SESSION['reply'] = "<div class='success'> Phản hồi thành công!</div>";
        }
    } else {
        $_SESSION['reply'] = "<div class='error'>✗ Phản hồi thất bại!</div>";
    }
    
    header('location:'.SITEURL.'admin/qly_lienhe.php');
    exit();
}

include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Phản hồi liên hệ</h1>
        <br><br>

        <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
            <h2 style="color: #2c3e50; margin-bottom: 20px;"> Thông tin liên hệ</h2>
            
            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 15px; margin-bottom: 15px;">
                <strong>Họ tên:</strong>
                <span><?php echo $ten; ?></span>
                
                <strong>Email:</strong>
                <span><?php echo $email; ?></span>
                
                <strong>Số điện thoại:</strong>
                <span><?php echo $sdt; ?></span>
                
                <strong>Tiêu đề:</strong>
                <span><?php echo $tieu_de ? $tieu_de : '<em style="color:#999;">Không có</em>'; ?></span>
                
                <strong>Ngày gửi:</strong>
                <span><?php echo date('d/m/Y H:i', strtotime($ngay_gui)); ?></span>
            </div>
            
            <div style="margin-top: 20px;">
                <strong>Nội dung:</strong>
                <div style="background: white; padding: 15px; border-left: 4px solid #667eea; margin-top: 10px; line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($noi_dung)); ?>
                </div>
            </div>
        </div>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td colspan="2">
                        <h2 style="color: #2c3e50;"> Phản hồi của bạn</h2>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <textarea name="phan_hoi" 
                                  rows="10" 
                                  placeholder="Nhập nội dung phản hồi..."
                                  style="width: 100%; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; font-family: inherit;"
                                  required><?php echo $phan_hoi; ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <label style="display: flex; align-items: center; gap: 10px; margin: 15px 0;">
                            <input type="checkbox" name="gui_email" value="1" style="width: 18px; height: 18px;">
                            <span style="font-size: 15px;"> Gửi email phản hồi đến khách hàng</span>
                        </label>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value=" Lưu phản hồi" class="btn-secondary">
                        <a href="<?php echo SITEURL; ?>admin/qly_lienhe.php" class="btn-primary">✖ Hủy</a>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>

<?php include('part/footer.php'); ?>