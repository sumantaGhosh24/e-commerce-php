<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT * FROM categories ORDER BY name ASC";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $name = get_safe_value($con, $_POST["name"]);
        $status = "1";

        if ($name == "") {
            $arr = array("status" => "error", "msg" => "Category name is required");
        } else {
            $query = "SELECT * FROM categories WHERE name = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $arr = array("status" => "error", "msg" => "Category name already registered");
            } else {
                $query = "INSERT INTO categories (name, status) VALUES (?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss', $name, $status);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Category created successful");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to create category");
                }
            }
        }

        echo json_encode($arr);
    }

    if ($action == "update") {
        $name = get_safe_value($con, $_POST["name"]);
        $status = get_safe_value($con, $_POST["status"]);
        $id = get_safe_value($con, $_POST["id"]);

        if ($name == "") {
            $arr = array("status" => "error", "msg" => "Category name is required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Category status is required");
        } else {
            $query = "SELECT * FROM categories WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE categories SET name = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ssi', $name, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Category updated successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to update category");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Category id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM categories WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Category deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete category");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid category id");
        }

        echo json_encode($arr);
    }
}
?>