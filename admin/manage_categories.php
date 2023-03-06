<?php
    require('top.inc.php');

    isAdmin();

    $categories='';
    $msg='';

    if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM categories WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $categories=$row['categories'];
        }else{
            redirect('categories.php');
            die();
        }
    }

    if(isset($_POST['submit'])){
        $categories=get_safe_value($con,$_POST['categories']);
        $res=mysqli_query($con,"SELECT * FROM categories WHERE categories='$categories'");
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){
                
                }else{
                    $msg="Categories already exist";
                }
            }else{
                $msg="Categories already exist";
            }
        }
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                mysqli_query($con,"UPDATE categories SET categories='$categories' WHERE id='$id'");
            }else{
                mysqli_query($con,"INSERT INTO categories(categories,status) VALUES('$categories','1')");
            }
            redirect('categories.php');
            die();
        }
    }
?>

    <!-- start create categories section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
                <h2 class="text-center mb-4">Create Categories</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="categories" class="form-label">Categories</label>
                        <input type="text" class="form-control" id="categories" name="categories" placeholder="Enter categories name" required value="<?php echo $categories; ?>" />
                    </div>
                    <button type="submit" name="submit" class="btn btn-lg btn-success">
                        Create Categories
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
    <!-- end create categories section -->
         
<?php require('footer.inc.php'); ?>