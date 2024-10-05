<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT * FROM coupons WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT * FROM coupons";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $coupons = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $coupons[] = $row;
            }
        }

        echo json_encode($coupons);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $coupon_code = get_safe_value($con, $_POST["coupon_code"]);
        $coupon_type = get_safe_value($con, $_POST["coupon_type"]);
        $coupon_value = get_safe_value($con, $_POST["coupon_value"]);
        $cart_min_value = get_safe_value($con, $_POST["cart_min_value"]);
        $status = "1";

        if ($coupon_code == "") {
            $arr = array("status" => "error", "msg" => "Coupon code is required");
        } elseif ($coupon_type == "") {
            $arr = array("status" => "error", "msg" => "Coupon type is required");
        } elseif ($coupon_value == "") {
            $arr = array("status" => "error", "msg" => "Coupon value is required");
        } elseif ($cart_min_value == "") {
            $arr = array("status" => "error", "msg" => "Cart minimum value is required");
        } else {
            $query = "SELECT * FROM coupons WHERE coupon_code = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('s', $coupon_code);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $arr = array("status" => "error", "msg" => "Coupon code already registered");
            } else {
                $query = "INSERT INTO coupons (coupon_code, coupon_value, coupon_type, cart_min_value, status) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssss', $coupon_code, $coupon_value, $coupon_type, $cart_min_value, $status);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Coupon created successful");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to create coupon");
                }
            }
        }

        echo json_encode($arr);
    }

    if ($action == "update") {
        $coupon_code = get_safe_value($con, $_POST["coupon_code"]);
        $coupon_type = get_safe_value($con, $_POST["coupon_type"]);
        $coupon_value = get_safe_value($con, $_POST["coupon_value"]);
        $cart_min_value = get_safe_value($con, $_POST["cart_min_value"]);
        $status = get_safe_value($con, $_POST["status"]);
        $id = get_safe_value($con, $_POST["id"]);

        if ($coupon_code == "") {
            $arr = array("status" => "error", "msg" => "Coupon code is required");
        } elseif ($coupon_type == "") {
            $arr = array("status" => "error", "msg" => "Coupon type is required");
        } elseif ($coupon_value == "") {
            $arr = array("status" => "error", "msg" => "Coupon value is required");
        } elseif ($cart_min_value == "") {
            $arr = array("status" => "error", "msg" => "Cart minimum value is required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Coupon status is required");
        } else {
            $query = "SELECT * FROM coupons WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE coupons SET coupon_code = ?, coupon_value = ?, coupon_type = ?, cart_min_value = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssssi', $coupon_code, $coupon_value, $coupon_type, $cart_min_value, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Coupon updated successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to update coupon");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Coupon id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM coupons WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check = $result->num_rows;

        if ($check > 0) {
            $query = "DELETE FROM coupons WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Coupon deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete coupon");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid coupon id");
        }

        echo json_encode($arr);
    }
}
?>