<?php
require 'database.php';
require 'function.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = get_safe_value($con, $_POST["email"]);
    $password = get_safe_value($con, $_POST["password"]);

    if ($email == "") {
        $arr = array("status" => "error", "msg" => "Email is required", "field" => "email_error");
    } elseif ($password == "") {
        $arr = array("status" => "error", "msg" => "Password is required", "field" => "password_error");
    } else {
        $query = "SELECT * FROM admin_users WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row["status"] != "1") {
                $arr = array("status" => "error", "msg" => "Account deactivated", "field" => "email_error");
            } else {
                if (password_verify($password, $row['password'])) {
                    $_SESSION["ADMIN_ID"] = $row["id"];
                    $_SESSION["ADMIN_LOGIN"] = "yes";

                    $arr = array("status" => "success", "msg" => "Login success", "field" => "form_msg");
                } else {
                    $arr = array("status" => "error", "msg" => "Invalid login credential", "field" => "email_error");
                }
            }
        } else {
            $arr = array("status" => "error", "msg" => "Please enter a valid email address", "field" => "email_error");
        }
    }

    echo json_encode($arr);
}
?>