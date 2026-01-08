<?php include('part/menu.php'); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1> BẾP CỦA SÓC </h1>
                <br> <br>
                <?php 
                    if(isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                ?>
                <br> <br>
                <div class="col-4 text-center">
                    <?php
                        $sql = "SELECT * FROM danh_muc";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                    ?>
                    <h1> <?php echo $count; ?> </h1> <br />
                    DANH MỤC
                </div>
                <div class="col-4 text-center">
                    <?php
                        $sql2 = "SELECT * FROM san_pham";
                        $res2 = mysqli_query($conn, $sql2);
                        $count2 = mysqli_num_rows($res2);
                    ?>
                    <h1> <?php echo $count2; ?> </h1> <br />
                    SẢN PHẨM
                </div>
                <div class="col-4 text-center">
                    <?php
                        $sql3 = "SELECT * FROM don_hang";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1> <?php echo $count3; ?> </h1> <br />
                    ĐƠN HÀNG
                </div>
               <div class="col-4 text-center">
                    <?php
                        $sql4 = "SELECT SUM(tong_tien) AS tong_tien FROM don_hang WHERE trang_thai_don='Đã giao'";
                        $res4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                        $doanhthu = $row4['tong_tien'];
                    ?>
                    <h1> 
                        <?php 
                            echo $doanhthu ? number_format($doanhthu, 0, ',', '.') . ' VNĐ' : '0 VNĐ'; 
                        ?> 
                    </h1>
                    <br />
                    DOANH THU
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
 <?php include ('part/footer.php') ?>