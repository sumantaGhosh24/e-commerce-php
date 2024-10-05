<?php require "./includes/header.php"; ?>

<div class="flex justify-center items-center bg-white my-20">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Create Product</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="create_product_form">
            <div class="mb-4">
                <label for="file">Product Image:</label>
                <input type="file" id="file" name="file" accept="image/*"
                    class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300" />
            </div>
            <div class="mb-4">
                <label for="categories_id">Product Category:</label>
                <select name="categories_id" id="categories_id"
                    class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300">
                    <option value="">Select Category</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="sub_categories_id">Product Sub Category:</label>
                <select name="sub_categories_id" id="sub_categories_id"
                    class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300">
                    <option value="">Select Sub Category</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="title">Product Title:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product title" name="title" id="title" />
            </div>
            <div class="mb-4">
                <label for="description">Product Description:</label>
                <textarea placeholder="Enter product description" name="description" id="description"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 resize-y"></textarea>
            </div>
            <div class="mb-4">
                <label for="short_desc">Product Short Description:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product short description" name="short_desc" id="short_desc" />
            </div>
            <div class="mb-4">
                <label for="meta_title">Product Meta Title:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product meta title" name="meta_title" id="meta_title" />
            </div>
            <div class="mb-4">
                <label for="meta_desc">Product Meta Description:</label>
                <textarea placeholder="Enter product meta description" name="meta_desc" id="meta_desc"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 resize-y"></textarea>
            </div>
            <div class="mb-4">
                <label for="meta_keyword">Product Meta Keyword:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product meta keyword" name="meta_keyword" id="meta_keyword" />
            </div>
            <div class="mb-4">
                <label for="best_seller">Product Best Seller:</label>
                <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="best_seller" id="best_seller">
                    <option value="">Select best seller</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="mrp">Product Mrp:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product mrp" name="mrp" id="mrp" />
            </div>
            <div class="mb-4">
                <label for="price">Product Price:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product price" name="price" id="price" />
            </div>
            <div class="mb-4">
                <label for="qty">Product Quantity:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter product quantity" name="qty" id="qty" />
            </div>
            <input type="hidden" name="action" value="create" />
            <button type="submit" id="create_product_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Create
                Product</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchCategories() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/category.php?get=true",
                type: "get",
                success: function (result) {
                    let categories = $.parseJSON(result);

                    categories.forEach(category => {
                        $("#categories_id").append(`
                            <option value="${category.id}">${category.name}</option>
                        `);
                    })
                }
            })
        }

        fetchCategories();

        $("#categories_id").on("change", function () {
            $("#sub_categories_id").html("<option value=''>Select Sub Category</option>");

            $.ajax({
                url: `http://localhost:3000/admin/includes/sub_category.php?get=true&categories_id=${this.value}`,
                type: "get",
                success: function (result) {
                    let categories = $.parseJSON(result);

                    categories.forEach(category => {
                        $("#sub_categories_id").append(`
                            <option value="${category.id}">${category.sub_categories}</option>
                        `);
                    })
                }
            })
        });

        $("#create_product_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#create_product_submit").attr("disabled", true);
            $("#create_product_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#create_product_submit").attr("disabled", false);
                    $("#create_product_submit").text("Create Product");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#create_product_form")[0].reset();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>