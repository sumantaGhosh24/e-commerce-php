<?php require "./includes/header.php"; ?>

<div class="min-h-screen pt-8 bg-white container mx-auto">
    <div class="overflow-x-scroll">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-center">Manage Coupons</h2>
            <span id="form_error" class="text-red-500 font-bold text-center my-3"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3"></span>
            <a href="./create-coupon.php"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200 w-fit">Create
                Coupon</a>
        </div>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Coupon Code</th>
                    <th class="py-3 px-6 text-left">Coupon Value</th>
                    <th class="py-3 px-6 text-left">Coupon Type</th>
                    <th class="py-3 px-6 text-left">Cart Minimum Value</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Updated At</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="coupons"></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchCoupons() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/coupon.php?admin=true",
                type: "get",
                success: function (result) {
                    let coupons = $.parseJSON(result);

                    $("#coupons").html("");

                    coupons.forEach(coupon => {
                        $("#coupons").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${coupon.id}</td>
                                <td class="py-3 px-6 text-left">${coupon.coupon_code}</td>
                                <td class="py-3 px-6 text-left">${coupon.coupon_value}</td>
                                <td class="py-3 px-6 text-left">${coupon.coupon_type}</td>
                                <td class="py-3 px-6 text-left">${coupon.cart_min_value}</td>
                                <td class="py-3 px-6 text-left">${coupon.status == "1" ? "Active" : "Deactive"}</td>
                                <td class="py-3 px-6 text-left">${coupon.createdAt}</td>
                                <td class="py-3 px-6 text-left">${coupon.updatedAt}</td>
                                <td class="py-3 px-6 text-left flex items-center gap-3">
                                    <a href="./update-coupon.php?id=${coupon.id}" class="w-fit bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors disabled:bg-green-200">Update</a>
                                    <form class="coupon_delete_form">
                                        <button type="submit" class="w-fit bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors disabled:bg-red-200">Delete</button>
                                        <input type="hidden" name="id" value="${coupon.id}" />
                                        <input type="hidden" name="action" value="delete" />
                                    </form>
                                </td>
                            </tr>
                        `);
                    })
                }
            })
        }

        fetchCoupons();

        $(document).on("submit", ".coupon_delete_form", function (e) {
            e.preventDefault();

            let form = $(this);
            let button = form.find("button[type='submit']");

            $("#form_error").html("");
            $("#form_success").html("");
            button.attr("disabled", true).text("Processing...");

            $.ajax({
                url: "http://localhost:3000/admin/includes/coupon.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false).text("Delete");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchCoupons();
                    }
                }
            });
        });
    })
</script>

<?php require "./includes/footer.php"; ?>