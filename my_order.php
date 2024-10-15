<?php require "./includes/header.php"; ?>

<?php
if (!isset($_SESSION["USER_ID"])) {
    header("Location: login.php");
    die();
}
?>

<div class="min-h-screen pt-8 bg-white container mx-auto">
    <div class="overflow-x-scroll">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold mb-4 text-center">Manage Orders</h2>
            <span id="form_error" class="text-red-500 font-bold text-center my-3"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3"></span>
        </div>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Total Price</th>
                    <th class="py-3 px-6 text-left">Order Status</th>
                    <th class="py-3 px-6 text-left">Payment Status</th>
                    <th class="py-3 px-6 text-left">Address</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Updated At</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="orders"></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchOrders() {
            $.ajax({
                url: "http://localhost:3000/includes/order.php?user=true",
                type: "get",
                success: function (result) {
                    let orders = $.parseJSON(result);

                    $("#orders").html("");

                    orders.forEach(order => {
                        $("#orders").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${order.id}</td>
                                <td class="py-3 px-6 text-left">${order.total_price}</td>
                                <td class="py-3 px-6 text-left">${order.order_status_str}</td>
                                <td class="py-3 px-6 text-left">${order.paymentResultStatus}</td>
                                <td class="py-3 px-6 text-left">${order.address} | ${order.city} | ${order.pincode}</td>
                                <td class="py-3 px-6 text-left">${order.createdAt}</td>
                                <td class="py-3 px-6 text-left">${order.updatedAt}</td>
                                <td class="py-3 px-6 text-left flex items-center gap-3">
                                    <a href="./order.php?id=${order.id}" class="w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">View</a>
                                </td>
                            </tr>
                        `);
                    });
                }
            })
        }

        fetchOrders();
    })
</script>

<?php require "./includes/footer.php"; ?>