<?php require('top.inc.php'); ?>

	<!-- start order vendor section -->
	<div class="container mt-5 bg-white rounded p-3">
		<div class="row">
			<div class="col-6 fw-bold mb-3 h4">Order Vendor</div>
		</div>
		<div class="row mt-5">
			<div class="col-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">Order Id</th>
							<th scope="col">Product Name/Qty</th>
							<th scope="col">Address</th>
							<th scope="col">Payment Type</th>
							<th scope="col">Payment Status</th>
							<th scope="col">Order Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$res=mysqli_query($con,"SELECT order_detail.qty,product.name,`order`.*,order_status.name AS order_status_str FROM order_detail,product,`order`,order_status WHERE order_status.id=`order`.order_status AND product.id=order_detail.product_id AND `order`.id=order_detail.order_id AND product.added_by='".$_SESSION['ADMIN_ID']."' ORDER BY `order`.id DESC");
						while($row=mysqli_fetch_assoc($res)){
						?>
						<tr>
							<td scope="row"><?php echo $row['id']?><br/>
							</td>
							<td scope="row">
								<?php echo $row['name']?><br/>
								<?php echo $row['qty']?>
							</td>
							<td scope="row">
								<?php echo $row['address']?><br/>
								<?php echo $row['city']?><br/>
								<?php echo $row['pincode']?>
							</td>
							<td scope="row"><?php echo $row['payment_type']?></td>
							<td scope="row"><?php echo $row['payment_status']?></td>
							<td scope="row"><?php echo $row['order_status_str']?></td>					
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- end order vendor section -->

<?php require('footer.inc.php'); ?>