<?php
    require('top.inc.php');
    isAdmin();
?>

	<!-- start order master section -->
	<div class="container mt-5 bg-white rounded p-3">
      <div class="row">
        <div class="col-6 fw-bold mb-3 h4">Order Master</div>
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
                <th scope="col">Shipment Details</th>
              </tr>
            </thead>
            <tbody>
				<?php
					$res=mysqli_query($con,"select `order`.*,order_status.name as order_status_str from `order`,order_status where order_status.id=`order`.order_status order by `order`.id desc");
					while($row = mysqli_fetch_assoc($res)) { ?>
					<tr>
						<td>
							<a href="order_master_detail.php?id=<?php echo $row['id']?>">
								<?php echo $row['id']?>
							</a><br/>
							<a href="../order_pdf.php?id=<?php echo $row['id']?>">PDF</a>
						</td>
						<td><?php echo $row['added_on']?></td>
						<td>
							<?php echo $row['address']?><br/>
							<?php echo $row['city']?><br/>
							<?php echo $row['pincode']?>
						</td>
						<td><?php echo $row['payment_type']?></td>
						<td><?php echo $row['payment_status']?></td>
						<td><?php echo $row['order_status_str']?></td>
						<td>
						<?php 
							echo "Order Id:- ".$row['ship_order_id'].'<br/>';
							echo "Shipment Id:- ".$row['ship_shipment_id'];						
						?>
						</td>
					</tr>
				<?php } ?>
            </tbody>
          </table>
        </div>
      </div>
  	</div>
  	<!-- end order master section -->

<?php require('footer.inc.php'); ?>