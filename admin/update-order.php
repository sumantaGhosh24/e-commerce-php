<?php require "./includes/header.php"; ?>

<?php
if (!isset($_GET["id"])) {
    echo "There is something wrong, try again later.";
}
?>

<div class="flex justify-center items-center bg-white my-20">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black container mx-auto overflow-y-scroll">
        <h2 class="text-2xl font-bold mb-4">Order Details</h2>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <td class="py-3 px-6 text-left" id="id"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">User Name</th>
                <td class="py-3 px-6 text-left" id="user_name"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">User Email</th>
                <td class="py-3 px-6 text-left" id="user_email"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Address</th>
                <td class="py-3 px-6 text-left" id="address"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">City</th>
                <td class="py-3 px-6 text-left" id="city"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Pincode</th>
                <td class="py-3 px-6 text-left" id="pincode"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Total Price</th>
                <td class="py-3 px-6 text-left" id="total_price"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Order Status</th>
                <td class="py-3 px-6 text-left" id="order_status_name"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Coupon Value</th>
                <td class="py-3 px-6 text-left" id="coupon_value"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Coupon Code</th>
                <td class="py-3 px-6 text-left" id="coupon_code"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Payment</th>
                <td class="py-3 px-6 text-left" id="payment"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Created At</th>
                <td class="py-3 px-6 text-left" id="createdAt"></td>
            </tr>
            <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                <th class="py-3 px-6 text-left">Updated At</th>
                <td class="py-3 px-6 text-left" id="updatedAt"></td>
            </tr>
        </table>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Title</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">Category</th>
                    <th class="py-3 px-6 text-left">Sub Category</th>
                    <th class="py-3 px-6 text-left">Color</th>
                    <th class="py-3 px-6 text-left">Size</th>
                    <th class="py-3 px-6 text-left">MRP</th>
                    <th class="py-3 px-6 text-left">Price</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                </tr>
            </thead>
            <tbody id="orders"></tbody>
        </table>
        <form class="my-6" id="update_order_form">
            <h2 class="text-3xl font-semibold mb-5">Update Order</h2>
            <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
            <div class="mb-4">
                <label for="status">Order Status:</label>
                <select class="w-full px-4 py-2 rounded-md border border-gray-300" name="status" id="status">
                    <option value="">Select order status</option>
                </select>
            </div>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> />
            <button type="submit" id="update_order_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Update
                Order</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchOrderStatus() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/order.php?status=true",
                type: "get",
                success: function (result) {
                    let data = $.parseJSON(result);

                    data.forEach(status => {
                        $("#status").append(`
                            <option value="${status.id}">${status.name}</option>
                        `);
                    })
                }
            })
        }

        fetchOrderStatus();

        function fetchOrder() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/order.php?id=<?php echo $_GET['id']; ?>",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#id").text(data.order.id);
                    $("#user_name").text(data.order.user_name);
                    $("#user_email").text(data.order.user_email);
                    $("#address").text(data.order.address);
                    $("#city").text(data.order.city);
                    $("#pincode").text(data.order.pincode);
                    $("#total_price").text(data.order.total_price);
                    $("#order_status_name").text(data.order.order_status_name);
                    $("#coupon_value").text(data.order.coupon_value);
                    $("#coupon_code").text(data.order.coupon_code);
                    $("#payment").text(`${data.order.paymentResultId} | ${data.order.paymentResultStatus} | ${data.order.paymentResultOrderId} | ${data.order.paymentResultPaymentId} | ${data.order.paymentResultRazorpaySignature}`);
                    $("#createdAt").text(data.order.createdAt);
                    $("#updatedAt").text(data.order.updatedAt);

                    $("#orders").html("");

                    data.order_details.forEach(order => {
                        $("#orders").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${order.id}</td>
                                <td class="py-3 px-6 text-left">${order.title}</td>
                                <td class="py-3 px-6 text-left">${order.description}</td>
                                <td class="py-3 px-6 text-left">
                                    <img src="../uploads/${order.product_image}" alt="product" class="w-12 h-12 rounded-full" />
                                </td>
                                <td class="py-3 px-6 text-left">${order.category_name}</td>
                                <td class="py-3 px-6 text-left">${order.sub_category_name}</td>
                                <td class="py-3 px-6 text-left">${order.color_name}</td>
                                <td class="py-3 px-6 text-left">${order.size_name}</td>
                                <td class="py-3 px-6 text-left">${order.attribute_mrp}</td>
                                <td class="py-3 px-6 text-left">${order.attribute_price}</td>
                                <td class="py-3 px-6 text-left">${order.qty}</td>
                            </tr>
                        `);
                    });

                    $("#status").val(data.order.order_status);
                }
            })
        }

        fetchOrder();

        $("#update_order_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#update_order_submit").attr("disabled", true);
            $("#update_order_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/admin/includes/order.php",
                type: "post",
                data: $("#update_order_form").serialize(),
                success: function (result) {
                    $("#update_order_submit").attr("disabled", false);
                    $("#update_order_submit").text("Update Order");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchOrder();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>