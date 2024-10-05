<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["admin"])) {
        $query = "SELECT * FROM contact_us ORDER BY createdAt DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $contact = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $contact[] = $row;
            }
        }

        echo json_encode($contact);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);
    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM contact_us WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM contact_us WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Contact deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete contact");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid contact id");
        }

        echo json_encode($arr);
    }
}
?>