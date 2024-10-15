<?php
require "database.php";
require "function.php";
require "constant.php";
require "../vendor/autoload.php";

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["USER_ID"];
    $address = get_safe_value($con, $_POST["address"]);
    $city = get_safe_value($con, $_POST["city"]);
    $pincode = get_safe_value($con, $_POST["pincode"]);
    $order_status = 1;
    $coupon_id = get_safe_value($con, $_POST["coupon_id"]);
    $coupon_value = get_safe_value($con, $_POST["coupon_value"]);
    $coupon_code = get_safe_value($con, $_POST["coupon_code"]);
    $amount = get_safe_value($con, $_POST["amount"]) / 100;
    $total_price = get_safe_value($con, $_POST["total_price"]);
    $paymentResultId = get_safe_value($con, $_POST["id"]);
    $paymentResultStatus = "success";
    $order_id = get_safe_value($con, $_POST["razorpay_order_id"]);
    $payment_id = get_safe_value($con, $_POST["razorpay_payment_id"]);
    $signature = get_safe_value($con, $_POST["razorpay_signature"]);

    try {
        $attributes = array(
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        );
        $api->utility->verifyPaymentSignature($attributes);

        $query = "INSERT INTO orders (user_id, address, city, pincode, order_status, coupon_id, coupon_value, coupon_code, total_price, net_price, paymentResultId, paymentResultStatus, paymentResultOrderId, paymentResultPaymentId, paymentResultRazorpaySignature) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('isssissssssssss', $userId, $address, $city, $pincode, $order_status, $coupon_id, $coupon_value, $coupon_code, $total_price, $amount, $paymentResultId, $paymentResultStatus, $order_id, $payment_id, $signature);

        if ($stmt->execute()) {
            $last_order_id = $con->insert_id;

            if (isset($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $key => $val) {
                    foreach ($val as $valKey => $valValue) {
                        $query = "SELECT * FROM product_attributes WHERE id = ?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param('i', $valKey);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $product = $result->fetch_assoc();

                        $price = $valValue["qty"] * $product["price"];

                        $query = "INSERT INTO order_detail (order_id, product_id, product_attr_id, qty, price) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param('iiiii', $last_order_id, $product["product_id"], $product["id"], $valValue["qty"], $price);

                        if ($stmt->execute()) {
                            unset($_SESSION["cart"]);
                            echo "Payment Success";
                        } else {
                            echo "Payment Failed";
                        }
                    }
                }
            }
        } else {
            echo "Payment Failed";
        }
    } catch (SignatureVerificationError $e) {
        echo "Payment Failed: " . $e->getMessage();
    }
}
?>