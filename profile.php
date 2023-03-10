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

<!-- start profile section -->
<div class="container mt-5">
	<div class="row">
		<div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
			<h2 class="text-center mb-4">Profile</h2>
			<form id="login-form" method="post">
				<div class="mb-3">
					<label for="name" class="form-label">Username</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" value="<?php echo $_SESSION['USER_NAME']?>" />
					<span class="text-danger" id="name_error"></span>
				</div>
				<button type="button" class="btn btn-lg btn-success" onclick="update_profile()" id="btn_submit">Update</button>
			</form>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
			<h2 class="text-center mb-4">Change Password</h2>
			<form method="post" id="frmPassword">
				<div class="mb-3">
					<label for="current_password" class="form-label">Current Password</label>
					<input type="password" class="form-control" name="current_password" id="current_password" />
					<span class="text-danger" id="current_password_error"></span>
				</div>
				<div class="mb-3">
					<label for="new_password" class="form-label">New Password</label>
					<input type="password" name="new_password" id="new_password" class="form-control" />
					<span class="text-danger" id="new_password_error"></span>
				</div>
				<div class="mb-3">
					<label for="confirm_new_password" class="form-label">Confirm New Password</label>
					<input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" />
					<span class="text-danger" id="confirm_new_password_error"></span>
				</div>
				<button type="button" class="btn btn-lg btn-success" onclick="update_password()" id="btn_update_password">Update</button>
			</form>
		</div>
	</div>
</div>
<!-- end profile section -->

<script>
	function update_profile(){
		jQuery('.field_error').html('');
		var name=jQuery('#name').val();
		if(name==''){
			jQuery('#name_error').html('Please enter your name');
		}else{
			jQuery('#btn_submit').html('Please wait...');
			jQuery('#btn_submit').attr('disabled',true);
			jQuery.ajax({
				url:'update_profile.php',
				type:'post',
				data:'name='+name,
				success:function(result){
					jQuery('#name_error').html(result);
					jQuery('#btn_submit').html('Update');
					jQuery('#btn_submit').attr('disabled',false);
				}
			})
		}
	}
		
	function update_password(){
		jQuery('.field_error').html('');
		var current_password=jQuery('#current_password').val();
		var new_password=jQuery('#new_password').val();
		var confirm_new_password=jQuery('#confirm_new_password').val();
		var is_error='';
		if(current_password==''){
			jQuery('#current_password_error').html('Please enter password');
			is_error='yes';
		}if(new_password==''){
			jQuery('#new_password_error').html('Please enter password');
			is_error='yes';
		}if(confirm_new_password==''){
			jQuery('#confirm_new_password_error').html('Please enter password');
			is_error='yes';
		}
		
		if(new_password!='' && confirm_new_password!='' && new_password!=confirm_new_password){
			jQuery('#confirm_new_password_error').html('Please enter same password');
			is_error='yes';
		}
		
		if(is_error==''){
			jQuery('#btn_update_password').html('Please wait...');
			jQuery('#btn_update_password').attr('disabled',true);
			jQuery.ajax({
				url:'update_password.php',
				type:'post',
				data:'current_password='+current_password+'&new_password='+new_password,
				success:function(result){
					jQuery('#current_password_error').html(result);
					jQuery('#btn_update_password').html('Update');
					jQuery('#btn_update_password').attr('disabled',false);
					jQuery('#frmPassword')[0].reset();
				}
			})
		}
		
	}
</script>

<?php require('footer.php')?>        