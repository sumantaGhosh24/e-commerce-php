<?php require "./includes/header.php"; ?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Create Banner</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="create_banner_form">
            <div class="mb-4">
                <label for="file">Banner Image:</label>
                <input type="file" id="file" name="file" accept="image/*"
                    class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300" />
            </div>
            <div class="mb-4">
                <label for="heading1">Banner Heading 1:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner heading 1" name="heading1" />
            </div>
            <div class="mb-4">
                <label for="heading2">Banner Heading 2:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner heading 2" name="heading2" />
            </div>
            <div class="mb-4">
                <label for="btn_txt">Banner Button Text:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner button text" name="btn_txt" />
            </div>
            <div class="mb-4">
                <label for="btn_link">Banner Button Link:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner button link" name="btn_link" />
            </div>
            <div class="mb-4">
                <label for="order_no">Banner Order:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner order" name="order_no" />
            </div>
            <input type="hidden" name="action" value="create" />
            <button type="submit" id="create_banner_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Create
                Banner</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#create_banner_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#create_banner_submit").attr("disabled", true);
            $("#create_banner_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/banner.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#create_banner_submit").attr("disabled", false);
                    $("#create_banner_submit").text("Create Banner");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#create_banner_form")[0].reset();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>