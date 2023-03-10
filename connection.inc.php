<?php
    session_start();
    $con=mysqli_connect("localhost","root","","ecomm");

    define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/php/ecommerce/');
    define('SITE_PATH','http://127.0.0.1/php/ecommerce/');

    define('INSTAMOJO_REDIRECT',SITE_PATH.'payment_complete.php');

    define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
    define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');

    define('PRODUCT_MULTIPLE_IMAGE_SERVER_PATH',SERVER_PATH.'media/product_images/');
    define('PRODUCT_MULTIPLE_IMAGE_SITE_PATH',SITE_PATH.'media/product_images/');

    define('BANNER_SERVER_PATH',SERVER_PATH.'media/banner/');
    define('BANNER_SITE_PATH',SITE_PATH.'media/banner/');

    define('INSTAMOJO_KEY','key');
    define('INSTAMOJO_TOKEN','token');

    define('SMTP_EMAIL','email@gmail.com');
    define('SMTP_PASSWORD','password');

    define('SMS_KEY','sms_key');
?>