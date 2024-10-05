<?php require "./includes/header.php"; ?>

<?php
if (!isset($_GET["id"])) {
    echo "There is something wrong, try again later.";
}
?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Update Sub Category</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="update_category_form">
            <div class="mb-4">
                <label for="sub_categories">Sub Category Name:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter sub category name" name="sub_categories" id="sub_categories" />
            </div>
            <div class="mb-4">
                <label for="categories_id">Category:</label>
                <select name="categories_id" id="categories_id"
                    class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300">
                    <option value="">Select Category</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="status">Category Status:</label>
                <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="status" id="status">
                    <option value="">Select category status</option>
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                </select>
            </div>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> />
            <button type="submit" id="update_category_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Update
                Sub Category</button>
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

        function fetchCategory() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/sub_category.php?id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#sub_categories").val(data.sub_categories);
                    $("#categories_id").val(data.categories_id);
                    $("#status").val(data.status);
                }
            })
        }

        fetchCategory();

        $("#update_category_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#update_category_submit").attr("disabled", true);
            $("#update_category_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/sub_category.php",
                type: "post",
                data: $("#update_category_form").serialize(),
                success: function (result) {
                    $("#update_category_submit").attr("disabled", false);
                    $("#update_category_submit").text("Update Category");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchCategory();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>