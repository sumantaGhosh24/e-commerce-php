<?php
    require('top.inc.php');

    isAdmin();

    $color='';
    $msg='';

    if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM color_master WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $color=$row['color'];
        }else{
            redirect('color.php');
        }
    }

    if(isset($_POST['submit'])){
        $color=get_safe_value($con,$_POST['color']);
        $res=mysqli_query($con,"SELECT * FROM color_master WHERE color='$color'");
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){
                
                }else{
                    $msg="Color already exist";
                }
            }else{
                $msg="Color already exist";
            }
        }
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                mysqli_query($con,"UPDATE color_master SET color='$color' WHERE id='$id'");
            }else{
                mysqli_query($con,"INSERT INTO color_master(color,status) VALUES('$color','1')");
            }
            redirect('color.php');
        }
    }
?>

    <!-- start create color section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
                <h2 class="text-center mb-4">Create Color</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder="Enter color name" required value="<?php echo $color; ?>" />
                    </div>
                    <button type="submit" name="submit" class="btn btn-lg btn-success">
                        Create Color
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
    <!-- end create color section -->
         
<?php require('footer.inc.php'); ?>