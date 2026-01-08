<?php include('part/menu.php') ?>
    <div class="main-content">
        <div class="wrapper">
        <h1> QUẢN LÝ DANH MỤC</h1>
  <br />
  <?php
        if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }   
        if(isset($_SESSION['remove'])) {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }    
        if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }  
        if(isset($_SESSION['no-category-found'])) {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }  
        ?>
<br> <br>
                <a href="add_danhmuc.php" class="btn-primary"> THÊM DANH MỤC </a>
                <br /> <br/>
                <table class="tbl-full">
                    <tr>
                        <th> STT </th>
                        <th> Tên Danh mục </th>
                        <th> Hình ảnh </th>
                        <th> Nổi bật </th>
                        <th> Trạng thái </th>
                        <th> Hoạt động </th>
                    </tr>
                    <?php 
                        $sql = "SELECT * FROM danh_muc";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        $stt = 1;
                        if($count > 0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $title= $row['ten_danh_muc'];
                                $image_name = $row['ten_anh'];
                                $featured = $row['noi_bat'];
                                $active = $row['trang_thai'];

                                ?>
                                <tr>
                                    <td><?php echo $stt++; ?>  </td>
                                    <td> <?php echo $title; ?> </td>
                                    <td>
                                        <?php 
                    
                                if($image_name != "" && file_exists("../images/danhmuc/".$image_name)) {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/danhmuc/<?php echo $image_name; ?>" 
                                         width="100px" 
                                         alt="<?php echo $title; ?>">
                                    <?php
                                } else {
                                    echo "<div class='error'>Không có hình ảnh.</div>";
                                }
                            ?>
                                        
                                    </td>
                                    <td> <?php echo $featured; ?></td>
                                    <td> <?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update_danhmuc.php?id=<?php echo $id; ?> $image_name=<?php echo $image_name;?>" class="btn-secondary"> Chỉnh sửa </a>
                                        <a href="<?php echo SITEURL; ?>admin/delete_danhmuc.php?id=<?php echo $id; ?> $image_name=<?php echo $image_name;?>" class="btn-danger"> Xóa </a>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else 
                        {
                            //
                            ?>
                            <tr>
                                <td colspan="6"><div class="error"> Không thêm được danh mục.</div></td>
                            </tr>

                            <?php
                        }
                    ?>

                    

                </table>
        </div>
    </div>
<?php include('part/footer.php') ?>