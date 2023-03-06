<?php
    require('top.inc.php');

    isAdmin();

    $coupon_code='';
    $coupon_type='';
    $coupon_value='';
    $cart_min_value='';

    $msg='';
    if(isset($_GET['id']) && $_GET['id']!=''){
        $image_required='';
        $id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM coupon_master WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $coupon_code=$row['coupon_code'];
            $coupon_type=$row['coupon_type'];
            $coupon_value=$row['coupon_value'];
            $cart_min_value=$row['cart_min_value'];
        }else{
            redirect('coupon_master.php');
            die();
        }
    }

    if(isset($_POST['submit'])){
        $coupon_code=get_safe_value($con,$_POST['coupon_code']);
        $coupon_type=get_safe_value($con,$_POST['coupon_type']);
        $coupon_value=get_safe_value($con,$_POST['coupon_value']);
        $cart_min_value=get_safe_value($con,$_POST['cart_min_value']);
        
        $res=mysqli_query($con,"SELECT * FROM coupon_master WHERE coupon_code='$coupon_code'");
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){
                
                }else{
                    $msg="Coupon code already exist";
                }
            }else{
                $msg="Coupon code already exist";
            }
        }        
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $update_sql="UPDATE coupon_master SET coupon_code='$coupon_code',coupon_value='$coupon_value',coupon_type='$coupon_type',cart_min_value='$cart_min_value' WHERE id='$id'";
                mysqli_query($con,$update_sql);
            }else{
                mysqli_query($con,"INSERT INTO coupon_master(coupon_code,coupon_value,coupon_type,cart_min_value,status) VALUES('$coupon_code','$coupon_value','$coupon_type','$cart_min_value',1)");
            }
            redirect('coupon_master.php');
            die();
        }
    }
?>

    <!-- start create coupon section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
                <h2 class="text-center mb-4">Create Coupon</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="coupon_code" class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter coupon code" required value="<?php echo $coupon_code; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="coupon_value" class="form-label">Coupon Value</label>
                        <input type="text" class="form-control" id="coupon_value" name="coupon_value" placeholder="Enter coupon value" required value="<?php echo $coupon_value; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="coupon_type" class="form-label">Coupon Type</label>
                        <select class="form-select" aria-label="Default select example" id="coupon_type" name="coupon_type" required>
                            <option value="">Select One</option>
                            <?php
                                if($coupon_type=='Percentage'){
                                    echo '<option value="Percentage" selected>Percentage</option>
                                        <option value="Rupee">Rupee</option>';
                                }elseif($coupon_type=='Rupee'){
                                    echo '<option value="Percentage">Percentage</option>
                                        <option value="Rupee" selected>Rupee</option>';
                                }else{
                                    echo '<option value="Percentage">Percentage</option>
                                        <option value="Rupee">Rupee</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cart_min_value" class="form-label">Cart Minimum Value</label>
                        <input type="text" name="cart_min_value" id="cart_min_value" class="form-control" placeholder="Enter cart minimum value" required value="<?php echo $cart_min_value; ?>" />
                    </div>
                    <button type="submit" class="btn btn-lg btn-success" name="submit">
                        Create Coupon
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
    <!-- end create coupon section -->	 
         
<?php require('footer.inc.php'); ?>