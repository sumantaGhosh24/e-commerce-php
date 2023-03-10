<?php 
	require('top.php');

	if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
		?>
		<script>
		window.location.href='my_order.php';
		</script>
		<?php
	}
?>

<!-- start forgot password section -->
<div class="container">
	<div class="row">
		<div class="col-8 offset-2">
			<h2 class="text-center mb-4">Forgot Password</h2>
			<form id="login-form" method="post">
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" id="email" name="email" placeholder="Enter your email address" class="form-control" />
					<span class="text-danger" id="email_error"></span>
				</div>
				<button type="button" class="btn btn-lg btn-success" onclick="forgot_password()" id="btn_submit">Submit</button>	
			</form>
		</div>
	</div>
</div>
<!-- end forgot password section -->

<script>
	function forgot_password(){
		jQuery('#email_error').html('');
		var email=jQuery('#email').val();
		if(email==''){
			jQuery('#email_error').html('Please enter email id');
		}else{
			jQuery('#btn_submit').html('Please wait...');
			jQuery('#btn_submit').attr('disabled',true);
			jQuery.ajax({
				url:'forgot_password_submit.php',
				type:'post',
				data:'email='+email,
				success:function(result){
					jQuery('#email').val('');
					jQuery('#email_error').html(result);
					jQuery('#btn_submit').html('Submit');
					jQuery('#btn_submit').attr('disabled',false);
				}
			})
		}
	}
</script>

<?php require('footer.php')?>        