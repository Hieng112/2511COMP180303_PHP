<?php 
    include('config/constants.php');
    
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    
    include('part/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>QUẢN LÝ NHÂN VIÊN</h1>
        
        <?php 
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['password'])) {
                echo $_SESSION['password'];
                unset($_SESSION['password']);
            }
        ?>
        
        <br />
        <a href="add_admin.php" class="btn-primary"> Thêm Nhân viên</a>
        <br><br>
        
        <?php 
            $sql = "SELECT * FROM qtv ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            
            if($res) {
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
        ?>
        <br/>
                    <p>Tổng số: <strong><?php echo $count; ?></strong> nhân viên</p>
                    <br/>
                    
                    <table class="tbl-full">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ Tên</th>
                                <th>Username</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $stt = 1;
                                while($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $ho_ten = $row['ho_ten'];
                                    $username = $row['username'];
                            ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td><?php echo htmlspecialchars($ho_ten); ?></td>
                                        <td><?php echo htmlspecialchars($username); ?></td>
                                        <td>
                                            <a href="update_pass.php?id=<?php echo $id; ?>" class="btn-primary">
                                                Đổi Mật Khẩu
                                            </a>
                                            <a href="update_admin.php?id=<?php echo $id; ?>" class="btn-secondary">
                                                Chỉnh sửa
                                            </a>
                                            <a href="delete_admin.php?id=<?php echo $id; ?>" class="btn-danger"
                                               onclick="return confirm('⚠️ Xác nhận xóa:\n\nID: <?php echo $id; ?>\nTên: <?php echo $ho_ten; ?>\n\nBạn có chắc chắn?');">
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                            <?php 
                                } 
                            ?>
                        </tbody>
                    </table>
        <?php 
                } else {
                    echo '<div class="error">Chưa có nhân viên nào trong hệ thống</div>';
                }
            } else {
                echo '<div class="error">Lỗi truy vấn: ' . mysqli_error($conn) . '</div>';
            }
        ?>
    </div>
</div>

<?php include('part/footer.php'); ?>