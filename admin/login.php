<?php
    require('connection.inc.php');
    require('function.inc.php');

    $msg='';
    if(isset($_POST['submit'])){
        $username=get_safe_value($con,$_POST['username']);
        $password=get_safe_value($con,$_POST['password']);
        
        $query = "SELECT * FROM admin_users WHERE username='$username' LIMIT 1";
        $result = mysqli_query($con, $query);
        $count=mysqli_num_rows($result);
        if($count > 0){
            $row=mysqli_fetch_assoc($result);
            if(password_verify($password, $row['password'])) {
               if($row['status'] == '0') {
                  $msg = "Account deactivated.";
               } else {
                  $_SESSION['ADMIN_LOGIN']='yes';
                  $_SESSION['ADMIN_ID']=$row['id'];
                  $_SESSION['ADMIN_USERNAME']=$username;
                  $_SESSION['ADMIN_ROLE']=$row['role'];
                  header('location:categories.php');
                  die();
               }
            } else {
               $msg = "Invalid login credentials.";
            }
        }else{
            $msg="Please enter correct login details.";	
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon" />

    <!-- normalize css cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />

    <!-- bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- fontawesome cdn css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css" />

    <title>E-Commerce || Login</title>
  </head>
  <body>

    <!-- start login section -->
    <div class="container mt-5">
      <div class="row">
        <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
            <h2 class="text-center mb-4">Login User</h2>
            <form method="post">
               <div class="mb-3">
               <label for="username" class="form-label">Username</label>
               <input type="text" class="form-control" id="username" name="username" required />
               </div>
               <div class="mb-3">
               <label for="password" class="form-label">Password</label>
               <input type="password" class="form-control" id="password" name="password" required />
               </div>
               <button type="submit" class="btn btn-lg btn-success" name="submit">Login</button>
            </form>
            <?php if(isset($msg) && $msg != '') { ?>
               <div class="alert alert-danger mt-4" role="alert">
                  <?php echo $msg; ?>
               </div>
            <?php } ?>
        </div>
      </div>
    </div>
    <!-- end login section -->

    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>