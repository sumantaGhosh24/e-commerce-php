<?php require "./includes/header.php"; ?>

<?php
if (!isset($_SESSION["USER_ID"])) {
    header("Location: login.php");
    die();
}
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="min-h-screen pt-8 bg-white container mx-auto">
    <div class="flex items-start justify-between flex-wrap gap-3 flex-row">
        <div class="overflow-x-scroll">
            <h2 class="text-2xl font-bold">My Cart</h2>
            <?php if (isset($_SESSION["cart"])) { ?>
                <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Image</th>
                            <th class="py-3 px-6 text-left">Title</th>
                            <th class="py-3 px-6 text-left">Size/Color</th>
                            <th class="py-3 px-6 text-left">Price</th>
                            <th class="py-3 px-6 text-left">Quantity</th>
                            <th class="py-3 px-6 text-left">Total</th>
                            <th class="py-3 px-6 text-left">Remove</th>
                        </tr>
                    </thead>
                    <tbody id="carts"></tbody>
                </table>
            <?php } else { ?>
                <h2 class="my-5 text-lg font-bold">You don't have any product in your cart.
                <?php } ?>
        </div>
        <?php if (isset($_SESSION["cart"])) { ?>
            <div>
                <h2 class="text-2xl font-bold mb-5">Checkout</h2>
                <span id="form_error" class="text-red-500 font-bold text-center my-3 error_field"></span>
                <span id="form_success" class="text-green-500 font-bold text-center my-3 error_field"></span>
                <div class="flex items-start justify-between gap-3 flex-wrap">
                    <form class="mb-6" id="coupon_form">
                        <h2 class="text-lg mb-5" id="total_products">Total Products: </h2>
                        <h2 class="text-lg mb-5" id="total_price">Total Price: </h2>
                        <h2 class="text-lg mb-5" id="coupon">Coupon: </h2>
                        <h2 class="text-lg mb-5" id="net_price">Net Price: </h2>
                        <div class="mb-4">
                            <label for="coupon_code">Coupon Code:</label>
                            <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                                placeholder="Enter coupon code" name="coupon_code" required />
                        </div>
                        <input type="hidden" name="cart_price" id="cart_price" value="0" />
                        <input type="hidden" name="action" value="verify" />
                        <div class="flex items-center gap-3">
                            <button type="submit" id="coupon_submit"
                                class="w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Verify
                                Coupon</button>
                        </div>
                    </form>
                    <form class="mb-6" id="checkout_form">
                        <div class="mb-4">
                            <label for="address">Address:</label>
                            <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                                placeholder="Enter your address" name="address" id="address" required />
                        </div>
                        <div class="mb-4">
                            <label for="city">City:</label>
                            <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                                placeholder="Enter your city" name="city" id="city" required />
                        </div>
                        <div class="mb-4">
                            <label for="pincode">Pincode:</label>
                            <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                                placeholder="Enter your pincode" name="pincode" id="pincode" required />
                        </div>
                        <input type="hidden" name="coupon_code" id="coupon_code" value="" />
                        <div class="flex items-center gap-3">
                            <button type="submit" id="checkout_submit"
                                class="w-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Checkout</button>
                            <button id="clear_cart"
                                class="w-fit bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors">Clear
                                Cart</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        let couponValue = 0;
        let couponType = "";
        let couponCode = "";

        function fetchCarts() {
            $.ajax({
                url: "http://localhost:3000/includes/cart.php",
                type: "get",
                success: function (result) {
                    let data = $.parseJSON(result);

                    $("#carts").html("");

                    data.forEach(product => {
                        $("#carts").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">
                                    <img src="../uploads/${product.product.image}" alt="product" class="h-16 w-16 rounded-full" />
                                </td>
                                <td class="py-3 px-6 text-left">${product.product.title}</td>
                                <td class="py-3 px-6 text-left">${product.attribute.size} / ${product.attribute.color}</td>
                                <td class="py-3 px-6 text-left">${product.attribute.price}</td>
                                <td class="py-3 px-6 text-left">
                                    <form class="update_cart_form flex items-center gap-1.5">
                                        <input type="number" min="1" max="${product.attribute.qty}" value="${product.qty}" name="quantity" placeholder="update product quantity" class="w-full px-4 py-2 rounded-md border border-gray-300" required />
                                        <br />
                                        <input type="hidden" name="product_id" value="${product.product.id}" />
                                        <input type="hidden" name="attribute_id" value="${product.attribute.id}" />
                                        <input type="hidden" name="action" value="update" />
                                        <button type="submit" class="w-fit bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">Update</button>
                                    </form>
                                </td>
                                <td class="py-3 px-6 text-left">${product.attribute.price * product.qty}</td>
                                <td class="py-3 px-6 text-left">
                                    <form class="remove_cart_form">
                                        <input type="hidden" name="product_id" value="${product.product.id}" />
                                        <input type="hidden" name="attribute_id" value="${product.attribute.id}" />
                                        <input type="hidden" name="action" value="remove" />
                                        <button type="submit" class="w-fit bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        `);
                    })

                    let totalPrice = data.reduce((total, product) => total + (product.attribute.price * product.qty), 0);
                    let netPrice = couponValue > 0 ? (couponType == "Rupee" ? totalPrice - couponValue : totalPrice * ((100 - couponValue) / 100)) : totalPrice;
                    let totalProducts = data.reduce((total, product) => total + Number(product.qty), 0);

                    $("#total_products").text("Total Products: " + totalProducts);
                    $("#total_price").text("Total Price: " + totalPrice);
                    $("#cart_price").val(totalPrice);
                    $("#coupon").text(couponCode == "" ? "Coupon : " : `Coupon : ${couponCode} (${couponValue} / ${couponType})`);
                    $("#net_price").text("Net Price: " + netPrice);
                }
            })
        }

        fetchCarts();

        $(document).on("submit", ".update_cart_form", function (e) {
            e.preventDefault();

            let form = $(this);
            let button = form.find("button[type='submit']");

            button.attr("disabled", true).text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/cart.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false).text("Update");

                    alert("Product updated to cart");

                    fetchCarts();
                }
            });
        });

        $(document).on("submit", ".remove_cart_form", function (e) {
            e.preventDefault();

            let form = $(this);
            let button = form.find("button[type='submit']");

            button.attr("disabled", true).text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/cart.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false).text("Remove");

                    alert("Product removed to cart");

                    fetchCarts();
                }
            });
        });

        $("#clear_cart").on("click", function (e) {
            $("#clear_cart").attr("disabled", true);
            $("#clear_cart").text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/cart.php",
                type: "post",
                data: {
                    action: "clear"
                },
                success: function (result) {
                    $("#clear_cart").attr("disabled", false);
                    $("#clear_cart").text("Clear Cart");

                    alert("You cart cleared");

                    fetchCarts();
                }
            })

            e.preventDefault();
        })

        $("#coupon_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#coupon_submit").attr("disabled", true);
            $("#coupon_submit").text("Processing...");

            var formData = new FormData(this);

            $.ajax({
                url: "http://localhost:3000/includes/order.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    $("#coupon_submit").attr("disabled", false);
                    $("#coupon_submit").text("Verify Coupon");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        couponCode = data.data.coupon_code;
                        couponValue = data.data.coupon_value;
                        couponType = data.data.coupon_type;

                        $("#coupon_code").val(couponCode);

                        fetchCarts();
                    }
                }
            })

            e.preventDefault();
        })

        $('#checkout_form').on('submit', function (e) {
            e.preventDefault();

            let couponCode = $("#coupon_code").val();
            let address = $("#address").val();
            let city = $("#city").val();
            let pincode = $("#pincode").val();

            const obj = {
                address,
                city,
                pincode
            }

            $.ajax({
                url: 'http://localhost:3000/includes/create_order.php',
                type: 'post',
                data: { coupon_code: couponCode },
                success: function (response) {
                    var data = $.parseJSON(response);

                    var options = {
                        "key": data.key,
                        "amount": data.amount,
                        "currency": "INR",
                        "name": "Final Snippet",
                        "description": "This is a test transaction",
                        "order_id": data.id,
                        "handler": function (response) {
                            verifyPayment({ ...data, ...response, ...obj });
                        },
                        "theme": {
                            "color": "#1D4ED8"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                }
            });
        });

        function verifyPayment(payment) {
            $.ajax({
                url: 'http://localhost:3000/includes/verify_payment.php',
                type: 'post',
                data: payment,
                success: function (response) {
                    alert(response);
                    fetchCarts();
                    $("#checkout_form")[0].reset();
                    window.location.href = "my_order.php";
                }
            });
        }
    })
</script>

<?php require "./includes/footer.php"; ?>