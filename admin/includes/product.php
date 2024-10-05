<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT p.id, p.categories_id, p.sub_categories_id, p.title, p.mrp, p.price, p.qty, p.short_desc, p.description, p.best_seller, p.meta_title, p.meta_desc, p.meta_keyword, p.status, p.createdAt, p.updatedAt, c.id as category_id, c.name as category_name, sc.id as sub_id, sc.sub_categories as sub_categories_name FROM products p JOIN categories c ON p.categories_id = c.id JOIN sub_categories sc ON p.sub_categories_id = sc.id WHERE p.id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $query = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productImages = $result->fetch_all(MYSQLI_ASSOC);

        $query = "SELECT pa.id, pa.product_id, pa.size_id, pa.color_id, pa.mrp, pa.price, pa.qty, s.id as size_id, s.size, c.id as color_id, c.color FROM product_attributes pa JOIN sizes as s ON pa.size_id = s.id JOIN colors c ON pa.color_id = c.id WHERE pa.product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productAttributes = $result->fetch_all(MYSQLI_ASSOC);

        $category = [
            "id" => $product["category_id"],
            "name" => $product["category_name"]
        ];

        $sub_category = [
            "id" => $product["sub_id"],
            "sub_categories" => $product["sub_categories_name"]
        ];

        $finalResult = [
            "id" => $product["id"],
            "title" => $product["title"],
            "mrp" => $product["mrp"],
            "price" => $product["price"],
            "qty" => $product["qty"],
            "short_desc" => $product["short_desc"],
            "description" => $product["description"],
            "best_seller" => $product["best_seller"],
            "meta_title" => $product["meta_title"],
            "meta_desc" => $product["meta_desc"],
            "meta_keyword" => $product["meta_keyword"],
            "status" => $product["status"],
            "createdAt" => $product["createdAt"],
            "updatedAt" => $product["updatedAt"],
            "category" => $category,
            "sub_category" => $sub_category,
            "images" => $productImages,
            "attributes" => $productAttributes,
        ];

        echo json_encode($finalResult);
    }

    if (isset($_GET["admin"])) {
        $query = "SELECT p.*, c.name, sc.sub_categories FROM products p JOIN categories c ON p.categories_id = c.id JOIN sub_categories sc ON p.sub_categories_id = sc.id";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        echo json_encode($products);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = get_safe_value($con, $_POST["action"]);

    if ($action == "create") {
        $categories_id = get_safe_value($con, $_POST["categories_id"]);
        $sub_categories_id = get_safe_value($con, $_POST["sub_categories_id"]);
        $title = get_safe_value($con, $_POST["title"]);
        $description = get_safe_value($con, $_POST["description"]);
        $mrp = get_safe_value($con, $_POST["mrp"]);
        $price = get_safe_value($con, $_POST["price"]);
        $qty = get_safe_value($con, $_POST["qty"]);
        $short_desc = get_safe_value($con, $_POST["short_desc"]);
        $meta_title = get_safe_value($con, $_POST["meta_title"]);
        $meta_desc = get_safe_value($con, $_POST["meta_desc"]);
        $meta_keyword = get_safe_value($con, $_POST["meta_keyword"]);
        $best_seller = get_safe_value($con, $_POST["best_seller"]);
        $status = "1";

        if ($categories_id == "") {
            $arr = array("status" => "error", "msg" => "Category id is required");
        } elseif ($sub_categories_id == "") {
            $arr = array("status" => "error", "msg" => "Sub category id is required");
        } elseif ($title == "") {
            $arr = array("status" => "error", "msg" => "Product title is required");
        } elseif ($description == "") {
            $arr = array("status" => "error", "msg" => "Product description is required");
        } elseif ($mrp == "") {
            $arr = array("status" => "error", "msg" => "Product mrp is required");
        } elseif ($price == "") {
            $arr = array("status" => "error", "msg" => "Product price is required");
        } elseif ($qty == "") {
            $arr = array("status" => "error", "msg" => "Product quantity is required");
        } elseif ($short_desc == "") {
            $arr = array("status" => "error", "msg" => "Product short description is required");
        } elseif ($meta_title == "") {
            $arr = array("status" => "error", "msg" => "Product meta title is required");
        } elseif ($meta_desc == "") {
            $arr = array("status" => "error", "msg" => "Product meta description is required");
        } elseif ($meta_keyword == "") {
            $arr = array("status" => "error", "msg" => "Product meta keyword is required");
        } elseif ($best_seller == "") {
            $arr = array("status" => "error", "msg" => "Product best seller is required");
        } else {
            $targetDir = "../../uploads/";
            $fileType = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
            $fileName = uniqid() . "." . $fileType;
            $targetFilePath = $targetDir . $fileName;

            if (!empty($_FILES["file"]["name"])) {
                $allowTypes = array("jpg", "png", "jpeg");
                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                        $query = "INSERT INTO products (categories_id, sub_categories_id, title, description, mrp, price, qty, short_desc, meta_title, meta_desc, meta_keyword, best_seller, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param('sssssssssssss', $categories_id, $sub_categories_id, $title, $description, $mrp, $price, $qty, $short_desc, $meta_title, $meta_desc, $meta_keyword, $best_seller, $status);

                        if ($stmt->execute()) {
                            $last_product_id = $con->insert_id;
                            $query = "INSERT INTO product_images (product_id, image) VALUES (?, ?)";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param('is', $last_product_id, $fileName);

                            if ($stmt->execute()) {
                                $arr = array("status" => "success", "msg" => "Product created successful");
                            } else {
                                $arr = array("status" => "error", "msg" => "Failed to create product");
                            }
                        } else {
                            $arr = array("status" => "error", "msg" => "Failed to create product");
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
        $id = get_safe_value($con, $_POST["id"]);
        $categories_id = get_safe_value($con, $_POST["categories_id"]);
        $sub_categories_id = get_safe_value($con, $_POST["sub_categories_id"]);
        $title = get_safe_value($con, $_POST["title"]);
        $description = get_safe_value($con, $_POST["description"]);
        $mrp = get_safe_value($con, $_POST["mrp"]);
        $price = get_safe_value($con, $_POST["price"]);
        $qty = get_safe_value($con, $_POST["qty"]);
        $short_desc = get_safe_value($con, $_POST["short_desc"]);
        $meta_title = get_safe_value($con, $_POST["meta_title"]);
        $meta_desc = get_safe_value($con, $_POST["meta_desc"]);
        $meta_keyword = get_safe_value($con, $_POST["meta_keyword"]);
        $best_seller = get_safe_value($con, $_POST["best_seller"]);
        $status = get_safe_value($con, $_POST["status"]);

        if ($categories_id == "") {
            $arr = array("status" => "error", "msg" => "Category id is required");
        } elseif ($sub_categories_id == "") {
            $arr = array("status" => "error", "msg" => "Sub category id is required");
        } elseif ($title == "") {
            $arr = array("status" => "error", "msg" => "Product title is required");
        } elseif ($description == "") {
            $arr = array("status" => "error", "msg" => "Product description is required");
        } elseif ($mrp == "") {
            $arr = array("status" => "error", "msg" => "Product mrp is required");
        } elseif ($price == "") {
            $arr = array("status" => "error", "msg" => "Product price is required");
        } elseif ($qty == "") {
            $arr = array("status" => "error", "msg" => "Product quantity is required");
        } elseif ($short_desc == "") {
            $arr = array("status" => "error", "msg" => "Product short description is required");
        } elseif ($meta_title == "") {
            $arr = array("status" => "error", "msg" => "Product meta title is required");
        } elseif ($meta_desc == "") {
            $arr = array("status" => "error", "msg" => "Product meta description is required");
        } elseif ($meta_keyword == "") {
            $arr = array("status" => "error", "msg" => "Product meta keyword is required");
        } elseif ($best_seller == "") {
            $arr = array("status" => "error", "msg" => "Product best seller is required");
        } elseif ($status == "") {
            $arr = array("status" => "error", "msg" => "Product status is required");
        } else {
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "UPDATE products SET categories_id = ?, sub_categories_id = ?, title = ?, description = ?, mrp = ?, price = ?, qty = ?, short_desc = ?, meta_title = ?, meta_desc = ?, meta_keyword = ?, best_seller = ?, status = ? WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssssssssssssi', $categories_id, $sub_categories_id, $title, $description, $mrp, $price, $qty, $short_desc, $meta_title, $meta_desc, $meta_keyword, $best_seller, $status, $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Product updated successful");
                } else {
                    $arr = array("status" => "error", "msg" => 'Failed to update product');
                }
            } else {
                $arr = array("status" => "error", "msg" => "Product id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "add") {
        $id = get_safe_value($con, $_POST["id"]);

        if ($id == "") {
            $arr = array("status" => "error", "msg" => "Product id is required");
        } else {
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $targetDir = "../../uploads/";
                $fileType = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
                $fileName = uniqid() . "." . $fileType;
                $targetFilePath = $targetDir . $fileName;

                if (!empty($_FILES["file"]["name"])) {
                    $allowTypes = array("jpg", "png", "jpeg");
                    if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                            $query = "INSERT INTO product_images (product_id, image) VALUES(?, ?)";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param('is', $id, $fileName);

                            if ($stmt->execute()) {
                                $arr = array("status" => "success", "msg" => "Product image added successful");
                            } else {
                                $arr = array("status" => "error", "msg" => "Failed to add product image");
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
            } else {
                $arr = array("status" => "error", "msg" => "Product id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "remove") {
        $id = get_safe_value($con, $_POST["id"]);

        if ($id == "") {
            $arr = array("status" => "error", "msg" => "Image id is required");
        } else {
            $query = "SELECT * FROM product_images WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $check = $result->num_rows;

            if ($check > 0) {
                if (gettype($row["image"]) == "string") {
                    $file = "../../uploads/" . $row["image"];

                    if (file_exists($file)) {
                        unlink($file);
                    } else {
                        $arr = array("status" => "error", "msg" => "File does not exist");
                    }
                }

                $query = "DELETE FROM product_images WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('i', $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Product image removed");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to remove product image");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Image id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "add-attribute") {
        $id = get_safe_value($con, $_POST["id"]);
        $size_id = get_safe_value($con, $_POST["size_id"]);
        $color_id = get_safe_value($con, $_POST["color_id"]);
        $mrp = get_safe_value($con, $_POST["mrp"]);
        $price = get_safe_value($con, $_POST["price"]);
        $qty = get_safe_value($con, $_POST["qty"]);

        if ($id == "") {
            $arr = array("status" => "error", "msg" => "Product id is required");
        } elseif ($size_id == "") {
            $arr = array("status" => "error", "msg" => "Attribute size id is required");
        } elseif ($color_id == "") {
            $arr = array("status" => "error", "msg" => "Attribute color id is required");
        } elseif ($mrp == "") {
            $arr = array("status" => "error", "msg" => "Attribute mrp is required");
        } elseif ($price == "") {
            $arr = array("status" => "error", "msg" => "Attribute price is required");
        } elseif ($qty == "") {
            $arr = array("status" => "error", "msg" => "Attribute qty is required");
        } else {
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $query = "INSERT INTO product_attributes (product_id, size_id, color_id, mrp, price, qty) VALUES(?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('iiiiii', $id, $size_id, $color_id, $mrp, $price, $qty);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Product Attribute successful");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to add product attribute");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Product id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "remove-attribute") {
        $id = get_safe_value($con, $_POST["id"]);

        if ($id == "") {
            $arr = array("status" => "error", "msg" => "Attribute id is required");
        } else {
            $query = "SELECT * FROM product_attributes WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $check = $result->num_rows;

            if ($check > 0) {
                $query = "DELETE FROM product_attributes WHERE id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('i', $id);

                if ($stmt->execute()) {
                    $arr = array("status" => "success", "msg" => "Product attribute removed");
                } else {
                    $arr = array("status" => "error", "msg" => "Failed to remove product attribute");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Attribute id is invalid");
            }
        }

        echo json_encode($arr);
    }

    if ($action == "delete") {
        $id = get_safe_value($con, $_POST["id"]);

        if ($id == "") {
            $arr = array("status" => "error", "msg" => "Product id is required");
        } else {
            $query = "SELECT image FROM product_images WHERE product_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $images = [];
            while ($row = $result->fetch_assoc()) {
                $images[] = $row["image"];
            }

            $query = "DELETE FROM product_images WHERE product_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $query = "DELETE FROM product_attributes WHERE product_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('i', $id);

                if ($stmt->execute()) {
                    $query = "DELETE FROM products WHERE id = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param('i', $id);

                    if ($stmt->execute()) {
                        foreach ($images as $imageFilename) {
                            $imagePath = "../../uploads/" . $imageFilename;
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                        }

                        $arr = array("status" => "success", "msg" => "Product deleted successful");
                    } else {
                        $arr = array("status" => "error", "msg" => "Unable to delete product");
                    }
                } else {
                    $arr = array("status" => "error", "msg" => "Unable to delete product image");
                }
            } else {
                $arr = array("status" => "error", "msg" => "Unable to delete product image");
            }
        }

        echo json_encode($arr);
    }
}
?>