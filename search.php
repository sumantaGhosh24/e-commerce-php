<?php 
	require('top.php');

	$str=mysqli_real_escape_string($con,$_GET['str']);
	if($str!=''){
		$get_product=get_product($con,'','','',$str);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}										
?>

<!-- start search details section -->
<div class="container">
	<div class="row">
		<div class="col-8 offset-2 bg-white">
			<h2>Search <span class="text-primary"><?php echo $str; ?></span></h2>
		</div>
	</div>
</div>
<!-- end search details section -->

	<!-- start latest product section -->
	<div class="container mt-5 mb-5 bg-white rounded p-3">
		<?php if(count($get_product) > 0) { ?>
			<h4 class="fw-bold">Search Product</h4>
			<?php foreach($get_product as $list) { ?>
			<div class="d-flex justify-content-center row">
				<div class="col-md-10">
				<div class="row p-2 bg-white border rounded mt-2">
					<div class="col-md-3 mt-1">
						<a href="product.php?id=<?php echo $list['id']?>">
							<img class="img-fluid img-responsive rounded product-image"	src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$list['image']?>" alt="product" />
						</a>
					</div>
					<div class="col-md-6 mt-1">
						<h5><?php echo $list['name']; ?></h5>
						<!-- <div class="d-flex flex-row">
							<div class="ratings mr-2">
							<i class="fa fa-star"></i><i class="fa fa-star"></i
							><i class="fa fa-star"></i><i class="fa fa-star"></i>
							<i class="fa fa-star-half"></i>
							</div>
							<span>10</span>
						</div>
						<div class="mt-1 mb-1 spec-1">
							Lorem ipsum dolor sit amet consectetur, adipisicing elit.
							Repudiandae, natus.
						</div>
						<p class="text-justify text-truncate para mb-0">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat
							id earum aliquid ullam dicta voluptas laboriosam quis, numquam
							nobis ab. Lorem, ipsum dolor sit amet consectetur adipisicing
							elit. Aliquam, voluptatem!...<br /><br />
						</p> -->
					</div>
					<div class="align-items-center align-content-center	col-md-3 border-left mt-1">
						<div class="d-flex flex-row align-items-center">
							<h4 class="mr-1"><?php echo $list['mrp']; ?></h4>
							<span class="strike-text"><?php echo $list['price']; ?></span>
						</div>
						<h6 class="text-success">Free shipping</h6>
						<div class="d-flex flex-column mt-4">
							<a class="btn btn-danger btn-sm" href="#" onclick="wishlist_manage('<?php echo $list['id']?>', 'add')">
								<i class="fa fa-heart" aria-hidden="true"></i>
							</a>						
							<a class="btn btn-primary btn-sm" href="#" onclick="manage_cart('<?php echo $list['id']?>', 'add')">
								<i class="fa fa-cart-plus" aria-hidden="true"></i>
							</a>						
						</div>
					</div>
				</div>
				</div>
			</div>
			<?php } ?>
		<?php } else { ?>
			<p class="text-center fw-bold text-danger">Data not found!</p>
		<?php }  ?>
    </div>
	<input type="hidden" id="qty" value="1"/>
    <!-- end latest product section -->
	
<?php require('footer.php')?>        