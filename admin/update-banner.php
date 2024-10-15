<?php require "./includes/header.php"; ?>

<?php
if (!isset($_GET["id"])) {
    echo "There is something wrong, try again later.";
    die();
}
?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Update Banner</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="update_banner_form">
            <div class="mb-4">
                <label for="heading1">Banner Heading 1:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner heading 1" name="heading1" id="heading1" />
            </div>
            <div class="mb-4">
                <label for="heading2">Banner Heading 2:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner heading 2" name="heading2" id="heading2" />
            </div>
            <div class="mb-4">
                <label for="btn_txt">Banner Button Text:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner button text" name="btn_txt" id="btn_txt" />
            </div>
            <div class="mb-4">
                <label for="btn_link">Banner Button Link:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner button link" name="btn_link" id="btn_link" />
            </div>
            <div class="mb-4">
                <label for="order_no">Banner Order:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter banner order" name="order_no" id="order_no" />
            </div>
            <div class="mb-4">
                <label for="status">Banner Status:</label>
                <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="status" id="status">
                    <option value="">Select banner status</option>
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                </select>
            </div>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> />
            <button type="submit" id="update_banner_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Update
                Banner</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchBanner() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/banner.php?id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#heading1").val(data.heading1);
                    $("#heading2").val(data.heading2);
                    $("#btn_txt").val(data.btn_txt);
                    $("#btn_link").val(data.btn_link);
                    $("#order_no").val(data.order_no);
                    $("#status").val(data.status);
                }
            })
        }

        fetchBanner();

        $("#update_banner_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#update_banner_submit").attr("disabled", true);
            $("#update_banner_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/banner.php",
                type: "post",
                data: $("#update_banner_form").serialize(),
                success: function (result) {
                    $("#update_banner_submit").attr("disabled", false);
                    $("#update_banner_submit").text("Update Banner");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchBanner();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>