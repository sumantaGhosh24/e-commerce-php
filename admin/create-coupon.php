<?php require "./includes/header.php"; ?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-5">Create Coupon</h1>
        <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
        <form class="mb-6" id="create_coupon_form">
            <div class="mb-4">
                <label for="coupon_code">Coupon Code:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter coupon code" name="coupon_code" />
            </div>
            <div class="mb-4">
                <label for="coupon_value">Coupon Value:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter coupon value" name="coupon_value" />
            </div>
            <div class="mb-4">
                <label for="coupon_type">Coupon Type:</label>
                <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="coupon_type" required>
                    <option value=''>Select</option>
                    <?php
                    if ($coupon_type == 'Percentage') {
                        echo '<option value="Percentage" selected>Percentage</option>
												<option value="Rupee">Rupee</option>';
                    } elseif ($coupon_type == 'Rupee') {
                        echo '<option value="Percentage">Percentage</option>
												<option value="Rupee" selected>Rupee</option>';
                    } else {
                        echo '<option value="Percentage">Percentage</option>
												<option value="Rupee">Rupee</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="cart_min_value">Cart Minimum Value:</label>
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter cart minimum value" name="cart_min_value" />
            </div>
            <input type="hidden" name="action" value="create" />
            <button type="submit" id="create_coupon_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Create
                Coupon</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#create_coupon_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#create_coupon_submit").attr("disabled", true);
            $("#create_coupon_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/coupon.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#create_coupon_submit").attr("disabled", false);
                    $("#create_coupon_submit").text("Create Coupon");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#create_coupon_form")[0].reset();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>