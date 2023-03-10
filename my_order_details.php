<?php 
    require('top.php');

    if(!isset($_SESSION['USER_LOGIN'])){
        ?>
        <script>
        window.location.href='index.php';
        </script>
        <?php
    }
    $order_id=get_safe_value($con,$_GET['id']);

    $coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value from `order` where id='$order_id'"));
    $coupon_value=$coupon_details['coupon_value'];
    if($coupon_value==''){
        $coupon_value=0;	
    }
?>

<!-- start my order -->
<div class="container mt-5 bg-white rounded p-3">
    <div class="row">
        <div class="col-6 fw-bold mb-3 h4">My Orders</div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total Price</th>
                </thead>
                <tbody>
                <?php
                $uid=$_SESSION['USER_ID'];
                $res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
                $total_price=0;
                while($row=mysqli_fetch_assoc($res)) {
                $total_price=$total_price+($row['qty']*$row['price']);
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$row['image']?>">
                    </td>
                    <td><?php echo $row['qty']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['price']*$row['price'] ?></td>
                </tr>
                <?php }
                if($coupon_value != '') { ?>
                <tr>
                    <td></td>
                    <td>Coupon Value</td>
                    <td><?php echo $coupon_value; ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td>Total Price</td>
                    <td><?php echo $total_price-$coupon_value; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- end my order -->        
        						
<?php require('footer.php')?>        