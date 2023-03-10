<?php
	require('connection.inc.php');
	require('functions.inc.php');
	require('add_to_cart.inc.php');

	$wishlist_count=0;
	$cat_res=mysqli_query($con,"select * from categories where status=1 order by categories asc");
	$cat_arr=array();
	while($row=mysqli_fetch_assoc($cat_res)){
		$cat_arr[]=$row;	
	}

	$obj=new add_to_cart();
	$totalProduct=$obj->totalProduct();

	if(isset($_SESSION['USER_LOGIN'])){
		$uid=$_SESSION['USER_ID'];
		
		if(isset($_GET['wishlist_id'])){
			$wid=get_safe_value($con,$_GET['wishlist_id']);
			mysqli_query($con,"delete from wishlist where id='$wid' and user_id='$uid'");
		}

		$wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));	
	}

	$script_name=$_SERVER['SCRIPT_NAME'];
	$script_name_arr=explode('/',$script_name);
	$mypage=$script_name_arr[count($script_name_arr)-1];

	$meta_title="My Ecom Website";
	$meta_desc="My Ecom Website";
	$meta_keyword="My Ecom Website";
	$meta_url=SITE_PATH;
	$meta_image="";
	if($mypage=='product.php'){
		$product_id=get_safe_value($con,$_GET['id']);
		$product_meta=mysqli_fetch_assoc(mysqli_query($con,"select * from product where id='$product_id'"));
		$meta_title=$product_meta['meta_title'];
		$meta_desc=$product_meta['meta_desc'];
		$meta_keyword=$product_meta['meta_keyword'];
		$meta_url=SITE_PATH."product.php?id=".$product_id;
		$meta_image=PRODUCT_IMAGE_SITE_PATH.$product_meta['image'];
	}if($mypage=='contact.php'){
		$meta_title='Contact Us';
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

	<title><?php echo $meta_title?></title>

	<!-- product meta tags -->
	<meta name="description" content="<?php echo $meta_desc?>">
	<meta name="keywords" content="<?php echo $meta_keyword?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta property="og:title" content="<?php echo $meta_title?>"/>
	<meta property="og:image" content="<?php echo $meta_image?>"/>
	<meta property="og:url" content="<?php echo $meta_url?>"/>
	<meta property="og:site_name" content="<?php echo SITE_PATH?>"/>
  </head>
  <body>
    <!-- start navbar section -->
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">ECOM</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="index.php">Home</a>
				</li>
				<?php foreach($cat_arr as $list) { ?>					
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="categories.php?id=<?php echo $list['id']?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $list['categories'] ?>
					</a>
					<?php
					$cat_id=$list['id'];
					$sub_cat_res=mysqli_query($con,"select * from sub_categories where status='1' and categories_id='$cat_id'");
					if(mysqli_num_rows($sub_cat_res)>0) {
					?>					
					<ul class="dropdown-menu">
						<?php
						while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)) {
							echo '<li><a class="dropdown-item" href="categories.php?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'">'.$sub_cat_rows['sub_categories'].'</a></li>
						';
						}
						?>
					</ul>
					<?php } ?>
				</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
				<?php if(isset($_SESSION['USER_LOGIN'])) { ?>
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hi, <?php echo $_SESSION['USER_NAME']; ?></a>
					<ul class="dropdown-menu">
						<li><a href="my_order.php" class="dropdown-item">Order</a></li>
						<li><a href="profile.php" class="dropdown-item">Profile</a></li>
						<li><a href="logout.php" class="dropdown-item">Logout</a></li>
					</ul>
				</li>
				<?php } else { ?>
				<li class="nav-item">
					<a href="login.php" class="nav-link">Login/Register</a>
				</li>
				<?php } ?>
				<?php if(isset($_SESSION['USER_ID'])) { ?>
				<li class="nav-item">
					<a href="wishlist.php" class="nav-link"><i class="fa fa-heart" aria-hidden="true"></i></a>
				</li>
				<li class="nav-item">
					<a href="wishlist.php" class="nav-link"><?php echo $wishlist_count; ?></a>
				</li>
				<?php } ?>
				<li class="nav-item">
					<a href="cart.php" class="nav-link"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
				</li>
				<li class="nav-item">
					<a href="cart.php" class="nav-link"><?php echo $totalProduct; ?></a>
				</li>
			</ul>
			<form class="d-flex" role="search" action="search.php" method="get">
				<input class="form-control me-2" type="search" placeholder="Search product" aria-label="Search" name="str" />
				<button class="btn btn-outline-success" type="submit">Search</button>
			</form>
			</div>
		</div>
	</nav>
    <!-- end navbar section -->