<?php
include "database.php";
include "function.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["my"])) {
    $id = $_SESSION["USER_ID"];

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode($row);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = get_safe_value($con, $_POST['action']);

    if ($action == "update") {
        $id = $_SESSION["USER_ID"];
        $name = get_safe_value($con, $_POST["name"]);

        if ($name === "") {
            $arr = array("status" => "error", "msg" => "First name is required", "field" => "name_error");
        } else {
            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE users SET name = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('si', $name, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Updated user profile", "field" => "form_msg");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed update user profile", "field" => "name_error");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Invalid user id", "field" => "form_msg");
            }
        }

        echo json_encode($arr);
    }
}
?>