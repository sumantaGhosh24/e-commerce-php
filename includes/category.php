<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["get"])) {
        $query = "SELECT * FROM categories WHERE status = '1'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        echo json_encode($categories);
    }
}
?>