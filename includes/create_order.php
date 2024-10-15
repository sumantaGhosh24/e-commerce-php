<?php
require "database.php";
require "function.php";
require "constant.php";
require "../vendor/autoload.php";

use Razorpay\Api\Api;

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["cart"])) {
        $net_prices = array();
        $coupon_code = get_safe_value($con, $_POST["coupon_code"]);
        $status = 1;

        foreach ($_SESSION["cart"] as $key => $val) {
            foreach ($val as $valKey => $valValue) {
                $query = "SELECT price FROM product_attributes WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('i', $valKey);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();

                array_push($net_prices, $product["price"] * $valValue["qty"]);
            }
        }

        function calculatePrice($v1, $v2)
        {
            return $v1 + $v2;
        }

        $total_price = array_reduce($net_prices, "calculatePrice", 0);
        $net_price = array_reduce($net_prices, "calculatePrice", 0);

        if ($coupon_code != "") {
            $query = "SELECT * FROM coupons WHERE coupon_code = ? AND status = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $coupon_code, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                if ($net_price > $row["cart_min_value"]) {
                    $net_price = $row["coupon_type"] == "Rupee" ? $net_price - $row["coupon_value"] : $net_price * ((100 - $row["coupon_value"]) / 100);

                    $order = $api->order->create(
                        array(
                            'receipt' => uniqid(),
                            'amount' => $net_price * 100,
                            'currency' => 'INR'
                        )
                    );

                    $response = array(
                        'id' => $order['id'],
                        'amount' => $order['amount'],
                        'currency' => $order['currency'],
                        'key' => RAZORPAY_KEY_ID,
                        'coupon_id' => $row['id'],
                        'coupon_value' => $row['coupon_value'],
                        'coupon_code' => $row['coupon_code'],
                        'total_price' => $total_price
                    );

                    echo json_encode($response);
                } else {
                    $arr = array("status" => "error", "msg" => "Not meet cart minimum value");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Invalid coupon code");
            }
        } else {
            $order = $api->order->create(
                array(
                    'receipt' => uniqid(),
                    'amount' => $net_price * 100,
                    'currency' => 'INR'
                )
            );

            $response = array(
                'id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'key' => RAZORPAY_KEY_ID,
                'coupon_id' => '',
                'coupon_value' => '',
                'coupon_code' => '',
                'total_price' => $total_price
            );

            echo json_encode($response);
        }
    }

}
?>