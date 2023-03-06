<?php
    require('top.inc.php');

    isAdmin();

    $username='';
    $password='';
    $email='';
    $mobile='';
    $msg='';

    if(isset($_GET['id']) && $_GET['id']!=''){
        $image_required='';
        $id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM admin_users WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $username=$row['username'];
            $email=$row['email'];
            $mobile=$row['mobile'];
            $password=$row['password'];
        }else{
            redirect('vendor_management.php');
            die();
        }
    }

    if(isset($_POST['submit'])){
        $username=get_safe_value($con,$_POST['username']);
        $email=get_safe_value($con,$_POST['email']);
        $mobile=get_safe_value($con,$_POST['mobile']);
        $password=get_safe_value($con,$_POST['password']);
        
        $res=mysqli_query($con,"SELECT * FROM admin_users WHERE username='$username'");
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){
                
                }else{
                    $msg="Username already exist";
                }
            }else{
                $msg="Username already exist";
            }
        }	
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $update_sql="UPDATE admin_users SET username='$username',password='$password',email='$email',mobile='$mobile' WHERE id='$id'";
                mysqli_query($con,$update_sql);
            }else{
                mysqli_query($con,"insert into admin_users(username,password,email,mobile,role,status) values('$username','$password','$email','$mobile',1,1)");
            }
            redirect('vendor_management.php');
            die();
        }
    }
?>

    <!-- start create vendor section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
                <h2 class="text-center mb-4">Create Vendor</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" placeholder="Enter vendor username" class="form-control" required value="<?php echo $username; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter vendor password" class="form-control" require value="<?php echo $password; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" placeholder="Enter vendor email" class="form-control" required value="<?php echo $email; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" name="mobile" id="mobile" placeholder="Enter vendor mobile" class="form-control" required value="<?php echo $mobile; ?>" />
                    </div>
                    <button type="submit" name="submit" class="btn btn-lg btn-success">
                        Create Vendor
                    </button>
                    <?php if(isset($msg) && $msg != '') { ?>
                        <div class="alert alert-danger mt-4" role="alert">
                            <?php echo $msg; ?>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <!-- end create vendor section -->		 
         
<?php require('footer.inc.php'); ?>