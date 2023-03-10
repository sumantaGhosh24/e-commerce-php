<?php 
	ob_start();
	require('top.php');

	if(isset($_GET['id'])){
		$product_id=mysqli_real_escape_string($con,$_GET['id']);
		if($product_id>0){
			$get_product=get_product($con,'','',$product_id);
		}else{
			?>
			<script>
			window.location.href='index.php';
			</script>
			<?php
		}
		
		$resMultipleImages=mysqli_query($con,"select product_images from product_images where product_id='$product_id'");
		$multipleImages=[];
		if(mysqli_num_rows($resMultipleImages)>0){
			while($rowMultipleImages=mysqli_fetch_assoc($resMultipleImages)){
				$multipleImages[]=$rowMultipleImages['product_images'];
			}
		}
		
		$resAttr=mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes 
		left join color_master on product_attributes.color_id=color_master.id and color_master.status=1 
		left join size_master on product_attributes.size_id=size_master.id and size_master.status=1
		where product_attributes.product_id='$product_id'");
		$productAttr=[];
		$colorArr=[];
		$sizeArr=[];
		if(mysqli_num_rows($resAttr)>0){
			while($rowAttr=mysqli_fetch_assoc($resAttr)){
				$productAttr[]=$rowAttr;
				$colorArr[$rowAttr['color_id']][]=$rowAttr['color'];
				$sizeArr[$rowAttr['size_id']][]=$rowAttr['size'];
				
				$colorArr1[]=$rowAttr['color'];
				$sizeArr1[]=$rowAttr['size'];
			}
		}
		$is_size=count(array_filter($sizeArr1));
		$is_color=count(array_filter($colorArr1));
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}

	if(isset($_POST['review_submit'])){
		$rating=get_safe_value($con,$_POST['rating']);
		$review=get_safe_value($con,$_POST['review']);
		
		$added_on=date('Y-m-d h:i:s');
		mysqli_query($con,"insert into product_review(product_id,user_id,rating,review,status,added_on) values('$product_id','".$_SESSION['USER_ID']."','$rating','$review','1','$added_on')");
		header('location:product.php?id='.$product_id);
		die();
	}

	$product_review_res=mysqli_query($con,"select users.name,product_review.id,product_review.rating,product_review.review,product_review.added_on from users,product_review where product_review.status=1 and product_review.user_id=users.id and product_review.product_id='$product_id' order by product_review.added_on desc");
?>

    <!-- start detailed product section -->
    <div class="container">
      <div class="card">
        <div class="container-fliud">
          <div class="wrapper row">
            <div class="preview col-md-6">
              <div class="preview-pic tab-content">
				<?php if(isset($multipleImages[0])) { ?>
					<?php
					$i = 1;
					foreach($multipleImages as $list) {
						echo "<div class='tab-pane ".$i == 1 ? 'active': ''."' id='pic-$i'><img src='".PRODUCT_MULTIPLE_IMAGE_SERVER_PATH.$list."' onclick=showMultipleImage('".PRODUCT_MULTIPLE_IMAGE_SERVER_PATH.$list."')></div>";
						$i++;
					}
					?>
				<?php } else { ?>
					<img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$get_product['0']['image']?>" alt="product" />
				<?php } ?>
              </div>
			  <?php if(isset($multipleImages[0])) { ?>
              <ul class="preview-thumbnail nav nav-tabs">
				<?php $i = 1;
				foreach($multipleImages as $list) {
					echo "
						<li class='".$i == 1 ? 'active' : ''."'>
							<a data-target='#pic-$i' data-toggle='tab'>
								<img src='".PRODUCT_MULTIPLE_IMAGE_SERVER_PATH>$list."' />
							</a>
						</li>
					";
					$i++;
				}
				?>
              </ul>
			  <?php } ?>
            </div>
            <div class="details col-md-6">
              	<h3 class="product-title"><?php echo $get_product['0']['name']?></h3>
			  	<div class="">
					<?php 
					$cart_show='yes';
					$is_cart_box_show="hide";
					if($is_color==0 && $is_size==0){
						$is_cart_box_show="";
					?>								
					<div class="">
						<?php
							$getProductAttr=getProductAttr($con,$get_product['0']['id']);
						
							$productSoldQtyByProductId=productSoldQtyByProductId($con,$get_product['0']['id'],$getProductAttr);
							
							$pending_qty=$get_product['0']['qty']-$productSoldQtyByProductId;
							
							$cart_show='yes';
							if($get_product['0']['qty']>$productSoldQtyByProductId){
								$stock='In Stock';			
							}else{
								$stock='Not in Stock';
								$cart_show='';
							}
						
						?>
						<p><span>Availability:</span> <?php echo $stock?></p>
					</div>
					<?php } ?>									
					<?php if($is_color>0){?>
					<div class="">
						<p><span>color:</span></p>
						<ul class="">
							<?php 
							foreach($colorArr as $key=>$val){
								echo "<li style='background:".$val[0]." none repeat scroll 0 0'><a href='javascript:void(0)' onclick=loadAttr('".$key."','".$get_product['0']['id']."','color')>".$val[0]."</a></li>";
							}
							?>
							
						</ul>
					</div>
					<?php } ?>									
					<?php if($is_size>0){?>
					<div class="">
						<p><span>size</span></p>
						<select class="" id="size_attr" onchange="showQty()">
							<option value="">Size</option>
							<?php 
							foreach($sizeArr as $key=>$val){
								echo "<option value='".$key."'>".$val[0]."</option>";
							}
							?>
							
						</select>
					</div>
					<?php } ?>									
					<?php
					$isQtyHide="hide";
					if($is_color==0 && $is_size==0){
						$isQtyHide="";
					}
					?>								
					<div class="<?php echo $isQtyHide?>" id="cart_qty">
						<?php
						if($cart_show!=''){
						?>
						<p><span>Qty:</span> 
						<select id="qty"  class="">
							<?php
							for($i=1;$i<=$pending_qty;$i++){
								echo "<option>$i</option>";
							}
							?>
						</select>
						</p>
						<?php } ?>
					</div>									
					<div id="cart_attr_msg"></div>					
						<div class="">
							<p><span>Categories:</span></p>
							<ul class="">
								<li><a href="#"><?php echo $get_product['0']['categories']?></a></li>
							</ul>
						</div>					
					</div>									
				</div>
				<p class="product-description">
					<?php echo $get_product['0']['short_desc']?>
				</p>
				<h4 class="price">Actual price: <span><?php echo $get_product['0']['mrp']?></span></h4>
				<h4 class="price">current price: <span><?php echo $get_product['0']['price']?></span></h4>
				<div class="action">
					<a href="#" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add')">Add to cart</a>				
					<a href="#" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','yes')">Buy Now</a>
				</div>
            </div>
			<input type="hidden" id="cid"/>
			<input type="hidden" id="sid"/>
          </div>
        </div>
      </div>
    </div>
    <!-- end detailed product section -->

	<!-- start review section -->
	<div class="container mt-5">
		<div class="row">
			<h4 class="text-center">Product Reviews</h4>
		</div>
		<div class="row mt-3">
			<div class="col-8 offset-2">
				<?php
				if(mysqli_num_rows($product_review_res) > 0) {
					while($product_review_row=mysqli_fetch_assoc($product_review_res)) {
				?>
					<article class="row">
						<div class="col-md-12 col-sm-12">
							<div class="panel panel-default arrow left">
								<div class="panel-body">
									<header class="text-left">
										<div>
											<span class="comment-rating"> <?php echo $product_review_row['rating']?></span> (<?php echo $product_review_row['name']?>)
										</div>
										<time class="comment-date"> 
											<?php
											$added_on=strtotime($product_review_row['added_on']);
											echo date('d M Y',$added_on);
											?>			
										</time>
									</header>
									<div class="comment-post">
										<p>
											<?php echo $product_review_row['review']?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</article>
				<?php }
				} else {
					echo "<h5 class='text-center'>No review added yet.</h3>";
				} ?>
			</div>
		</div>
		<div class="row mt-5">
			<h4 class="text-center">Enter your review</h4>
		</div>
		<div class="row mt-3">
			<?php if(isset($_SESSION['USER_LOGIN'])) { ?>
				<div class="col-8 offset-2">
					<form method="post">
						<div class="mb-3">
							<label for="rating" class="form-label">Rating</label>
							<select class="form-control" name="rating" required>
								<option value="">Select Rating</option>
								<option>Worst</option>
								<option>Bad</option>
								<option>Good</option>
								<option>Very Good</option>
								<option>Fantastic</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="review" class="form-label">Review</label>
							<textarea class="form-control" cols="50" id="review" name="review" placeholder="Enter you review" rows="5"></textarea>
						</div>
						<button class="btn btn-lg btn-success" t ype="submit" name="review_submit">Submit</button>
					</form>
				</div>
			<?php } else {
				echo "<span>Please <a href='login.php'>login</a> to submit your review.</span>";
			} ?>
		</div>
	</div>
	<!-- end review section -->
        
	<?php
		if(isset($_COOKIE['recently_viewed'])) {
			$arrRecentView=unserialize($_COOKIE['recently_viewed']);
			$countRecentView=count($arrRecentView);
			$countStartRecentView=$countRecentView-4;
			if($countStartRecentView>4){
				$arrRecentView=array_slice($arrRecentView,$countStartRecentView,4);
			}
			$recentViewId=implode(",",$arrRecentView);
			$res=mysqli_query($con,"select * from product where id IN ($recentViewId) and status=1");
			
	?>
		<div class="container">
			<div class="row">
				<h4 class="text-center">Recently Viewed</h4>
			</div>
			<div class="row mt-3">
				<?php while($list=mysqli_fetch_assoc($res)) { ?>
					<div class="col-xl-3 col-lg-4 col-md-6 col-10 offset-1">
						<div class="card">
							<a href="product.php?id=<?php echo $list['id']?>">
								<img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$list['image']?>" class="card-img-top" alt="product" />
							</a>
							<div class="card-body">
								<h5 class="card-title"><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h5>
								<p class="card-text">Actual Price : <?php echo $list['mrp']?></p>
								<p class="card-text">Current Price : <?php echo $list['price']?></p>
								<a href="#" class="btn btn-primary" onclick="wishlist_manage('<?php echo $list['id']?>', 'add')">
									<i class="fa fa-heart" aria-hidden="true"></i>
								</a>
								<a href="#" class="btn btn-success" onclick="manage_cart('<?php echo $list['id']?>', 'add')">
									<i class="fa fa-cart-plus" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php 
		$arrRec=unserialize($_COOKIE['recently_viewed']);
		if(($key=array_search($product_id,$arrRec))!==false){
			unset($arrRec[$key]);
		}
		$arrRec[]=$product_id;
	} else {
		$arrRec[]=$product_id;
	}
	setcookie('recently_viewed',serialize($arrRec),time()+60*60*24*365);
	?>
		
	<script>
		let is_color='<?php echo $is_color?>';
		let is_size='<?php echo $is_size?>';
		let pid='<?php echo $product_id?>';
	</script>

<?php 
	require('footer.php');
	ob_flush();
?>        