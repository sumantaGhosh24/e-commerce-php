<?php require('top.php'); ?>

    <!-- start cart section -->
    <div class="container mt-5">
      <div class="contentbar">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
              <div class="card-header">
                <h5 class="card-title">Product Cart</h5>
              </div>
              <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-lg-10 col-xl-8">
                    <div class="cart-container">
                      <div class="cart-head">
                        <div class="table-responsive">
                          <table class="table table-borderless">
                            <thead>
                              <tr>
                                <th scope="col">Products</th>
                                <th scope="col">Name of Products</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Remove</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($_SESSION['cart'])){
                                foreach($_SESSION['cart'] as $key=>$val) {											
                                    foreach($val as $key1=>$val1) {
                                        $resAttr=mysqli_fetch_assoc(mysqli_query($con,"select product_attributes.*,color_master.color,size_master.size from product_attributes left join color_master on product_attributes.color_id=color_master.id and color_master.status=1 left join size_master on product_attributes.size_id=size_master.id and size_master.status=1 where product_attributes.id='$key1'"));
												
                                        $productArr=get_product($con,'','',$key,'','','','',$key1);
                                        $pname=$productArr[0]['name'];
                                        $mrp=$productArr[0]['mrp'];
                                        $price=$productArr[0]['price'];
                                        $image=$productArr[0]['image'];
                                        $qty=$val1['qty'];
                            ?>
                                        <tr>
                                            <td>
                                                <a href="#">
                                                    <img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$image?>" class="img-fluid" width="35" alt="product" />
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#"><?php echo $pname?></a>
                                                <?php
                                                if(isset($resAttr['color']) && $resAttr['color']!=''){
                                                    echo "<br/>".$resAttr['color'].''; 
                                                }
                                                if(isset($resAttr['size']) && $resAttr['size']!=''){
                                                    echo "<br/>".$resAttr['size'].''; 
                                                }
                                                ?>				
					                            <ul>
                                                    <li><?php echo $mrp?></li>
                                                    <li><?php echo $price?></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <span><?php echo $price?></span>
                                            </td>
                                            <td>
                                                <input type="number" id="<?php echo $key?>qty" value="<?php echo $qty?>" />
												<br/>
                                                <a href="#" onclick="manage_cart_update('<?php echo $key?>','update','<?php echo $resAttr['size_id']?>','<?php echo $resAttr['color_id']?>')">update</a>
                                            </td>
                                            <td><?php echo $qty*$price?></td>
                                            <td>
                                                <a href="#" onclick="manage_cart_update('<?php echo $key?>','remove','<?php echo $resAttr['size_id']?>','<?php echo $resAttr['color_id']?>')"><i class="icon-trash icons"></i></a>
                                            </td>
                                        </tr>
                            <?php } } } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="cart-footer text-right">
                        <button type="button" class="text-white btn btn-info my-1">
                          Update Cart
                        </button>
                        <a href="<?php echo SERVER_PATH?>" class="btn btn-success my-1">Continue Shopping</a>
                        <a href="<?php echo SERVER_PATH?>checkout.php" class="btn btn-success my-1">Checkout</a>
                        <input type="hidden" id="sid">
                        <input type="hidden" id="cid">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end cart section -->		
										
<?php require('footer.php')?>        