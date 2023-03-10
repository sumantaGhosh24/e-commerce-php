<?php 
    require('top.php');

    $resBanner=mysqli_query($con,"select * from banner where status='1' order by order_no asc");
?>

<!-- start slider section -->
<?php if(mysqli_num_rows($resBanner) > 0) { ?>
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <?php while($rowBanner = mysqli_fetch_assoc($resBanner)) {?>
                <div class="carousel-item active">
                    <h2><?php echo $rowBanner['heading1'] ?></h2>
                    <h2><?php echo $rowBanner['heading2'] ?></h2>
                    <?php
                    if($rowBanner['btn_txt'] != '' && $rowBanner['btn_link'] != '') {
                        ?>
                        <a href="<?php echo $rowBanner['btn_link']?>"><?php echo $rowBanner['btn_txt']?></a>
                        <?php
                    }
                    ?>
                    <img src="<?php echo BANNER_SITE_PATH.$rowBanner['image']?>" class="d-block w-100" alt="banner">
                </div>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<?php } ?>
<!-- end slider section -->

<!-- start new product section -->
<div class="container mt-5 mb-5 bg-white rounded p-3">
    <h4 class="fw-bold">New Product</h4>
    <div class="d-flex justify-content-center row">
        <div class="col-md-10">
            <?php
            $get_product = get_product($con, 4);
            foreach($get_product as $list) {
            ?>
            <div class="row p-2 bg-white border rounded mt-2">
                <div class="col-md-3 mt-1">
                    <img class="img-fluid img-responsive rounded product-image" src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$list['image']?>" alt="product" />
                </div>
                <div class="col-md-6 mt-1">
                    <h5><?php echo $list['name']?></h5>
                    <!-- <div class="mt-1 mb-1 spec-1">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    Repudiandae, natus.
                    </div>
                    <p class="text-justify text-truncate para mb-0">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat
                    id earum aliquid ullam dicta voluptas laboriosam quis, numquam
                    nobis ab. Lorem, ipsum dolor sit amet consectetur adipisicing
                    elit. Aliquam, voluptatem!...<br /><br />
                    </p> -->
                </div>
                <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                    <div class="d-flex flex-row align-items-center">
                        <h4 class="mr-1"><?php echo $list['mrp']?></h4>
                        <span class="strike-text"><?php echo $list['price']?></span>
                    </div>
                    <h6 class="text-success">Free shipping</h6>
                    <div class="d-flex flex-column mt-4">
                        <a class="btn btn-success btn-sm" href="product.php?id=<?php echo $list['id']?>">Details</a>
                        <a href="#" onclick="wishlist_manage('<?php echo $list['id']?>', 'add')" class="btn btn-outline-success btn-sm mt-2">
                            Add to Wishlist
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- end new product section -->

<!-- start best seller product section -->
<div class="container mt-5 mb-5 bg-white rounded p-3">
    <h4 class="fw-bold">Best Selleer Product</h4>
    <div class="d-flex justify-content-center row">
        <div class="col-md-10">
            <?php
            $get_product = get_product($con, 4, '', '', '', '', 'yes');
            foreach($get_product as $list) {
            ?>
            <div class="row p-2 bg-white border rounded mt-2">
                <div class="col-md-3 mt-1">
                    <img class="img-fluid img-responsive rounded product-image" src="<?php echo PRODUCT_IMAGE_SERVER_PATH.$list['image']?>" alt="product" />
                </div>
                <div class="col-md-6 mt-1">
                    <h5><?php echo $list['name']?></h5>
                    <!-- <div class="mt-1 mb-1 spec-1">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    Repudiandae, natus.
                    </div>
                    <p class="text-justify text-truncate para mb-0">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat
                    id earum aliquid ullam dicta voluptas laboriosam quis, numquam
                    nobis ab. Lorem, ipsum dolor sit amet consectetur adipisicing
                    elit. Aliquam, voluptatem!...<br /><br />
                    </p> -->
                </div>
                <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                    <div class="d-flex flex-row align-items-center">
                        <h4 class="mr-1"><?php echo $list['mrp']?></h4>
                        <span class="strike-text"><?php echo $list['price']?></span>
                    </div>
                    <h6 class="text-success">Free shipping</h6>
                    <div class="d-flex flex-column mt-4">
                        <a class="btn btn-success btn-sm" href="product.php?id=<?php echo $list['id']?>">Details</a>
                        <a href="#" onclick="wishlist_manage('<?php echo $list['id']?>', 'add')" class="btn btn-outline-success btn-sm mt-2">
                            Add to Wishlist
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- end best seller product section -->

<input type="hidden" id="qty" value="1"/>

<?php require('footer.php')?>        