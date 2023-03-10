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

<!-- start register & login section -->
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-8 offset-md-2">
			<h2 class="text-center mb-4">Login</h2>
			<form id="login-form" method="post">
				<div class="mb-3">
					<label for="login_email" class="form-label">Email</label>
					<input type="email" name="login_email" id="login_email" placeholder="Enter your email address" class="form-control" />
					<span class="text-danger" id="login_email_error"></span>
				</div>
				<div class="mb-3">
					<label for="login_password" class="form-label">Password</label>
					<input type="password" id="login_password" name="login_password" placeholder="Enter your password" class="form-control" />
					<span class="text-danger" id="login_password_error"></span>
				</div>
				<button type="button" class="btn btn-lg btn-success" onclick="user_login()">Login</button>
				<a ref="forgot_password.php">Forgot Password</a>
			</form>
		</div>
		<div class="col-lg-6 col-md-8 offset-md-2">
			<h2 class="text-center mb-4">Register</h2>
			<form id="register-form" method="post">
				<div class="mb-3">
					<label for="name" class="form-label">Name</label>
					<input type="text" name="name" id="name" placeholder="Enter your name" />
					<span class="text-danger" id="name_error"></span>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label">Email Address</label>
					<div class="row">
						<div class="col-8">
							<input type="email" name="email" id="email" placeholder="Enter your email address" />
						</div>
						<div class="col-4">
							<button type="button" class="btn btn-primary" onclick="email_sent_otp()">Sent OTP</button>
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label for="email_otp" class="form-label">Verify Email</label>
					<div class="row">
						<div class="col-8">
							<input type="text" name="email_otp" id="email_otp" placeholder="Enter your email otp" />
						</div>
						<div class="col-4">
							<button type="button" class="btn btn-primary" onclick="email_verify_otp()">Sent OTP</button>
						</div>
						<span class="text-danger" id="email_error"></span>
					</div>
				</div>
				<div class="mb-3">
					<label for="mobile" class="form-label">Mobile Number</label>
					<div class="row">
						<div class="col-8">
							<input type="text" name="mobile" id="mobile" placeholder="Enter your mobile number" />
						</div>
						<div class="col-4">
							<button type="button" class="btn btn-primary" onclick="mobile_sent_otp()">Sent OTP</button>
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label for="mobile_otp" class="form-label">Verify Mobile</label>
					<div class="row">
						<div class="col-8">
							<input type="text" name="mobile_otp" id="mobile_otp" placeholder="Enter your mobile otp" />
						</div>
						<div class="col-4">
							<button type="button" class="btn btn-primary" onclick="mobile_verify_otp()">Sent OTP</button>
						</div>
						<span id="mobile_otp_result"></span>
						<span class="text-danger" id="mobile_error"></span>
					</div>
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" name="password" id="password" placeholder="Enter your password" />
					<span class="text-danger" id="password_error"></span>
				</div>
				<button type="button" class="btn btn-lg btn-success" onclick="user_register()" disabled id="btn_register">Register</button>
			</form>
			<input type="hidden" id="is_email_verified"/>
			<input type="hidden" id="is_mobile_verified"/>
		</div>
	</div>
</div>
<!-- end register & login section -->

<script>
	function email_sent_otp(){
		jQuery('#email_error').html('');
		var email=jQuery('#email').val();
		if(email==''){
			jQuery('#email_error').html('Please enter email id');
		}else{
			jQuery('.email_sent_otp').html('Please wait..');
			jQuery('.email_sent_otp').attr('disabled',true);
			jQuery.ajax({
				url:'send_otp.php',
				type:'post',
				data:'email='+email+'&type=email',
				success:function(result){
					if(result=='done'){
						jQuery('#email').attr('disabled',true);
						jQuery('.email_verify_otp').show();
						jQuery('.email_sent_otp').hide();
						
					}else if(result=='email_present'){
						jQuery('.email_sent_otp').html('Send OTP');
						jQuery('.email_sent_otp').attr('disabled',false);
						jQuery('#email_error').html('Email id already exists');
					}else{
						jQuery('.email_sent_otp').html('Send OTP');
						jQuery('.email_sent_otp').attr('disabled',false);
						jQuery('#email_error').html('Please try after sometime');
					}
				}
			});
		}
	}

	function email_verify_otp(){
		jQuery('#email_error').html('');
		var email_otp=jQuery('#email_otp').val();
		if(email_otp==''){
			jQuery('#email_error').html('Please enter OTP');
		}else{
			jQuery.ajax({
				url:'check_otp.php',
				type:'post',
				data:'otp='+email_otp+'&type=email',
				success:function(result){
					if(result=='done'){
						jQuery('.email_verify_otp').hide();
						jQuery('#email_otp_result').html('Email id verified');
						jQuery('#is_email_verified').val('1');
						if(jQuery('#is_mobile_verified').val()==1){
							jQuery('#btn_register').attr('disabled',false);
						}
					}else{
						jQuery('#email_error').html('Please enter valid OTP');
					}
				}
				
			});
		}
	}
		
	function mobile_sent_otp(){
		jQuery('#mobile_error').html('');
		var mobile=jQuery('#mobile').val();
		if(mobile==''){
			jQuery('#mobile_error').html('Please enter mobile number');
		}else{
			jQuery('.mobile_sent_otp').html('Please wait..');
			jQuery('.mobile_sent_otp').attr('disabled',true);
			jQuery('.mobile_sent_otp');
			jQuery.ajax({
				url:'send_otp.php',
				type:'post',
				data:'mobile='+mobile+'&type=mobile',
				success:function(result){
					if(result=='done'){
						jQuery('#mobile').attr('disabled',true);
						jQuery('.mobile_verify_otp').show();
						jQuery('.mobile_sent_otp').hide();
					}else if(result=='mobile_present'){
						jQuery('.mobile_sent_otp').html('Send OTP');
						jQuery('.mobile_sent_otp').attr('disabled',false);
						jQuery('#mobile_error').html('Mobile number already exists');
					}else{
						jQuery('.mobile_sent_otp').html('Send OTP');
						jQuery('.mobile_sent_otp').attr('disabled',false);
						jQuery('#mobile_error').html('Please try after sometime');
					}
				}
			});
		}
	}

	function mobile_verify_otp(){
		jQuery('#mobile_error').html('');
		var mobile_otp=jQuery('#mobile_otp').val();
		if(mobile_otp==''){
			jQuery('#mobile_error').html('Please enter OTP');
		}else{
			jQuery.ajax({
				url:'check_otp.php',
				type:'post',
				data:'otp='+mobile_otp+'&type=mobile',
				success:function(result){
					if(result=='done'){
						jQuery('.mobile_verify_otp').hide();
						jQuery('#mobile_otp_result').html('Mobile number verified');
						jQuery('#is_mobile_verified').val('1');
						if(jQuery('#is_email_verified').val()==1){
							jQuery('#btn_register').attr('disabled',false);
						}
					}else{
						jQuery('#mobile_error').html('Please enter valid OTP');
					}
				}
				
			});
		}
	}
</script>

<?php require('footer.php')?>        