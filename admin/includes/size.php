<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT * FROM sizes WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT * FROM sizes ORDER BY order_by ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $sizes = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $sizes[] = $row;
            }
        }

        echo json_encode($sizes);
    }

    if (isset($_GET["get"])) {
        $query = "SELECT * FROM sizes WHERE status = '1'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $sizes = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $sizes[] = $row;
            }
        }

        echo json_encode($sizes);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $size = get_safe_value($con, $_POST["size"]);
        $order_by = get_safe_value($con, $_POST["order_by"]);
        $status = "1";

        if ($size == "") {
            $arr = array("status" => "error", "msg" => "Size is required");
        }
        if ($order_by == "") {
            $arr = array("status" => "error", "msg" => "Order is required");
        } else {
            $query = "SELECT * FROM sizes WHERE size = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $size);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $arr = array("status" => "error", "msg" => "Size already registered");
            } else {
                $query = "INSERT INTO sizes (size, order_by, status) VALUES (?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sss', $size, $order_by, $status);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Size created successful");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to create size");
                }
            }
        }

        echo json_encode($arr);
    }

    if ($action == "update") {
        $size = get_safe_value($con, $_POST["size"]);
        $order_by = get_safe_value($con, $_POST["order_by"]);
        $status = get_safe_value($con, $_POST["status"]);
        $id = get_safe_value($con, $_POST["id"]);

        if ($size == "") {
            $arr = array("status" => "error", "msg" => "Size is required");
        } elseif ($order_by == "") {
            $arr = array("status" => "error", "msg" => "Size order required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Size status is required");
        } else {
            $query = "SELECT * FROM sizes WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE sizes SET size = ?, order_by = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssi', $size, $order_by, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Size updated successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to update size");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Size id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM sizes WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM sizes WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Size deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete size");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid size id");
        }

        echo json_encode($arr);
    }
}
?>