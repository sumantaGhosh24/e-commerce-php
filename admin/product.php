<?php
    require('top.inc.php');

    $condition='';
    $condition1='';
    if($_SESSION['ADMIN_ROLE']==1){
        $condition=" AND product.added_by='".$_SESSION['ADMIN_ID']."'";
        $condition1=" AND added_by='".$_SESSION['ADMIN_ID']."'";
    }

    if(isset($_GET['type']) && $_GET['type']!=''){
        $type=get_safe_value($con,$_GET['type']);
        if($type=='status'){
            $operation=get_safe_value($con,$_GET['operation']);
            $id=get_safe_value($con,$_GET['id']);
            if($operation=='active'){
                $status='1';
            }else{
                $status='0';
            }
            $update_status_sql="UPDATE product SET status='$status' $condition1 WHERE id='$id'";
            mysqli_query($con,$update_status_sql);
        }
        
        if($type=='delete'){
            $id=get_safe_value($con,$_GET['id']);
            $delete_sql="DELETE FROM product WHERE id='$id' $condition1";
            mysqli_query($con,$delete_sql);
        }
    }

    $sql="SELECT product.*,categories.categories FROM product,categories WHERE product.categories_id=categories.id $condition ORDER BY product.id DESC";
    $res=mysqli_query($con,$sql);
?>

	<!-- start product section -->
	<div class="container mt-5 bg-white rounded p-3">
      <div class="row">
        <div class="col-6 fw-bold mb-3 h4">Product</div>
        <div class="col-6">
          <a class="btn btn-primary btn-lg" href="manage_product.php">Add Product</a>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Id</th>
                <th scope="col">Categories</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">MRP</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
				<?php
					$i = 1;
					while($row = mysqli_fetch_assoc($res)) { ?>
					<tr>
						<th scope="row"><?php echo $i; ?></th>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['categories']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td>
							<img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$row['image']; ?>" />
						</td>
						<td><?php echo $row['mrp']; ?></td>
						<td><?php echo $row['price']; ?></td>
						<td>
							<?php echo $row['qty']?><br/>
							<?php
							   $productSoldQtyByProductId=productSoldQtyByProductId($con,$row['id']);
							   $pneding_qty=$row['qty']-$productSoldQtyByProductId;
							?>
							Pending Qty <?php echo $pneding_qty?>							   
						</td>
						<td>
							<?php
							if($row['status'] == 1) {
								echo "<a class='btn btn-success btn-sm' href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>";
							} else {
								echo "<a class='btn btn-danger btn-sm' href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>";
							}
							echo "<a class='btn btn-warning btn-sm mx-3' href='manage_product.php?id=".$row['id']."'>Edit</a>";
							echo "<a class='btn btn-danger btn-sm' href='?type=delete&id=".$row['id']."'>Delete</a>";
							?>
						</td>
					</tr>
				<?php } ?>
            </tbody>
          </table>
        </div>
      </div>
  	</div>
  	<!-- end product section -->

<?php require('footer.inc.php'); ?>