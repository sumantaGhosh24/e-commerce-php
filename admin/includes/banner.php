<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT * FROM banners WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT * FROM banners ORDER BY order_no ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $banners = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $banners[] = $row;
            }
        }

        echo json_encode($banners);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $heading1 = get_safe_value($con, $_POST["heading1"]);
        $heading2 = get_safe_value($con, $_POST["heading2"]);
        $btn_txt = get_safe_value($con, $_POST["btn_txt"]);
        $btn_link = get_safe_value($con, $_POST["btn_link"]);
        $order_no = get_safe_value($con, $_POST["order_no"]);
        $status = "1";

        if ($heading1 == "") {
            $arr = array("status" => "error", "msg" => "Banner heading 1 is required");
        } elseif ($heading2 == "") {
            $arr = array("status" => "error", "msg" => "Banner heading 2 is required");
        } elseif ($btn_txt == "") {
            $arr = array("status" => "error", "msg" => "Banner button text is required");
        } elseif ($btn_link == "") {
            $arr = array("status" => "error", "msg" => "Banner button link is required");
        } elseif ($order_no == "") {
            $arr = array("status" => "error", "msg" => "Banner Order no is required");
        } else {
            $targetDir = "../../uploads/";
            $fileType = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
            $fileName = uniqid() . "." . $fileType;
            $targetFilePath = $targetDir . $fileName;

            if (!empty($_FILES["file"]["name"])) {
                $allowTypes = array("jpg", "png", "jpeg");
                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                        $query = "INSERT INTO banners (heading1, heading2, btn_txt, btn_link, image, status, order_no) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param('sssssss', $heading1, $heading2, $btn_txt, $btn_link, $fileName, $status, $order_no);

                        if ($stmt->execute()) {
                            $arr = array("status" => "success", "msg" => "Banner created successful");
                        } else {
                            $arr = array("status" => "error", "msg" => "Failed to create banner");
                        }
                    } else {
                        $arr = array("status" => "error", "msg" => "There is something wrong, when upload your image");
                    }
                } else {
                    $arr = array("status" => "error", "msg" => "Select a valid image type(jpg, jpeg and png required)");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Select a image first");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "update") {
        $heading1 = get_safe_value($con, $_POST["heading1"]);
        $heading2 = get_safe_value($con, $_POST["heading2"]);
        $btn_txt = get_safe_value($con, $_POST["btn_txt"]);
        $btn_link = get_safe_value($con, $_POST["btn_link"]);
        $order_no = get_safe_value($con, $_POST["order_no"]);
        $status = get_safe_value($con, $_POST["status"]);
        $id = get_safe_value($con, $_POST["id"]);

        if ($heading1 == "") {
            $arr = array("status" => "error", "msg" => "Banner heading 1 is required");
        } elseif ($heading2 == "") {
            $arr = array("status" => "error", "msg" => "Banner heading 2 is required");
        } elseif ($btn_txt == "") {
            $arr = array("status" => "error", "msg" => "Banner button text is required");
        } elseif ($btn_link == "") {
            $arr = array("status" => "error", "msg" => "Banner button link is required");
        } elseif ($order_no == "") {
            $arr = array("status" => "error", "msg" => "Banner Order no is required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Banner status is required");
        } else {
            $query = "SELECT * FROM banners WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE banners SET heading1 = ?, heading2 = ?, btn_txt = ?, btn_link = ?, order_no = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ssssssi', $heading1, $heading2, $btn_txt, $btn_link, $order_no, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Banner updated successfully");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to update banner");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Banner id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        $query = "SELECT * FROM banners WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $check = $result->num_rows;

        if ($check > 0) {
            if (gettype($row["image"]) == "string") {
                $file = '../../uploads/' . $row["image"];

                if (file_exists($file)) {
                    unlink($file);
                } else {
                    $arr = array("status" => "error", "msg" => "File does not exist");
                }
            }

            $query = "DELETE FROM banners WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $arr = array("status" => "success", "msg" => "Banner deleted successfully");
            } else {
                $arr = array("status" => "error", "msg" => "Failed to delete banner");
            }
        } else {
            $arr = array("status" => "error", "msg" => "Invalid banner id");
        }

        echo json_encode($arr);
    }
}
?>