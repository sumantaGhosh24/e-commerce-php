<?php
    require('top.inc.php');

    isAdmin();

    $order_id=get_safe_value($con,$_GET['id']);
    $coupon_details=mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value,coupon_code FROM `order` WHERE id='$order_id'"));

    $coupon_value=$coupon_details['coupon_value'];
    if($coupon_value==''){
        $coupon_value=0;
    }
    $coupon_code=$coupon_details['coupon_code'];
    if(isset($_POST['update_order_status'])){
        $update_order_status=$_POST['update_order_status'];
        
        $update_sql='';
        if($update_order_status==3){
            $length=$_POST['length'];
            $breadth=$_POST['breadth'];
            $height=$_POST['height'];
            $weight=$_POST['weight'];
            
            $update_sql=",length='$length',breadth='$breadth',height='$height',weight='$weight' ";
            
        }
        
        if($update_order_status=='5'){
            mysqli_query($con,"UPDATE `order` SET order_status='$update_order_status',payment_status='Success' WHERE id='$order_id'");
        }else{
            mysqli_query($con,"UPDATE `order` SET order_status='$update_order_status' $update_sql WHERE id='$order_id'");
        }
        
        if($update_order_status==3){
            $token=validShipRocketToken($con);
            if($token!=''){
                placeShipRocketOrder($con,$token,$order_id);
            }
        }
        
        if($update_order_status==4){
            $ship_order=mysqli_fetch_assoc(mysqli_query($con,"SELECT ship_order_id FROM `order` WHERE id='$order_id'"));
            if($ship_order['ship_order_id']>0){
                $token=validShipRocketToken($con);
                cancelShipRocketOrder($token,$ship_order['ship_order_id']);
            }
        }        
    }
?>

	<!-- start order master detail section -->
	<div class="container mt-5 bg-white rounded p-3">
		<div class="row">
			<div class="col-6 fw-bold mb-3 h4">Order Detail</div>
		</div>
		<div class="row mt-5">
			<div class="col-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">Product Name</th>
							<th scope="col">Product Image</th>
							<th scope="col">Qty</th>
							<th scope="col">Price</th>
							<th scope="col">Total Price</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$res=mysqli_query($con,"SELECT distinct(order_detail.id) ,order_detail.*,product.name,product.image,`order`.address,`order`.city,`order`.pincode FROM order_detail,product ,`order` WHERE order_detail.order_id='$order_id' AND  order_detail.product_id=product.id GROUP BY order_detail.id");
					$total_price=0;
					while($row=mysqli_fetch_assoc($res)) {
						$userInfo=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `order` WHERE id='$order_id'"));
						
						$address=$userInfo['address'];
						$city=$userInfo['city'];
						$pincode=$userInfo['pincode'];
						
						$total_price=$total_price+($row['qty']*$row['price']);
					?>
						<tr>
							<td scope="col"><?php echo $row['name']?></td>
							<td scope="col"> <img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$row['image']?>"></td>
							<td scope="col"><?php echo $row['qty']?></td>
							<td scope="col"><?php echo $row['price']?></td>
							<td scope="col"><?php echo $row['qty']*$row['price']?></td>							
						</tr>
					<?php } 
					if($coupon_value!=''){
					?>
						<tr>
							<td scope="col"></td>
							<td scope="col">Coupon Value</td>
							<td scope="col">
								<?php echo $coupon_value."($coupon_code)"; ?>
							</td>							
						</tr>
					<?php } ?>
						<tr>
							<td scope="col"></td>
							<td scope="col">Total Price</td>
							<td scope="col">
								<?php echo $total_price-$coupon_value; ?>
							</td>							
						</tr>
					</tbody>
				</table>
				<div id="address_details">
					<strong>Address</strong>
					<?php echo $address?>, <?php echo $city?>, <?php echo $pincode?><br/><br/>
					<strong>Order Status</strong>
					<?php 
					$order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"SELECT order_status.name,order_status.id AS order_status FROM order_status,`order` WHERE `order`.id='$order_id' AND `order`.order_status=order_status.id"));
					echo $order_status_arr['name'];
					?>					
					<div>
						<form method="post">
							<select class="form-control" name="update_order_status" id="update_order_status" required onchange="select_status()">
								<option value="">Select Status</option>
								<?php
								$res=mysqli_query($con,"SELECT * FROM order_status");
								while($row=mysqli_fetch_assoc($res)){
									echo "<option value=".$row['id'].">".$row['name']."</option>";
								}
								?>
							</select>
							<div id="shipped_box" style="display:none">
								<table>
									<tr>
										<td><input type="text" class="form-control" name="length" placeholder="length"/></td>
										<td><input type="text" class="form-control" name="breadth" placeholder="Breadth"/></td>
										<td><input type="text" class="form-control" name="height" placeholder="height"/></td>
										<td><input type="text" class="form-control" name="weight" placeholder="weight"/></td>
									</tr>
								</table>
							</div>
							<input type="submit" class="form-control"/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end order master detail section -->

	<!-- jquery and ajax cdn -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

	<script>
		function select_status(){
			var update_order_status=jQuery('#update_order_status').val();
			if(update_order_status==3){
				jQuery('#shipped_box').show();
			}
		}
	</script>

<?php require('footer.inc.php'); ?>