<?php 
    require('top.php');

    if(!isset($_SESSION['USER_LOGIN'])){
        ?>
        <script>
            window.location.href='index.php';
        </script>
        <?php
    }
    $uid=$_SESSION['USER_ID'];

    $res=mysqli_query($con,"select product.name,product.image,product_attributes.price,product_attributes.mrp,product.id as pid,wishlist.id from product,wishlist,product_attributes where wishlist.product_id=product.id and wishlist.user_id='$uid' and product_attributes.product_id=product.id group by product_attributes.product_id");
?>

    <!-- start cart section -->
    <div class="container mt-5">
      <div class="contentbar">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
              <div class="card-header">
                <h5 class="card-title">Wishlist</h5>
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
                                <th scope="col">Remove</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td>
                                            <a href="#">
                                                <img src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$row['image']; ?>" />
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#"><?php echo $row['name']; ?></a>
                                            <ul>
                                                <li><?php echo $row['mrp']; ?></li>
                                                <li><?php echo $row['price']; ?></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="wishlist.php?wishlist_id=<?php echo $row['id']?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" onclick="manage_cart('<?php echo $row['pid']?>', 'add')">
                                                Add to Cart
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
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
                        <input type="hidden" id="qty" value="1"/>						
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