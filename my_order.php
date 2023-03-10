<?php 
    require('top.php');

    if(!isset($_SESSION['USER_LOGIN'])){
        ?>
        <script>
            window.location.href='index.php';
        </script>
        <?php
    }
?>

<!-- start my order section -->
<div class="container mt-5 bg-white rounded p-3">
    <div class="row">
        <h4 class="col-6 fw-bold mb-3">My Orders</h4>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Address</th>
                        <th scope="col">Payment Type</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Order Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $uid=$_SESSION['USER_ID'];
                $res=mysqli_query($con,"select `order`.*,order_status.name as order_status_str from `order`,order_status where `order`.user_id='$uid' and order_status.id=`order`.order_status order by `order`.id desc");
                while($row=mysqli_fetch_assoc($res)){
                ?>
                    <tr>
                        <td>
                            <a href="my_order_details.php?id=<?php echo $row['id']?>"><?php echo $row['id']?></a> <br />
                            <a href="order_pdf.php?id=<?php echo $row['id']?>">PDF</a>
                        </td>
                        <td><?php echo $row['added_on']?></td>
                        <td>
                            <?php echo $row['address']?><br />
                            <?php echo $row['city']?><br />
                            <?php echo $row['pincode']?>
                        </td>
                        <td><?php echo $row['payment_type']?></td>
                        <td><?php echo ucfirst($row['payment_status'])?></td>
                        <td><?php echo $row['order_status_str']?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- end my order section -->        
        						
<?php require('footer.php')?>        