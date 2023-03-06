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
            $update_status_sql="UPDATE banner SET status='$status' WHERE id='$id'";
            mysqli_query($con,$update_status_sql);
        }
        
        if($type=='delete'){
            $id=get_safe_value($con,$_GET['id']);
            $delete_sql="DELETE FROM banner WHERE id='$id'";
            mysqli_query($con,$delete_sql);
        }
    }

    $sql="SELECT * FROM banner ORDER BY id ASC";
    $res=mysqli_query($con,$sql);
?>

	<!-- start banner section -->
	<div class="container mt-5 bg-white rounded p-3">
      <div class="row">
        <div class="col-6 fw-bold mb-3 h4">Banner</div>
        <div class="col-6">
          <a class="btn btn-primary btn-lg" href="manage_banner.php">Add Banner</a>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Heading1</th>
                <th scope="col">Heading2</th>
                <th scope="col">Btn Text</th>
                <th scope="col">Btn Link</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
				<?php
					$i = 1;
					while($row = mysqli_fetch_assoc($res)) { ?>
					<tr>
						<th scope="row"><?php echo $i; ?></th>
						<td><?php echo $row['heading1']; ?></td>
						<td><?php echo $row['heading2']; ?></td>
						<td><?php echo $row['btn_txt']; ?></td>
						<td><?php echo $row['btn_link']; ?></td>
						<td>
							<?php
								echo "<a target='_blank' href='".BANNER_SERVER_PATH.$row['image']."'><img width='150px' src='".BANNER_SERVER_PATH.$row['image']."'/></a>";
							?>
						</td>
						<td>
							<?php
							if($row['status'] == 1) {
								echo "<a class='btn btn-success btn-sm' href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>";
							} else {
								echo "<a class='btn btn-danger btn-sm' href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>";
							}
							echo "<a class='btn btn-warning btn-sm mx-3' href='manage_banner.php?id=".$row['id']."'>Edit</a>";
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
  <!-- end banner section -->

<?php require('footer.inc.php'); ?>