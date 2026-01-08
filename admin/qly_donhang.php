<?php include('part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>QUẢN LÝ ĐƠN HÀNG</h1>
        <br />

        <?php 
            if(isset($_SESSION['order'])) {
                echo $_SESSION['order'];
                unset($_SESSION['order']);
            }
            
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
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
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Hoạt động</th>
            </tr>

            <?php
                $sql = "SELECT * FROM don_hang ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $stt = 1;

                if($count > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $food = $row['san_pham'];
                        $gia = $row['gia'];
                        $soluong = $row['so_luong'];
                        $total = $row['tong_tien'];
                        $date = $row['ngay_dat_hang'];
                        $status = $row['trang_thai_don'];
                        $kh_name = $row['ten_khach_hang'];
                        $sdt = $row['SDT'];
                        $email = $row['email'];
                        $diachi = $row['dia_chi'];
                        ?>
                        
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo number_format($gia, 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo $soluong; ?></td>
                            <td><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo date('d/m/Y H:i', strtotime($date)); ?></td>
                            <td>
                                <?php 
                                    if($status == "Đã đặt") {
                                        echo "<span style='color: orange;'>$status</span>";
                                    } else if($status == "Đang giao") {
                                        echo "<span style='color: blue;'>$status</span>";
                                    } else if($status == "Đã giao") {
                                        echo "<span style='color: green;'>$status</span>";
                                    } else {
                                        echo "<span style='color: red;'>$status</span>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $kh_name; ?></td>
                            <td><?php echo $sdt; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $diachi; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update_donhang.php?id=<?php echo $id; ?>" 
                                   class="btn-secondary">Chỉnh sửa</a>
                                <a href="<?php echo SITEURL; ?>admin/delete_donhang.php?id=<?php echo $id; ?>" 
                                   class="btn-danger"
                                   onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">Xóa</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<tr><td colspan='12' class='error'>Chưa có đơn hàng nào.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<?php include('part/footer.php'); ?>