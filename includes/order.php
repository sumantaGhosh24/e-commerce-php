<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT o.*, u.name AS user_name, u.email AS user_email, os.name AS order_status_name FROM orders o JOIN users u ON o.user_id = u.id JOIN order_status os ON o.order_status = os.id WHERE o.id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $order_result = $stmt->get_result();
        $order = $order_result->fetch_assoc();

        $order_detail_query = "SELECT od.*, p.title AS product_title, p.short_desc AS product_description, (SELECT pi.image FROM product_images pi WHERE pi.product_id = p.id LIMIT 1) AS product_image, c.name AS category_name, sc.sub_categories AS sub_category_name, pa.mrp AS attribute_mrp, pa.price AS attribute_price, clr.color AS color_name, sz.size AS size_name FROM order_detail od JOIN products p ON od.product_id = p.id JOIN categories c ON p.categories_id = c.id JOIN sub_categories sc ON p.sub_categories_id = sc.id JOIN product_attributes pa ON od.product_attr_id = pa.id JOIN colors clr ON pa.color_id = clr.id JOIN sizes sz ON pa.size_id = sz.id WHERE od.order_id = ?";
        $stmt_details = $con->prepare($order_detail_query);
        $stmt_details->bind_param("i", $id);
        $stmt_details->execute();
        $order_details_result = $stmt_details->get_result();

        $order_details = [];
        while ($detail = $order_details_result->fetch_assoc()) {
            $order_details[] = $detail;
        }

        echo json_encode([
            'order' => $order,
            'order_details' => $order_details
        ]);
    }

    if (isset($_GET["user"])) {
        $id = $_SESSION["USER_ID"];

        $query = "SELECT o.*, os.name AS order_status_str FROM orders o JOIN order_status os ON o.order_status = os.id WHERE o.user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }

        echo json_encode($orders);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "verify") {
        $coupon_code = get_safe_value($con, $_POST["coupon_code"]);
        $cart_price = get_safe_value($con, $_POST["cart_price"]);
        $status = "1";

        if ($coupon_code == "") {
            $arr = array("status" => "error", "msg" => "Coupon code is required");
        } else {
            $query = "SELECT * FROM coupons WHERE coupon_code = ? AND status = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $coupon_code, $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                if ($cart_price > $row["cart_min_value"]) {
                    $arr = array("status" => "success", "data" => $row);
                } else {
                    $arr = array("status" => "error", "msg" => "Not meet cart minimum value");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Invalid coupon code");
            }
        }

        echo json_encode($arr);
    }
}
?>