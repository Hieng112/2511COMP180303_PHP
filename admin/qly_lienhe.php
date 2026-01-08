<?php include('part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>QUẢN LÝ LIÊN HỆ</h1>
        <br />

        <?php 
            if(isset($_SESSION['reply'])) {
                echo $_SESSION['reply'];
                unset($_SESSION['reply']);
            }
            
            if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
        ?>
        <br />

        <table class="tbl-full">
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Trạng thái</th>
                <th>Phản hồi</th>
                <th>Hoạt động</th>
            </tr>

            <?php
                $sql = "SELECT * FROM lien_he ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $stt = 1;

                if($count > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $ten = $row['ten'];
                        $email = $row['email'];
                        $sdt = $row['sdt'];
                        $tieu_de = $row['tieu_de'];
                        $noi_dung = $row['noi_dung'];
                        $ngay_gui = $row['ngay_gui'];
                        $trang_thai = $row['trang_thai'];
                        $phan_hoi = isset($row['phan_hoi']) ? $row['phan_hoi'] : '';
                        ?>
                        
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $ten; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $sdt; ?></td>
                            <td><?php echo $tieu_de ? $tieu_de : '<em style="color:#999;">Không có</em>'; ?></td>
                            <td>
                                <div style="max-width: 200px; max-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo substr($noi_dung, 0, 100); ?>...
                                </div>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ngay_gui)); ?></td>
                            <td>
                                <?php 
                                    if($trang_thai == 'Chưa xử lý') {
                                        echo "<span style='color: orange; font-weight: bold;'> $trang_thai</span>";
                                    } else if($trang_thai == 'Đã xử lý') {
                                        echo "<span style='color: green; font-weight: bold;'> $trang_thai</span>";
                                    } else {
                                        echo "<span style='color: blue; font-weight: bold;'> $trang_thai</span>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($phan_hoi) {
                                        echo "<div style='max-width: 150px; font-size: 12px; color: #666;'>" . substr($phan_hoi, 0, 50) . "...</div>";
                                    } else {
                                        echo "<em style='color: #999;'>Chưa có</em>";
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/phan_hoi_lienhe.php?id=<?php echo $id; ?>" 
                                   class="btn-secondary">
                                   <?php echo $phan_hoi ? 'Xem/Sửa' : ' Phản hồi'; ?>
                                </a>
                                <a href="<?php echo SITEURL; ?>admin/delete_lienhe.php?id=<?php echo $id; ?>" 
                                   class="btn-danger"
                                   onclick="return confirm('Xóa liên hệ này?');">Xóa</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<tr><td colspan='10' class='error'>Chưa có liên hệ nào.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<?php include('part/footer.php'); ?>