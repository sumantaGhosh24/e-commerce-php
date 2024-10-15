<?php
include "database.php";
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = get_safe_value($con, $_GET["id"]);

        $query = "SELECT products.*, categories.name AS category_name, sub_categories.sub_categories AS sub_category_name FROM products LEFT JOIN categories ON products.categories_id = categories.id LEFT JOIN sub_categories ON products.sub_categories_id = sub_categories.id WHERE products.id = ? AND products.status = 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $query = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productImages = $result->fetch_all(MYSQLI_ASSOC);

        $query = "SELECT product_attributes.*, sizes.size as size_name, colors.color as color_name FROM product_attributes LEFT JOIN sizes ON product_attributes.size_id = sizes.id LEFT JOIN colors ON product_attributes.color_id = colors.id WHERE product_attributes.product_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productAttributes = $result->fetch_all(MYSQLI_ASSOC);

        $category = [
            "name" => $product["category_name"]
        ];

        $sub_category = [
            "name" => $product["sub_category_name"]
        ];

        $finalResult = [
            "id" => $product["id"],
            "title" => $product["title"],
            "description" => $product["description"],
            "short_desc" => $product["short_desc"],
            "meta_title" => $product["meta_title"],
            "meta_desc" => $product["meta_desc"],
            "meta_keyword" => $product["meta_keyword"],
            "mrp" => $product["mrp"],
            "price" => $product["price"],
            "qty" => $product["qty"],
            "best_seller" => $product["best_seller"],
            "status" => $product["status"],
            "createdAt" => $product["createdAt"],
            "updatedAt" => $product["updatedAt"],
            "category" => $category,
            "sub_category" => $sub_category,
            "images" => $productImages,
            "attributes" => $productAttributes
        ];

        echo json_encode($finalResult);
    }

    if (isset($_GET["all"])) {
        $cat_id = get_safe_value($con, $_GET["cat_id"]);
        $sub_categories = get_safe_value($con, $_GET["sub_categories"]);
        $search_str = get_safe_value($con, $_GET["search_str"]);
        $is_best_seller = get_safe_value($con, $_GET["is_best_seller"]);
        $page = isset($_GET['page']) ? get_safe_value($con, $_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? get_safe_value($con, $_GET['limit']) : 10;
        $offset = ($page - 1) * $limit;

        $query1 = "SELECT COUNT(*) AS total FROM products WHERE products.status = 1";
        $query2 = "SELECT products.*, categories.name AS category_name, sub_categories.sub_categories AS sub_category_name FROM products LEFT JOIN categories ON products.categories_id = categories.id LEFT JOIN sub_categories ON products.sub_categories_id = sub_categories.id WHERE products.status = 1";

        if ($cat_id != '') {
            $query1 .= " AND products.categories_id = $cat_id ";
            $query2 .= " AND products.categories_id = $cat_id ";
        }
        if ($sub_categories != '') {
            $query1 .= " AND products.sub_categories_id = $sub_categories ";
            $query2 .= " AND products.sub_categories_id = $sub_categories ";
        }
        if ($is_best_seller != '') {
            $query1 .= " AND products.best_seller = 1 ";
            $query2 .= " AND products.best_seller = 1 ";
        }
        if ($search_str != '') {
            $query1 .= " AND (products.title LIKE '%$search_str%' OR products.description LIKE '%$search_str%') ";
            $query2 .= " AND (products.title LIKE '%$search_str%' OR products.description LIKE '%$search_str%') ";
        }

        $query2 .= " ORDER BY products.id DESC LIMIT $limit OFFSET $offset";

        $stmt = $con->prepare($query1);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalRows = $result->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $limit);

        $stmt = $con->prepare($query2);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);

        $query3 = "SELECT * FROM product_images";
        $stmt = $con->prepare($query3);
        $stmt->execute();
        $result = $stmt->get_result();
        $productImages = $result->fetch_all(MYSQLI_ASSOC);

        $imagesByProductId = [];
        foreach ($productImages as $image) {
            $imagesByProductId[$image["product_id"]][] = $image;
        }

        $finalResult = [];
        foreach ($products as $product) {
            $category = [
                "name" => $product["category_name"]
            ];

            $sub_category = [
                "name" => $product["sub_category_name"]
            ];

            $finalResult[] = [
                "id" => $product["id"],
                "title" => $product["title"],
                "description" => $product["description"],
                "short_desc" => $product["short_desc"],
                "meta_title" => $product["meta_title"],
                "meta_desc" => $product["meta_desc"],
                "meta_keyword" => $product["meta_keyword"],
                "mrp" => $product["mrp"],
                "price" => $product["price"],
                "qty" => $product["qty"],
                "best_seller" => $product["best_seller"],
                "status" => $product["status"],
                "createdAt" => $product["createdAt"],
                "updatedAt" => $product["updatedAt"],
                "category" => $category,
                "sub_category" => $sub_category,
                "images" => $imagesByProductId[$product["id"]] ?? []
            ];
        }

        echo json_encode(['products' => $finalResult, 'totalPages' => $totalPages]);
    }
}
?>