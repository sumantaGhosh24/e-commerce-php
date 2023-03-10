<?php 
	require('top.php');

	if(!isset($_GET['id']) && $_GET['id']!=''){
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}

	$cat_id=mysqli_real_escape_string($con,$_GET['id']);

	$sub_categories='';
	if(isset($_GET['sub_categories'])){
		$sub_categories=mysqli_real_escape_string($con,$_GET['sub_categories']);
	}
	$price_high_selected="";
	$price_low_selected="";
	$new_selected="";
	$old_selected="";
	$sort_order="";
	if(isset($_GET['sort'])){
		$sort=mysqli_real_escape_string($con,$_GET['sort']);
		if($sort=="price_high"){
			$sort_order=" order by product.price desc ";
			$price_high_selected="selected";	
		}if($sort=="price_low"){
			$sort_order=" order by product.price asc ";
			$price_low_selected="selected";
		}if($sort=="new"){
			$sort_order=" order by product.id desc ";
			$new_selected="selected";
		}if($sort=="old"){
			$sort_order=" order by product.id asc ";
			$old_selected="selected";
		}

	}

	if($cat_id>0){
		$get_product=get_product($con,'',$cat_id,'','',$sort_order,'',$sub_categories);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}										
?>

<!-- Start Product Grid -->
<section class="">
	<div class="container">
		<div class="row">
			<?php if(count($get_product)>0) {?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="">
					<div class="">
						<div class="">
							<select class="form-select" onchange="sort_product_drop('<?php echo $cat_id?>','<?php echo SITE_PATH?>')" id="sort_product_id">
								<option value="">Default sorting</option>
								<option value="price_low" <?php echo $price_low_selected?>>Sort by price low to hight</option>
								<option value="price_high" <?php echo $price_high_selected?>>Sort by price high to low</option>
								<option value="new" <?php echo $new_selected?>>Sort by new first</option>
								<option value="old" <?php echo $old_selected?>>Sort by old first</option>
							</select>
						</div>						
					</div>
					<div class="row">
						<div class="">
							<div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
								<?php foreach($get_product as $list) { ?>
								<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
									<div class="category">
										<div class="">
											<a href="product.php?id=<?php echo $list['id']?>">
												<img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
											</a>
										</div>
										<div class="">
											<ul class="">
												<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
												<li><a href="product.php?id=<?php echo $list['id']?>"><i class="icon-handbag icons"></i></a></li>
											</ul>
										</div>
										<div class="">
											<h4><a href="product-details.html"><?php echo $list['name']?></a></h4>
											<ul class="">
												<li class=""><?php echo $list['mrp']?></li>
												<li><?php echo $list['price']?></li>
											</ul>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } else { 
				echo "Data not found";
			} ?>		
		</div>
	</div>
</section>
<input type="hidden" id="qty" value="1"/>

<?php require('footer.php')?>        