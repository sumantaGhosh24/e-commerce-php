<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "register") {
        $name = $con->real_escape_string($_POST["name"]);
        $email = $con->real_escape_string($_POST["email"]);
        $mobile = $con->real_escape_string($_POST["mobile"]);
        $password = $con->real_escape_string($_POST["password"]);
        $cf_password = $con->real_escape_string($_POST["cf_password"]);

        if ($name === "") {
            $arr = array("status" => "error", "msg" => "First name is required", "field" => "name_error");
        } elseif ($email === "") {
            $arr = array("status" => "error", "msg" => "Email is required", "field" => "email_error");
        } elseif ($mobile === "") {
            $arr = array("status" => "error", "msg" => "Mobile number is required", "field" => "mobile_error");
        } elseif (strlen($password) < 6) {
            $arr = array("status" => "error", "msg" => "Password length minimum 6", "field" => "password_error");
        } elseif ($password !== $cf_password) {
            $arr = array("status" => "error", "msg" => "Password and confirm password not match", "field" => "cf_password_error");
        } else {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $arr = array('status' => 'error', 'msg' => 'Email id already registered', 'field' => 'email_error');
            } else {
                $new_password = password_hash($password, PASSWORD_BCRYPT);

                $query = "INSERT INTO users (name, mobile, email, password) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ssss', $name, $mobile, $email, $new_password);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Registration success", "field" => "form_msg");
                } else {
                    $arr = array("status" => "error", "msg" => "Register failed", "field" => "email_error");
                }
            }
        }

        echo json_encode($arr);
    }

    if ($action == "login") {
        $email = $con->real_escape_string($_POST["email"]);
        $password = $con->real_escape_string($_POST["password"]);

        if ($email === "") {
            $arr = array("status" => "error", "msg" => "Email is required", "field" => "email_error");
        } elseif ($password === "") {
            $arr = array("status" => "error", "msg" => "Password is required", "field" => "password_error");
        } else {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    $_SESSION["USER_LOGIN"] = "yes";
                    $_SESSION["USER_ID"] = $row["id"];
                    $_SESSION["USER_NAME"] = $row["name"];

                    $arr = array("status" => "success", "msg" => "Login success", "field" => "form_msg");
                } else {
                    $arr = array("status" => "error", "msg" => "Invalid login credential", "field" => "email_error");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Please enter a valid email address", "field" => "email_error");
            }
        }

        echo json_encode($arr);
    }
}
?>