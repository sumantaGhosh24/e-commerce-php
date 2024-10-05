<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT * FROM colors WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT * FROM colors ORDER BY color ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $colors = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $colors[] = $row;
            }
        }

        echo json_encode($colors);
    }

    if (isset($_GET["get"])) {
        $query = "SELECT * FROM colors WHERE status = '1'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $colors = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $colors[] = $row;
            }
        }

        echo json_encode($colors);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $color = get_safe_value($con, $_POST["color"]);
        $status = "1";

        if ($color == "") {
            $arr = array("status" => "error", "msg" => "Color is required");
        } else {
            $query = "SELECT * FROM colors WHERE color = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $color);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $arr = array("status" => "error", "msg" => "Color already registered");
            } else {
                $query = "INSERT INTO colors (color, status) VALUES (?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss', $color, $status);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Color created successful");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to create color");
                }
            }
        }

        echo json_encode($arr);
    }

    if ($action == "update") {
        $color = get_safe_value($con, $_POST["color"]);
        $status = get_safe_value($con, $_POST["status"]);
        $id = get_safe_value($con, $_POST["id"]);

        if ($color == "") {
            $arr = array("status" => "error", "msg" => "Color is required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Color status is required");
        } else {
            $query = "SELECT * FROM colors WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE colors SET color = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ssi', $color, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Color updated successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to update color");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Color id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM colors WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM colors WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Color deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete color");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid color id");
        }

        echo json_encode($arr);
    }
}
?>