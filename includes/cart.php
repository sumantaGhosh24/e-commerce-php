<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $finalResult = [];

    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $key => $val) {
            foreach ($val as $valKey => $valValue) {
                $query = "SELECT pa.id, pa.product_id, pa.size_id, pa.color_id, pa.mrp, pa.price, pa.qty, s.id AS size_id, s.size, c.id AS color_id, c.color, (SELECT pi.image FROM product_images pi WHERE pi.product_id = pa.product_id LIMIT 1) AS product_image, p.id AS product_id, p.title AS product_title FROM product_attributes pa JOIN sizes AS s ON pa.size_id = s.id JOIN colors c ON pa.color_id = c.id JOIN products p ON pa.product_id = p.id WHERE pa.id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('i', $valKey);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();

                $attribute = [
                    "id" => $product["id"],
                    "product_id" => $product["product_id"],
                    "size_id" => $product["size_id"],
                    "size" => $product["size"],
                    "color_id" => $product["color_id"],
                    "color" => $product["color"],
                    "mrp" => $product["mrp"],
                    "price" => $product["price"],
                    "qty" => $product["qty"]
                ];

                $product = [
                    "id" => $product["product_id"],
                    "title" => $product["product_title"],
                    "image" => $product["product_image"]
                ];

                $finalResult[] = [
                    "product" => $product,
                    "attribute" => $attribute,
                    "qty" => $valValue["qty"]
                ];
            }
        }
    }

    echo json_encode($finalResult);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "add") {
        $product_id = get_safe_value($con, $_POST["product_id"]);
        $attribute_id = get_safe_value($con, $_POST["attribute_id"]);
        $quantity = get_safe_value($con, $_POST["quantity"]);

        $_SESSION["cart"][$product_id][$attribute_id]["qty"] = $quantity;
    }

    if ($action == "update") {
        $product_id = get_safe_value($con, $_POST["product_id"]);
        $attribute_id = get_safe_value($con, $_POST["attribute_id"]);
        $quantity = get_safe_value($con, $_POST["quantity"]);

        if (isset($_SESSION["cart"][$product_id][$attribute_id])) {
            $_SESSION["cart"][$product_id][$attribute_id]["qty"] = $quantity;
        }
    }

    if ($action == "remove") {
        $product_id = get_safe_value($con, $_POST["product_id"]);
        $attribute_id = get_safe_value($con, $_POST["attribute_id"]);

        if (isset($_SESSION["cart"][$product_id][$attribute_id])) {
            unset($_SESSION["cart"][$product_id][$attribute_id]);
        }
    }

    if ($action == "clear") {
        unset($_SESSION["cart"]);
    }
}
?>