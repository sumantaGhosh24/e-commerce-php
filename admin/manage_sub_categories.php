<?php
    require('top.inc.php');

    isAdmin();

    $categories='';
    $msg='';
    $sub_categories='';

    if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM sub_categories WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $sub_categories=$row['sub_categories'];
            $categories=$row['categories_id'];
        }else{
            redirect('sub_categories.php');
            die();
        }
    }

    if(isset($_POST['submit'])){
        $categories=get_safe_value($con,$_POST['categories_id']);
        $sub_categories=get_safe_value($con,$_POST['sub_categories']);
        $res=mysqli_query($con,"SELECT * FROM sub_categories WHERE categories_id='$categories' AND sub_categories='$sub_categories'");
        $check=mysqli_num_rows($res);
        if($check>0){
            if(isset($_GET['id']) && $_GET['id']!=''){
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id']){
                
                }else{
                    $msg="Sub Categories already exist";
                }
            }else{
                $msg="Sub Categories already exist";
            }
        }
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                mysqli_query($con,"UPDATE sub_categories SET categories_id='$categories',sub_categories='$sub_categories' WHERE id='$id'");
            }else{
                
                mysqli_query($con,"INSERT INTO sub_categories(categories_id,sub_categories,status) VALUES('$categories','$sub_categories','1')");
            }
            redirect('sub_categories.php');
            die();
        }
    }
?>

    <!-- start create sub categories section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
                <h2 class="text-center mb-4">Create Sub Categories</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="categories_id" class="form-label">Categories</label>
                        <select class="form-select" id="categories_id" name="categories_id" required>
                            <option value="">Select Categories</option>
                            <?php
                            $res = mysqli_query($con, "SELECT * FROM categories WHERE status='1'");
                            while($row=mysqli_fetch_assoc($res)) {
                                if($row['id'] == $categories) {
                                    echo "<option value=".$row['id']." selected>".$row['categories']."</option>";
                                } else {
                                    echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_categories" class="form-label">Sub Categories</label>
                        <input type="text" id="sub_categories" name="sub_categories" placeholder="Enter sub categories" class="form-control" required value="<?php echo $sub_categories; ?>" />
                    </div>
                    <button type="submit" name="submit" class="btn btn-lg btn-success">
                        Create Sub Categories
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
    <!-- end create sub categories section -->
         
<?php require('footer.inc.php'); ?>