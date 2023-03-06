<?php
    require('top.inc.php');

    isAdmin();

    $heading1='';
    $heading2='';
    $btn_txt='';
    $btn_link='';
    $image='';
    $msg='';
    $order_no=0;
    $image_required='required';
    
    if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_value($con,$_GET['id']);
        $image_required='';
        $res=mysqli_query($con,"SELECT * FROM banner WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $heading1=$row['heading1'];
            $heading2=$row['heading2'];
            $btn_txt=$row['btn_txt'];
            $btn_link=$row['btn_link'];
            $image=$row['image'];
            $order_no=$row['order_no'];
        }else{
            redirect('banner.php');
            die();
        }
    }

    if(isset($_POST['submit'])){
        $heading1=get_safe_value($con,$_POST['heading1']);
        $heading2=get_safe_value($con,$_POST['heading2']);
        $btn_txt=get_safe_value($con,$_POST['btn_txt']);
        $btn_link=get_safe_value($con,$_POST['btn_link']);
        $order_no=get_safe_value($con,$_POST['order_no']);
        
        if(isset($_GET['id']) && $_GET['id']==0){
            if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
                $msg="Please select only png, jpg and jpeg image formate";
            }
        }else{
            if($_FILES['image']['type']!=''){
                    if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
                    $msg="Please select only png, jpg and jpeg image formate";
                }
            }
        }
        
        $msg="";
        
        if($msg==''){
            if(isset($_GET['id']) && $_GET['id']!=''){
                if($_FILES['image']['name']!=''){
                    $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
                    imageCompress($_FILES['image']['tmp_name'], '../media/banner/'.$image);
                    mysqli_query($con,"UPDATE banner SET heading1='$heading1',heading2='$heading2',btn_txt='$btn_txt',btn_link='$btn_link',image='$image',order_no='$order_no' WHERE id='$id'");
                }else{
                    mysqli_query($con,"UPDATE banner SET heading1='$heading1',heading2='$heading2',btn_txt='$btn_txt',btn_link='$btn_link',order_no='$order_no'  WHERE id='$id'");
                }
            }else{
                $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
                imageCompress($_FILES['image']['tmp_name'],'../media/banner/'.$image);
                mysqli_query($con,"INSERT INTO banner(heading1,heading2,btn_txt,btn_link,image,status,order_no) VALUES('$heading1','$heading2','$btn_txt','$btn_link','$image','1','$order_no')");
            }
            redirect('banner.php');
            die();
        }
    }
?>

    <!-- start create banner section -->
    <div class="container mt-5">
      <div class="row">
        <div class="col-10 offset-1 bg-white p-4 rounded shadow-lg">
          <h2 class="text-center mb-4">Create Banner</h2>
          <form method="post" enctype="multipart/form-data">              
            <div class="mb-3">
                  <label for="heading1" class="form-label">Heading1</label>
                  <input type="text" class="form-control" id="heading1" name="heading1" placeholder="Enter heading1" required value="<?php echo $heading1; ?>" />
            </div>
            <div class="mb-3">
                <label for="heading2" class="form-label">Heading2</label>
                <input type="text" class="form-control" id="heading2" name="heading2" placeholder="Enter heading2" required value="<?php echo $heading2; ?>" />
            </div>
            <div class="mb-3">
                <label for="btn_txt" class="form-label">button Text</label>
                <input type="text" class="form-control" id="btn_txt" name="btn_txt" placeholder="Enter button text" required value="<?php echo $btn_txt; ?>" />
            </div>
            <div class="mb-3">
                <label for="btn_link" class="form-label">button Link</label>
                <input type="text" class="form-control" id="btn_link" name="btn_link" placeholder="Enter button link" required value="<?php echo $btn_link; ?>" />
            </div>                
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control form-control-lg" id="image" type="file" name="image" <?php echo $image_required; ?> value="<?php echo $image; ?>" />
                <?php
                    if($image != '') {
                        echo "<a target='_blank' href='".BANNER_SERVER_PATH.$image."'><img width='150px' src='".BANNER_SERVER_PATH.$image."'/></a>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label from="order_no" class="form-label">Order No</label>
                <input class="form-control" type="text" name="order_no" id="order_no" placeholder="Enter order no" value="<?php echo $order_no; ?>" />
            </div>
            <button type="submit" class="btn btn-lg btn-success" name="submit">
              Create Banner
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
    <!-- end create banner section -->
         
<?php require('footer.inc.php'); ?>