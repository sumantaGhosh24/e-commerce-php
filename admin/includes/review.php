<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["admin"])) {
        $query = "SELECT users.name, users.email, reviews.id, reviews.rating, reviews.review, reviews.createdAt, reviews.updatedAt, products.title AS pname FROM users, reviews, products WHERE reviews.user_id = users.id AND reviews.product_id = products.id  ORDER BY reviews.createdAt DESC";
        $stmt = $con->prepare($query);
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

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM reviews WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM reviews WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Review deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete review");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid review id");
        }

        echo json_encode($arr);
    }
}
?>