<?php require "./includes/header.php"; ?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Create Color</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="create_color_form">
            <div class="mb-4">
                <label for="color">Color:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300" placeholder="Enter color"
                    name="color" />
            </div>
            <input type="hidden" name="action" value="create" />
            <button type="submit" id="create_color_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Create
                Color</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#create_color_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#create_color_submit").attr("disabled", true);
            $("#create_color_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/color.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#create_color_submit").attr("disabled", false);
                    $("#create_color_submit").text("Create Color");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#create_color_form")[0].reset();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>