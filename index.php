<?php require "./includes/header.php"; ?>

<?php
if (!isset($_SESSION["USER_ID"])) {
    header("Location: login.php");
    die();
}
?>

<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    .swiper-wrapper {
        width: 100%;
        height: max-content !important;
        padding-bottom: 64px !important;
        -webkit-transition-timing-function: linear !important;
        transition-timing-function: linear !important;
        position: relative;
    }

    .swiper-pagination-bullet {
        background: #4f46e5;
    }
</style>


<div class="w-full relative">
    <div class="swiper default-carousel swiper-container">
        <div class="swiper-wrapper" id="slides"></div>
        <div class="flex items-center gap-8 lg:justify-start justify-center">
            <button id="slider-button-left"
                class="swiper-button-prev group !p-2 flex justify-center items-center border border-solid border-blue-600 !w-12 !h-12 transition-all duration-500 rounded-full !top-2/4 !-translate-y-8 !left-5 hover:bg-blue-600 "
                data-carousel-prev>
                <svg class="h-5 w-5 text-blue-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button id="slider-button-right"
                class="swiper-button-next group !p-2 flex justify-center items-center border border-solid border-blue-600 !w-12 !h-12 transition-all duration-500 rounded-full !top-2/4 !-translate-y-8  !right-5 hover:bg-blue-600"
                data-carousel-next>
                <svg class="h-5 w-5 text-blue-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>


<div class="flex justify-center items-center my-5 bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[95%]">
        <form id="searchForm">
            <div class="flex items-center gap-3 mb-3">
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Search product" name="search_str" id="search_str" />
                <select name="is_best_seller" id="is_best_seller"
                    class="w-full px-4 py-2 rounded-md border border-gray-300">
                    <option value="">All</option>
                    <option value="yes">Best Seller</option>
                </select>
            </div>
            <div class="flex items-center gap-3 mb-3">
                <select name="cat_id" id="cat_id" class="w-full px-4 py-2 rounded-md border border-gray-300">
                    <option value="">Select Category</option>
                </select>
                <select name="sub_categories" id="sub_categories"
                    class="w-full px-4 py-2 rounded-md border border-gray-300">
                    <option value="">Select Sub Category</option>
                </select>
            </div>
            <input type="hidden" id="limit" name="limit" value="5" />
            <button type="submit"
                class="w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">Search
                Product</button>
        </form>
        <div id="productList"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-3 my-5"></div>
        <div id="paginationLinks"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchBanners() {
            $.ajax({
                url: "http://localhost:3000/includes/banner.php?all=true",
                type: "get",
                success: function (result) {
                    let banners = $.parseJSON(result);

                    banners.forEach(banner => {
                        $("#slides").append(`
                        <div class="swiper-slide">
                            <div class="h-96 flex flex-col justify-center items-center gap-5" style="background: url(../uploads/${banner.image}) center center/cover no-repeat;">
                                <span class="text-3xl font-semibold text-blue-600">${banner.heading1}</span>
                                <span class="text-xl text-blue-400">${banner.heading2}</span>
                                <a href="${banner.btn_link}" class="w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors uppercase">${banner.btn_txt}</a>
                            </div>
                        </div>
                        `);
                    })
                }
            })
        }

        fetchBanners();

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

        function fetchCategories() {
            $.ajax({
                url: "http://localhost:3000/includes/category.php?get=true",
                type: "get",
                success: function (result) {
                    let categories = $.parseJSON(result);

                    categories.forEach(category => {
                        $("#cat_id").append(`
                            <option value="${category.id}">${category.name}</option>
                        `);
                    })
                }
            })
        }

        fetchCategories();

        $("#cat_id").on("change", function () {
            $("#sub_categories").html("<option value=''>Select Sub Category</option>");

            $.ajax({
                url: `http://localhost:3000/admin/includes/sub_category.php?get=true&categories_id=${this.value}`,
                type: "get",
                success: function (result) {
                    let categories = $.parseJSON(result);

                    categories.forEach(category => {
                        $("#sub_categories").append(`
                            <option value="${category.id}">${category.sub_categories}</option>
                        `);
                    })
                }
            })
        });

        function fetchProducts(page = 1) {
            const title = $("#title").val();
            const limit = $("#limit").val();
            const cat_id = $("#cat_id").val();
            const sub_categories = $("#sub_categories").val();
            const search_str = $("#search_str").val();
            const is_best_seller = $("#is_best_seller").val();

            $.ajax({
                url: "http://localhost:3000/includes/product.php?all=true",
                type: "get",
                data: {
                    limit: limit,
                    page: page,
                    cat_id: cat_id,
                    sub_categories: sub_categories,
                    search_str: search_str,
                    is_best_seller: is_best_seller
                },
                success: function (data) {
                    const result = JSON.parse(data);

                    const products = result.products;
                    const totalPages = result.totalPages;

                    $("#productList").empty();

                    if (products.length > 0) {
                        products.forEach(product => {
                            $("#productList").append(`
                                <a href="./product.php?id=${product.id}">
                                    <div class="bg-white shadow-black shadow-md rounded p-3">
                                        <img src="../uploads/${product.images[0].image}" alt="product" class="h-[250px] w-full rounded" />
                                        <h2 class="capitalize text-2xl font-bold">${product.title}</h2>
                                        <p>${product.description}</p>
                                        <p><strong>Price:</strong> INR${product.price} / INR${product.mrp}</p>
                                        <p><strong>Category:</strong> ${product.category.name}</p>
                                        <p><strong>Sub Category:</strong> ${product.sub_category.name}</p>
                                        <p><strong>Created At:</strong> ${product.createdAt}</p>
                                    </div>
                                </a>
                            `);
                        })
                    } else {
                        $("#productList").append("<p class='font-extrabold text-2xl p-3'>No products found.</p>");
                    }

                    $("#paginationLinks").empty();

                    if (page > 1) {
                        $('#paginationLinks').append(`<a href="#" class="paginationLink w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200" data-page="${page - 1}">Previous</a> `);
                    }
                    if (page < totalPages) {
                        $('#paginationLinks').append(`<a href="#" class="paginationLink w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200" data-page="${page + 1}">Next</a>`);
                    }
                }
            })
        }

        $('#searchForm').on('submit', function (e) {
            e.preventDefault();

            fetchProducts();
        });

        $(document).on('click', '.paginationLink', function (e) {
            e.preventDefault();

            const page = $(this).data('page');
            fetchProducts(page);
        });

        fetchProducts();
    })
</script>

<?php require "./includes/footer.php"; ?>