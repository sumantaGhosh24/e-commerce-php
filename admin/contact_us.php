<?php
    require('top.inc.php');

    isAdmin();

    if(isset($_GET['type']) && $_GET['type']!=''){
        $type=get_safe_value($con,$_GET['type']);
        
        if($type=='delete'){
            $id=get_safe_value($con,$_GET['id']);
            $delete_sql="DELETE FROM contact_us WHERE id='$id'";
            mysqli_query($con,$delete_sql);
        }
    }

    $sql="SELECT * FROM contact_us ORDER BY id DESC";
    $res=mysqli_query($con,$sql);
?>

	<!-- start contact us section -->
	<div class="container mt-5 bg-white rounded p-3">
      <div class="row">
        <div class="col-6 fw-bold mb-3 h4">Contact Us</div>
      </div>
      <div class="row mt-5">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Comment</th>
                <th scope="col">Date</th>
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
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['mobile']; ?></td>
						<td><?php echo $row['comment']; ?></td>
						<td><?php echo $row['added_on']; ?></td>
						<td>
							<?php
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
	<!-- end contact us section -->

<?php require('footer.inc.php'); ?>