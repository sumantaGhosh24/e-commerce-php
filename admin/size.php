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
            $update_status_sql="UPDATE size_master SET status='$status' WHERE id='$id'";
            mysqli_query($con,$update_status_sql);
        }
        
        if($type=='delete'){
            $id=get_safe_value($con,$_GET['id']);
            $delete_sql="DELETE FROM size_master WHERE id='$id'";
            mysqli_query($con,$delete_sql);
        }
    }

    $sql="SELECT * FROM size_master ORDER BY size ASC";
    $res=mysqli_query($con,$sql);
?>

	<!-- start size section -->
	<div class="container mt-5 bg-white rounded p-3">
      <div class="row">
        <div class="col-6 fw-bold mb-3 h4">Size</div>
        <div class="col-6">
          <a class="btn btn-primary btn-lg" href="manage_size.php">Add Size</a>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Id</th>
                <th scope="col">Size</th>
                <th scope="col">Order By</th>
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
						<td><?php echo $row['size']; ?></td>
						<td><?php echo $row['order_by']; ?></td>
						<td>
							<?php
							if($row['status'] == 1) {
								echo "<a class='btn btn-success btn-sm' href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>";
							} else {
								echo "<a class='btn btn-danger btn-sm' href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>";
							}
							echo "<a class='btn btn-warning btn-sm mx-3' href='manage_size.php?id=".$row['id']."'>Edit</a>";
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
  	<!-- end size section -->

<?php require('footer.inc.php'); ?>