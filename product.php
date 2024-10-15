<?php require "./includes/header.php"; ?>

<?php
if (!isset($_SESSION["USER_ID"])) {
    header("Location: login.php");
    die();
}
?>

<?php
if (!isset($_GET["id"])) {
    echo "There is something wrong, try again later.";
    die();
}
?>

<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div class="bg-white min-h-screen">
    <br><br>
    <div class="container mx-auto">
        <div class="bg-white shadow-md shadow-black p-5 rounded space-y-5">
            <h1 id="title" class="text-2xl font-bold capitalize"></h1>
            <h2 id="short_desc" class="text-xl font-semibold capitalize"></h2>
            <div class="w-full relative">
                <div class="swiper default-carousel swiper-container">
                    <div class="swiper-wrapper" id="slides"></div>
                    <div class="flex items-center gap-8 lg:justify-start justify-center">
                        <button id="slider-button-left"
                            class="swiper-button-prev group !p-2 flex justify-center items-center border border-solid border-blue-600 !w-12 !h-12 transition-all duration-500 rounded-full !top-2/4 !-translate-y-8 !left-5 hover:bg-blue-600 "
                            data-carousel-prev>
                            <svg class="h-5 w-5 text-blue-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button id="slider-button-right"
                            class="swiper-button-next group !p-2 flex justify-center items-center border border-solid border-blue-600 !w-12 !h-12 transition-all duration-500 rounded-full !top-2/4 !-translate-y-8  !right-5 hover:bg-blue-600"
                            data-carousel-next>
                            <svg class="h-5 w-5 text-blue-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <h3 id="description" class="text-md text-gray-500"></h3>
            <h3 id="price" class="font-bold"></h3>
            <div id="attributes" class="flex items-center gap-3"></div>
            <div class="flex items-center gap-3">
                <h3 id="best_seller"></h3>
                <h3 id="category" class="px-3 py-1.5 bg-blue-600 text-white rounded-full uppercase text-xs"></h3>
                <h3 id="sub_category" class="px-3 py-1.5 bg-blue-600 text-white rounded-full uppercase text-xs"></h3>
            </div>
            <div class="flex items-center justify-between">
                <h3 id="createdAt"></h3>
                <h3 id="updatedAt"></h3>
            </div>
            <h1 class="text-3xl font-semibold mb-5 text-black">Create Review</h1>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <form class="mb-6" id="create_review_form">
                <div class="mb-4">
                    <label for="rating" class="text-black">Review Rating:</label>
                    <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                        placeholder="Enter review rating (1 to 5)" name="rating" id="rating" />
                </div>
                <div class="mb-4">
                    <label for="review" class="text-black">Review Message:</label>
                    <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                        placeholder="Enter comment message" name="review" id="review" />
                </div>
                <input type="hidden" name="product_id" value=<?php echo $_GET["id"]; ?> />
                <input type="hidden" name="action" value="create" />
                <button type="submit" id="create_review_submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200 w-fit">Create
                    Review</button>
            </form>
            <div id="reviews"></div>
        </div>
    </div>
    <br><br>
</div>

<script>
    $(document).ready(function () {
        function fetchProduct() {
            $.ajax({
                url: "http://localhost:3000/includes/product.php?id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var product = $.parseJSON(result);

                    $("#title").text(product.title);
                    $("#short_desc").text(product.short_desc);
                    $("#description").text(product.description);
                    $("#price").html(`₹${product.price} / <del class='font-medium'>₹${product.mrp}</del>`);
                    $("#best_seller").html(product.best_seller == 1 && "<span class='px-3 py-1.5 bg-blue-600 text-white rounded-full uppercase text-xs'>best seller</span>");
                    $("#category").html(product.category.name);
                    $("#sub_category").html(product.sub_category.name);
                    $("#createdAt").html(`Created At: ${product.createdAt}`);
                    $("#updatedAt").html(`Updated At: ${product.updatedAt}`);

                    product.images.forEach(product => {
                        $("#slides").append(`
                        <div class="swiper-slide">
                            <div class="h-96 flex flex-col justify-center items-center gap-5" style="background: url(../uploads/${product.image}) center center/cover no-repeat;"></div>
                        </div>
                        `);
                    })

                    $("#attributes").html("");

                    product.attributes.forEach(attribute => {
                        $("#attributes").append(`
                        <form class="add_cart_form space-y-3 bg-gray-300 p-3 rounded w-full">
                            <h3>₹${attribute.price} / <del class='font-medium'>₹${attribute.mrp}</del></h3>
                            <div class="flex items-center gap-3">
                                <h3 class="px-3 py-1.5 bg-blue-600 text-white rounded-full uppercase text-xs">${attribute.size_name}</h3>
                                <h3 class="px-3 py-1.5 bg-blue-600 text-white rounded-full uppercase text-xs">${attribute.color_name}</h3>
                            </div>
                            <input type="number" min="1" max="${attribute.qty}" name="quantity" placeholder="add product quantity" class="w-full px-4 py-2 rounded-md border border-gray-300" required />
                            <br />
                            <input type="hidden" name="product_id" value="${product.id}" />
                            <input type="hidden" name="attribute_id" value="${attribute.id}" />
                            <input type="hidden" name="action" value="add" />
                            <button type="submit" class="w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">Add Cart</button>
                        </form>
                        `);
                    })
                }
            })
        }

        fetchProduct();

        var swiper = new Swiper(".default-carousel", {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        $(document).on("submit", ".add_cart_form", function (e) {
            e.preventDefault();

            let form = $(this);
            let button = form.find("button[type='submit']");

            button.attr("disabled", true).text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/cart.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false).text("Add Cart");

                    alert("Product added to cart");
                }
            });
        });

        function fetchReviews() {
            $.ajax({
                url: "http://localhost:3000/includes/review.php?user=true&id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#reviews").html("");

                    if (data.length > 0) {
                        data.forEach(review => {
                            $("#reviews").append(`
                                <div class='bg-gray-200 p-3 my-4 rounded space-y-3'>
                                    <h2 class='text-2xl font-bold'>Rating: ${review.rating}</h2>
                                    <h2 class='text-xl font-bold capitalize'>${review.review}</h2>
                                    <h4>User name: ${review.user_name}</h4>
                                    <h4>User email: ${review.user_email}</h4>
                                    <h5 class='text-xs font-light'>${review.createdAt}</h5>
                                </div>
                            `);
                        })
                    } else {
                        $("#reviews").html("<p class='font-extrabold text-2xl p-3'>No reviews found.</p>")
                    }
                }
            })
        }

        fetchReviews();

        $("#create_review_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#create_review_submit").attr("disabled", true);
            $("#create_review_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/includes/review.php",
                type: "post",
                data: $("#create_review_form").serialize(),
                success: function (result) {
                    $("#create_review_submit").attr("disabled", false);
                    $("#create_review_submit").text("Create Review");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#create_review_form")[0].reset();
                        fetchReviews();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>