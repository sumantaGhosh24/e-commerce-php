<?php
include "database.php";
include "function.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["all"])) {
    $query = "SELECT * FROM banners WHERE status = 1 ORDER BY order_no ASC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $banners = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $banners[] = $row;
        }
    }

    echo json_encode($banners);
}
?>