<?php
    require('top.inc.php');

    isAdmin();

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
            $update_status_sql="update product_review set status='$status' where id='$id'";
            mysqli_query($con,$update_status_sql);
        }
        if($type=='delete'){
            $id=get_safe_value($con,$_GET['id']);
            $delete_sql="delete from product_review where id='$id'";
            mysqli_query($con,$delete_sql);
        }
    }

    $sql="select users.name,users.email,product_review.id,product_review.rating,product_review.review,product_review.added_on,product_review.status,product.name as pname from users,product_review,product where product_review.user_id=users.id and product_review.product_id=product.id  order by product_review.added_on desc";
    $res=mysqli_query($con,$sql);
?>

	<!-- start product review section -->
	<div class="container mt-5 bg-white rounded p-3">
      <div class="row">
        <div class="col-6 fw-bold mb-3 h4">Product Review</div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Id</th>
                <th scope="col">Name/Email</th>
                <th scope="col">Product Name</th>
                <th scope="col">Rating</th>
                <th scope="col">Review</th>
                <th scope="col">Added On</th>
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
						<td>
							<?php echo $row['name']; ?>
							<?php echo $row['email']; ?>
						</td>
						<td><?php echo $row['pname']; ?></td>
						<td><?php echo $row['rating']; ?></td>
						<td><?php echo $row['review']; ?></td>
						<td><?php echo $row['added_on']; ?></td>
						<td>
							<?php
							if($row['status'] == 1) {
								echo "<a class='btn btn-success btn-sm' href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>";
							} else {
								echo "<a class='btn btn-danger btn-sm' href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>";
							}
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
  	<!-- end product review section -->

<?php require('footer.inc.php'); ?>