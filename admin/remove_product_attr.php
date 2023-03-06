<?php
    require('connection.inc.php');
    require('functions.inc.php');

    if(isset($_POST['id'])){
        if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

        }else{
            redirect('login.php');
            die();
        }

        $id=get_safe_value($con,$_POST['id']);
        mysqli_query($con,"DELETE FROM product_attributes WHERE id='$id'");
    }
?>