<?php
    require('top.inc.php');

    isAdmin();

    $size='';
    $order_by='0';
    $msg='';

    if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM size_master WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $size=$row['size'];
            $order_by=$row['order_by'];
        }else{
            redirect('size.php');
        }
    }

    if(isset($_POST['submit'])){
        $size=get_safe_value($con,$_POST['size']);
        $order_by=get_safe_value($con,$_POST['order_by']);
        $res=mysqli_query($con,"SELECT * FROM size_master WHERE size='$size'");
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){
                
                }else{
                    $msg="Size already exist";
                }
            }else{
                $msg="Size already exist";
            }
        }
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                mysqli_query($con,"UPDATE size_master SET size='$size',order_by='$order_by' WHERE id='$id'");
            }else{
                mysqli_query($con,"INSERT INTO size_master(size,order_by,status) VALUES('$size','$order_by','1')");
            }
            redirect('size.php');
        }
    }
?>

    <!-- start size section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
                <h2 class="text-center mb-4">Create Size</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <input type="text" id="size" name="size" placeholder="Enter size name" class="form-control" required value="<?php echo $size; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="order_by" class="form-label">Order By</label>
                        <input type="text" id="order_by" name="order_by" placeholder="Enter order by" class="form-control" required value="<?php echo $order_by; ?>" />
                    </div>
                    <button type="submit" name="submit" class="btn btn-lg btn-success">
                        Create Size
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
    <!-- end size section -->
         
<?php require('footer.inc.php'); ?>