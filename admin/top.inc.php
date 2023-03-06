<?php
    require('connection.inc.php');
    require('function.inc.php');
    
    if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

    }else{
        header('location:login.php');
        die();
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

      <title>E-Commerce</title>
   </head>
   <body>
      <!-- start navbar section -->
      <nav class="navbar navbar-expand-lg bg-success">
         <div class="container">
         <a class="navbar-brand text-white fw-bold" href="index.php">ECOM</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item">
               <a class="nav-link text-white" aria-current="page" href="index.php">Home</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
                  <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="product.php">Product Master</a></li>
                     <li>
                        <?php if($_SESSION['ADMIN_ROLE']==1) {
                           echo '<a class="dropdown-item" href="order_master_vendor.php">Order Master</a>';
                        } else {
                           echo '<a class="dropdown-item" href="order_master.php">Order Master</a>';
                        } ?>
                     </li>
                     <li><hr class="dropdown-divider"></li>
                     <?php if($_SESSION['ADMIN_ROLE']!=1) { ?>
                        <li><a class="dropdown-item" href="product_review.php">Product Review</a></li>
                        <li><a class="dropdown-item" href="color.php">Color Master</a></li>
                        <li><a class="dropdown-item" href="size.php">Size Master</a></li>
                        <li><a class="dropdown-item" href="banner.php">Banner</a></li>
                        <li><a class="dropdown-item" href="vendor_management.php">Vendor Management</a></li>
                        <li><a class="dropdown-item" href="categories.php">Categories Master</a></li>
                        <li><a class="dropdown-item" href="sub_categories.php">Sub Categories Master</a></li>
                        <li><a class="dropdown-item" href="users.php">User Master</a></li>
                        <li><a class="dropdown-item" href="coupon_master.php">Coupon Master</a></li>
                        <li><a class="dropdown-item" href="contact_us.php">Contact Us</a></li>
                     <?php } ?>
                  </ul>
               </li>
            </ul>
         </div>
         </div>
      </nav>
      <!-- end navbar section -->

      <!-- start banner section -->
      <div class="container">
         <div class="row">
            <div class="col-10 offset-1">
               <div class="card">
                  <div class="card-header">
                     Featured
                  </div>
                  <div class="card-body">
                     <h5 class="card-title">Welcome <?php echo $_SESSION['ADMIN_USERNAME']; ?></h5>
                     <a href="logout.php" class="btn btn-primary">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end banner section -->
