<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["user"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT r.id, r.product_id, r.user_id, r.rating, r.review, r.createdAt, r.updatedAt, u.name AS user_name, u.email AS user_email FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }

        echo json_encode($reviews);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $product_id = get_safe_value($con, $_POST["product_id"]);
        $user_id = $_SESSION["USER_ID"];
        $rating = get_safe_value($con, $_POST["rating"]);
        $review = get_safe_value($con, $_POST["review"]);

        if ($product_id == "") {
            $arr = array("status" => "error", "msg" => "Product id is required");
        } elseif ($user_id == "") {
            $arr = array("status" => "error", "msg" => "User id is required");
        } elseif ($rating == "") {
            $arr = array("status" => "error", "msg" => "Rating is required");
        } elseif ($review == "") {
            $arr = array("status" => "error", "msg" => "Review is required");
        } else {
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $check = $result->num_rows;

            if ($check > 0) {
                $query = "INSERT INTO reviews (product_id, user_id, rating, review) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('iiss', $product_id, $user_id, $rating, $review);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Review created successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to created review");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Invalid product id");
            }
        }

        echo json_encode($arr);
    }
}
?>