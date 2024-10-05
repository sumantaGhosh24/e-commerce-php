<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT * FROM sub_categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT sub_categories.*, categories.name FROM sub_categories, categories WHERE categories.id = sub_categories.categories_id ORDER BY sub_categories.sub_categories ASC";
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
        $categories_id = get_safe_value($con, $_GET["categories_id"]);
        $status = "1";

        $query = "SELECT * FROM sub_categories WHERE categories_id = ? AND status = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $categories_id, $status);
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
        $categories_id = get_safe_value($con, $_POST["categories_id"]);
        $sub_categories = get_safe_value($con, $_POST["sub_categories"]);
        $status = "1";

        if ($categories_id == "") {
            $arr = array("status" => "error", "msg" => "Category id is required");
        } elseif ($sub_categories == "") {
            $arr = array("status" => "error", "msg" => "Sub categories is required");
        } else {
            $query = "SELECT * FROM sub_categories WHERE categories_id = ? AND sub_categories = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ss', $categories_id, $sub_categories);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $arr = array("status" => "error", "msg" => "Sub category already registered");
            } else {
                $query = "INSERT INTO sub_categories (categories_id, sub_categories, status) VALUES (?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sss', $categories_id, $sub_categories, $status);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Sub category created successful");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to create sub category");
                }
            }
        }

        echo json_encode($arr);
    }

    if ($action == "update") {
        $categories_id = get_safe_value($con, $_POST["categories_id"]);
        $sub_categories = get_safe_value($con, $_POST["sub_categories"]);
        $status = get_safe_value($con, $_POST["status"]);
        $id = get_safe_value($con, $_POST["id"]);

        if ($categories_id == "") {
            $arr = array("status" => "error", "msg" => "Categories id is required");
        } elseif ($sub_categories == "") {
            $arr = array("status" => "error", "msg" => "Sub categories is required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Sub categories status is required");
        } else {
            $query = "SELECT * FROM sub_categories WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE sub_categories SET categories_id = ?, sub_categories = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssi', $categories_id, $sub_categories, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Sub category updated successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to update sub category");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Sub category id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM sub_categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM sub_categories WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Sub Category deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete sub category");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid sub category id");
        }

        echo json_encode($arr);
    }
}
?>