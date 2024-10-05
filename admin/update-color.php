<?php require "./includes/header.php"; ?>

<?php
if (!isset($_GET["id"])) {
    echo "There is something wrong, try again later.";
}
?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Update Color</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="update_color_form">
            <div class="mb-4">
                <label for="color">Color:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300" placeholder="Enter color"
                    name="color" id="color" />
            </div>
            <div class="mb-4">
                <label for="status">Color Status:</label>
                <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="status" id="status">
                    <option value="">Select color status</option>
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                </select>
            </div>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> />
            <button type="submit" id="update_color_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Update
                Color</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchColor() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/color.php?id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#color").val(data.color);
                    $("#status").val(data.status);
                }
            })
        }

        fetchColor();

        $("#update_color_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#update_color_submit").attr("disabled", true);
            $("#update_color_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/color.php",
                type: "post",
                data: $("#update_color_form").serialize(),
                success: function (result) {
                    $("#update_color_submit").attr("disabled", false);
                    $("#update_color_submit").text("Update Color");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchColor();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>