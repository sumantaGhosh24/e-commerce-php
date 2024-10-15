<?php require "./includes/header.php"; ?>

<?php
if (!isset($_GET["id"])) {
    echo "There is something wrong, try again later.";
    die();
}
?>

<div class="bg-white min-h-screen">
    <div class="container mx-auto">
        <div class="flex pt-5 mb-5">
            <button id="update" class="mr-2 bg-blue-500 text-white px-4 py-2 rounded">Update Product</button>
            <button id="addImage" class="mr-2 bg-gray-400 text-white px-4 py-2 rounded">Add Product Image</button>
            <button id="removeImage" class="mr-2 bg-gray-400 text-white px-4 py-2 rounded">Remove Product
                Image</button>
            <button id="addAttribute" class="mr-2 bg-gray-400 text-white px-4 py-2 rounded">Add Product
                Attribute</button>
            <button id="removeAttribute" class="mr-2 bg-gray-400 text-white px-4 py-2 rounded">Remove Product
                Attribute</button>
        </div>
        <div id="updateContent" class="bg-white shadow-md shadow-black p-5 rounded">
            <h1 class="text-2xl font-semibold mb-4">Update Product</h1>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <form id="update_form" class="p-4">
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
                    <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="best_seller"
                        id="best_seller">
                        <option value="">Select best seller</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="status">Product Status:</label>
                    <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="status" id="status">
                        <option value="">Select product status</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
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
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <button type="submit" id="update_submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">Update
                    Product</button>
            </form>
        </div>
        <div id="addImageContent" class="hidden bg-white shadow-md shadow-black p-5 rounded">
            <h1 class="text-2xl font-semibold mb-4">Add Product Image</h1>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <form id="addImage_form" class="mt-6 p-4">
                <label for="file">Image:</label>
                <input type="file" id="file" name="file" accept="image/*"
                    class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300">
                <input type="hidden" name="action" value="add" />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <button type="submit" id="addImage_submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors mt-5">Add
                    Image</button>
            </form>
        </div>
        <div id="removeImageContent" class="hidden bg-white shadow-md shadow-black p-5 rounded">
            <h1 class="text-2xl font-semibold mb-4">Remove Product Image</h1>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <div id="images" class="mb-5 flex items-center gap-3"></div>
        </div>
        <div id="addAttributeContent" class="hidden bg-white shadow-md shadow-black p-5 rounded">
            <h1 class="text-2xl font-semibold mb-4">Add Product Attribute</h1>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <form id="addAttribute_form" class="mt-6 p-4">
                <div class="mb-4">
                    <label for="size_id">Product Attribute Size:</label>
                    <select name="size_id" id="size_id" class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300">
                        <option value="">Select attribute size</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="color_id">Product Attribute Color:</label>
                    <select name="color_id" id="color_id"
                        class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300">
                        <option value="">Select attribute color</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="mrp">Product MRP:</label>
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
                        placeholder="Enter product qty" name="qty" id="qty" />
                </div>
                <input type="hidden" name="action" value="add-attribute" />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <button type="submit" id="addAttribute_submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors mt-5">Add
                    Attribute</button>
            </form>
        </div>
        <div id="removeAttributeContent" class="hidden bg-white shadow-md shadow-black p-5 rounded">
            <h1 class="text-2xl font-semibold mb-4">Remove Product Attribute</h1>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Color</th>
                        <th class="py-3 px-6 text-left">Size</th>
                        <th class="py-3 px-6 text-left">MRP</th>
                        <th class="py-3 px-6 text-left">Price</th>
                        <th class="py-3 px-6 text-left">Quantity</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="attributes"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#update").click(function () {
            $("#update").addClass("bg-blue-500");
            $("#update").removeClass("bg-gray-400");

            $("#addImage").removeClass("bg-blue-500");
            $("#addImage").addClass("bg-gray-400");
            $("#removeImage").removeClass("bg-blue-500");
            $("#removeImage").addClass("bg-gray-400");
            $("#addAttribute").removeClass("bg-blue-500");
            $("#addAttribute").addClass("bg-gray-400");
            $("#removeAttribute").removeClass("bg-blue-500");
            $("#removeAttribute").addClass("bg-gray-400");

            $("#updateContent").removeClass("hidden");

            $("#addImageContent").addClass("hidden");
            $("#removeImageContent").addClass("hidden");
            $("#addAttributeContent").addClass("hidden");
            $("#removeAttributeContent").addClass("hidden");
        });

        $("#addImage").click(function () {
            $("#addImage").addClass("bg-blue-500");
            $("#addImage").removeClass("bg-gray-400");

            $("#update").removeClass("bg-blue-500");
            $("#update").addClass("bg-gray-400");
            $("#removeImage").removeClass("bg-blue-500");
            $("#removeImage").addClass("bg-gray-400");
            $("#addAttribute").removeClass("bg-blue-500");
            $("#addAttribute").addClass("bg-gray-400");
            $("#removeAttribute").removeClass("bg-blue-500");
            $("#removeAttribute").addClass("bg-gray-400");

            $("#addImageContent").removeClass("hidden");

            $("#updateContent").addClass("hidden");
            $("#removeImageContent").addClass("hidden");
            $("#addAttributeContent").addClass("hidden");
            $("#removeAttributeContent").addClass("hidden");
        });

        $("#removeImage").click(function () {
            $("#removeImage").addClass("bg-blue-500");
            $("#removeImage").removeClass("bg-gray-400");

            $("#update").removeClass("bg-blue-500");
            $("#update").addClass("bg-gray-400");
            $("#addImage").removeClass("bg-blue-500");
            $("#addImage").addClass("bg-gray-400");
            $("#addAttribute").removeClass("bg-blue-500");
            $("#addAttribute").addClass("bg-gray-400");
            $("#removeAttribute").removeClass("bg-blue-500");
            $("#removeAttribute").addClass("bg-gray-400");

            $("#removeImageContent").removeClass("hidden");

            $("#addImageContent").addClass("hidden");
            $("#updateContent").addClass("hidden");
            $("#addAttributeContent").addClass("hidden");
            $("#removeAttributeContent").addClass("hidden");
        });

        $("#addAttribute").click(function () {
            $("#addAttribute").addClass("bg-blue-500");
            $("#addAttribute").removeClass("bg-gray-400");

            $("#update").removeClass("bg-blue-500");
            $("#update").addClass("bg-gray-400");
            $("#removeImage").removeClass("bg-blue-500");
            $("#removeImage").addClass("bg-gray-400");
            $("#addImage").removeClass("bg-blue-500");
            $("#addImage").addClass("bg-gray-400");
            $("#removeAttribute").removeClass("bg-blue-500");
            $("#removeAttribute").addClass("bg-gray-400");

            $("#addAttributeContent").removeClass("hidden");

            $("#updateContent").addClass("hidden");
            $("#removeImageContent").addClass("hidden");
            $("#addImageContent").addClass("hidden");
            $("#removeAttributeContent").addClass("hidden");
        });

        $("#removeAttribute").click(function () {
            $("#removeAttribute").addClass("bg-blue-500");
            $("#removeAttribute").removeClass("bg-gray-400");

            $("#update").removeClass("bg-blue-500");
            $("#update").addClass("bg-gray-400");
            $("#addImage").removeClass("bg-blue-500");
            $("#addImage").addClass("bg-gray-400");
            $("#addAttribute").removeClass("bg-blue-500");
            $("#addAttribute").addClass("bg-gray-400");
            $("#removeImage").removeClass("bg-blue-500");
            $("#removeImage").addClass("bg-gray-400");

            $("#removeAttributeContent").removeClass("hidden");

            $("#addImageContent").addClass("hidden");
            $("#updateContent").addClass("hidden");
            $("#addAttributeContent").addClass("hidden");
            $("#removeImageContent").addClass("hidden");
        });

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

        function fetchProduct() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php?id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#categories_id").val(data.category.id);
                    $("#title").val(data.title);
                    $("#description").val(data.description);
                    $("#short_desc").val(data.short_desc);
                    $("#meta_title").val(data.meta_title);
                    $("#meta_desc").val(data.meta_desc);
                    $("#meta_keyword").val(data.meta_keyword);
                    $("#best_seller").val(data.best_seller);
                    $("#mrp").val(data.mrp);
                    $("#price").val(data.price);
                    $("#qty").val(data.qty);
                    $("#status").val(data.status);

                    $("#sub_categories_id").html("<option value=''>Select Sub Category</option>");

                    $.ajax({
                        url: `http://localhost:3000/admin/includes/sub_category.php?get=true&categories_id=${data.category.id}`,
                        type: "get",
                        success: function (result) {
                            let categories = $.parseJSON(result);

                            categories.forEach(category => {
                                $("#sub_categories_id").append(`
                                    <option value="${category.id}">${category.sub_categories}</option>
                                `);
                            })

                            $("#sub_categories_id").val(data.sub_category.id);
                        }
                    })

                    $("#images").html("");

                    data.images.forEach(img => {
                        $("#images").append(`
                        <form class="mt-6 p-4 relative removeImage_form">
                            <img src="../uploads/${img.image}" alt="product" class="h-36 w-36 rounded" />
                            <input type="hidden" name="action" value="remove" />
                            <input type="hidden" name="id" value="${img.id}" />
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors absolute top-5 right-5"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        `);
                    })

                    $("#attributes").html("");

                    data.attributes.forEach(attribute => {
                        $("#attributes").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${attribute.id}</td>
                                <td class="py-3 px-6 text-left">${attribute.color}</td>
                                <td class="py-3 px-6 text-left">${attribute.size}</td>
                                <td class="py-3 px-6 text-left">${attribute.mrp}</td>
                                <td class="py-3 px-6 text-left">${attribute.price}</td>
                                <td class="py-3 px-6 text-left">${attribute.qty}</td>
                                <td class="py-3 px-6 text-left flex items-center gap-3">
                                    <form class="attribute_delete_form">
                                        <input type="hidden" name="action" value="remove-attribute" />
                                        <input type="hidden" name="id" value="${attribute.id}" />
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        `);
                    })
                }
            })
        }

        fetchProduct();

        $("#update_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#update_submit").attr("disabled", true);
            $("#update_submit").text("Processing...");

            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php",
                type: "post",
                data: $("#update_form").serialize(),
                success: function (result) {
                    $("#update_submit").attr("disabled", false);
                    $("#update_submit").text("Update Product");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchProduct();
                    }
                }
            })

            e.preventDefault();
        })

        $("#addImage_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#addImage_submit").attr("disabled", true);
            $("#addImage_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#addImage_submit").attr("disabled", false);
                    $("#addImage_submit").text("Add Image");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchProduct();
                    }
                }
            })

            e.preventDefault();
        })

        $(document).on("submit", ".removeImage_form", function (e) {
            e.preventDefault()

            let form = $(this);
            let button = form.find("button[type='submit']");

            $("#form_error").html("");
            $("#form_success").html("");
            button.attr("disabled", true);

            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false);

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchProduct();
                    }
                }
            });
        })

        function fetchColors() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/color.php?get=true",
                type: "get",
                success: function (result) {
                    let colors = $.parseJSON(result);

                    colors.forEach(color => {
                        $("#color_id").append(`
                            <option value="${color.id}">${color.color}</option>
                        `);
                    })
                }
            })
        }

        fetchColors();

        function fetchSizes() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/size.php?get=true",
                type: "get",
                success: function (result) {
                    let sizes = $.parseJSON(result);

                    sizes.forEach(size => {
                        $("#size_id").append(`
                            <option value="${size.id}">${size.size}</option>
                        `);
                    })
                }
            })
        }

        fetchSizes();

        $("#addAttribute_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#addAttribute_submit").attr("disabled", true);
            $("#addAttribute_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#addAttribute_submit").attr("disabled", false);
                    $("#addAttribute_submit").text("Add Attribute");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#addAttribute_form")[0].reset();
                        fetchProduct();
                    }
                }
            })

            e.preventDefault();
        })

        $(document).on("submit", ".attribute_delete_form", function (e) {
            e.preventDefault()

            let form = $(this);
            let button = form.find("button[type='submit']");

            $("#form_error").html("");
            $("#form_success").html("");
            button.attr("disabled", true);

            $.ajax({
                url: "http://localhost:3000/admin/includes/product.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false);

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchProduct();
                    }
                }
            });
        })
    })
</script>

<?php require "./includes/footer.php"; ?>