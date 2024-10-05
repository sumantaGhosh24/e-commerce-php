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

    if (isset($_GET["admin"])) {
        $query = "SELECT orders.*, order_status.name as order_status_str FROM orders, order_status WHERE order_status.id = orders.order_status ORDER BY orders.id DESC";
        $stmt = $con->prepare($query);
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

    if (isset($_GET["status"])) {
        $query = "SELECT * FROM order_status";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $order_status = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $order_status[] = $row;
            }
        }

        echo json_encode($order_status);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "update") {
        $id = get_safe_value($con, $_POST["id"]);
        $status = get_safe_value($con, $_POST["status"]);

        if ($status == "") {
            $arr = array("status" => "error", "msg" => "Order status is required");
        } else {
            $query = "SELECT * FROM orders WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE orders SET order_status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('si', $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Order updated successful");
                } else {
                    $arr = array("status" => "error", "msg" => 'Failed to update order');
                }
            } else {
                $arr = array("status" => "error", "msg" => "Order id is invalid");
            }
        }

        echo json_encode($arr);
    }
}
?>