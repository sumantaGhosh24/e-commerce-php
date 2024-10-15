<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = get_safe_value($con, $_POST["name"]);
    $email = get_safe_value($con, $_POST["email"]);
    $mobile = get_safe_value($con, $_POST["mobile"]);
    $message = get_safe_value($con, $_POST["message"]);

    if ($name == "") {
        $arr = array("status" => "error", "msg" => "Name is required");
    } elseif ($email == "") {
        $arr = array("status" => "error", "msg" => "Email address is required");
    } elseif ($mobile == "") {
        $arr = array("status" => "error", "msg" => "Mobile number is required");
    } elseif ($message == "") {
        $arr = array("status" => "error", "msg" => "Message is required");
    } else {
        $query = "INSERT INTO contact_us (name, email, mobile, message) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssss', $name, $email, $mobile, $message);

        if ($stmt->execute()) {
            $arr = array("status" => "success", "msg" => "Your message delivered successfully");
        } else {
            $arr = array("status" => "error", "msg" => "Failed to delivered message");
        }
    }

    echo json_encode($arr);
}
?>