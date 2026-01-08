<?php include('part-front/header.php'); ?>
<link rel="stylesheet" href="css/contact.css">

    <section class="contact-header text-center">
        <div class="container">
            <h1>Liên hệ với chúng tôi</h1>
            <p>Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn</p>
        </div>
    </section>

    <section class="contact-content">
        <div class="container">
            <div class="contact-wrapper">
                
                <div class="contact-info">
                    <h2>Thông tin liên hệ</h2>
                    
                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-text">
                            <h3>Địa chỉ</h3>
                            <p>280 An Dương Vương<br>
                            Phường Chợ Quán, TP. Hồ Chí Minh<br>
                            Việt Nam</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div class="info-text">
                            <h3>Điện thoại</h3>
                            <p>Hotline: <a href="tel:18000081">1800 0081</a><br>
                            Đặt bàn: <a href="tel:0965790259">0965 790 259</a></p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">✉️</div>
                        <div class="info-text">
                            <h3>Email</h3>
                            <p>Hỗ trợ: <a href="mailto:support@wowfood.vn">support@bepcuasoc.vn</a><br>
                            Đặt hàng: <a href="mailto:order@wowfood.vn">order@bepcuasoc.vn</a></p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">🕒</div>
                        <div class="info-text">
                            <h3>Giờ làm việc</h3>
                            <p>Thứ 2 - Thứ 6: 8:00 - 22:00<br>
                            Thứ 7 - Chủ nhật: 9:00 - 22:00</p>
                        </div>
                    </div>

                    <div class="social-links">
                        <h3>Theo dõi chúng tôi</h3>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/share/1EKhUe9QJD/?mibextid=wwXIfr" title="Facebook"><img src="https://img.icons8.com/fluent/48/000000/facebook-new.png" alt="Facebook"></a>
                            <a href="https://www.instagram.com/bepcuasoc_?igsh=MXJ1Nmx1amt5bjZrNg%3D%3D&utm_source=qr" title="Instagram"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png" alt="Instagram"></a>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h2>Gửi tin nhắn cho chúng tôi</h2>
                    
                    <?php
                        if(isset($_POST['submit_contact'])) {
                            $name = mysqli_real_escape_string($conn, $_POST['name']);
                            $email = mysqli_real_escape_string($conn, $_POST['email']);
                            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                            $subject = mysqli_real_escape_string($conn, $_POST['subject']);
                            $message = mysqli_real_escape_string($conn, $_POST['message']);
                            $date = date("Y-m-d H:i:s");
                            
                            $sql = "INSERT INTO lien_he (ten, email, sdt, tieu_de, noi_dung, ngay_gui) 
                                    VALUES ('$name', '$email', '$phone', '$subject', '$message', '$date')";
                            
                            $res = mysqli_query($conn, $sql);
                            
                            if($res) {
                                echo "<div class='alert alert-success'>✓ Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.</div>";
                            } else {
                                echo "<div class='alert alert-error'>✗ Có lỗi xảy ra. Vui lòng thử lại!</div>";
                            }
                        }
                    ?>
                    
                    <form action="" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Họ và tên *</label>
                                <input type="text" id="name" name="name" placeholder="Nguyễn Văn A" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" placeholder="abc@gmail.com" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Số điện thoại *</label>
                                <input type="tel" id="phone" name="phone" placeholder="0912345678" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Tiêu đề</label>
                                <input type="text" id="subject" name="subject" placeholder="Vấn đề bạn muốn liên hệ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message">Nội dung *</label>
                            <textarea id="message" name="message" rows="6" placeholder="Nhập nội dung tin nhắn của bạn..." required></textarea>
                        </div>

                        <button type="submit" name="submit_contact" class="btn-submit">
                             Gửi tin nhắn
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <section class="map-section">
        <div class="container">
            <h2 class="text-center">Vị trí của chúng tôi</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62714.40840086596!2d106.61214555820311!3d10.761393999999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1b91dddf0b%3A0x1ab004c91f448812!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBTxrAgcGjhuqFtIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaA!5e0!3m2!1svi!2s!4v1767531494902!5m2!1svi!2s" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

<?php include('part-front/footer.php'); ?>