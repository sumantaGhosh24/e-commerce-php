<?php
include "database.php";
include "function.php";
include "add_to_cart.php";

$stmt = $con->prepare("SELECT * FROM categories WHERE status = '1' ORDER BY name ASC");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

if (isset($_SESSION["USER_LOGIN"])) {
    $uid = $_SESSION["USER_ID"];

    if (isset($_GET["wishlist_id"])) {
        $wishlist_id = get_safe_value($con, $_GET["wishlist_id"]);

        $stmt = $con->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $wishlist_id, $uid);
        $stmt->execute();
    }

    $stmt = $con->prepare("SELECT products.title, wishlist.id FROM products, wishlist WHERE wishlist.product_id = products.id AND wishlist.user_id = ?");
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $wishlist_count = $result->num_rows;
}

$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

$script_name = $_SERVER["SCRIPT_NAME"];
$script_name_arr = explode("/", $script_name);
$mypage = $script_name_arr[count($script_name_arr) - 1];

$meta_title = "E-Commerce Website";
$meta_desc = "php & mysql e commerce website";
$meta_keyword = "e-commerce, website";
$meta_url = SERVER_PATH;
$meta_image = SERVER_PATH . "assets/images/favicon-16x16.png";

if ($mypage == "product.php") {
    $product_id = get_safe_value($con, $_GET["id"]);
    $stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    $meta_title = $product["meta_title"];
    $meta_desc = $product["meta_desc"];
    $meta_keyword = $product["meta_keyword"];
    $meta_url = SERVER_PATH . "product.php?id=" . $product_id;
} elseif ($mypage == "contact.php") {
    $meta_title = "Contact Us";
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="author" content="sumanta ghosh" />
    <meta name="description" content="<?php echo $meta_desc; ?>" />
    <meta name="keywords" content="<?php echo $meta_keyword; ?>" />
    <meta property="og:title" content="<?php echo $meta_title; ?>" />
    <meta property="og:image" content="<?php echo $meta_image; ?>" />
    <meta property="og:url" content="<?php echo $meta_url; ?>" />
    <meta property="og:site_name" content="<?php echo SERVER_PATH; ?>" />

    <!--==================== favicon ====================-->
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon-16x16.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/apple-touch-icon.png" />
    <link rel="manifest" href="./assets/images/site.webmanifest" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="msapplication-TileColor" content="#000000" />
    <meta name="theme-color" content="#000000" />

    <!--==================== fontawesome cdn ====================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />

    <!--==================== jQuery cdn ====================-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--==================== custom css ====================-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />

    <title>
        <?php echo $meta_title; ?>
    </title>
</head>

<body class="bg-white">
    <nav class="bg-blue-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Logo</a>
            <ul class="flex space-x-4">
                <li><a href="index.php">Home</a></li>
                <?php foreach ($categories as $category) { ?>
                    <div class="dropdown inline-block relative">
                        <a class="inline-flex items-center" href="categories.php?id=<?php echo $category["id"]; ?>">
                            <span class="mr-1">
                                <?php echo $category["name"]; ?>
                            </span>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </a>
                        <?php
                        $category_id = $category["id"];
                        $stmt = $con->prepare("SELECT * FROM sub_categories WHERE status = '1' AND categories_id = ?");
                        $stmt->bind_param('i', $category_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result) {
                            ?>
                            <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li><a href='categories.php?id=" . $category["id"] . "&sub_categories=" . $row["id"] . "' class='bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap'>" . $row['sub_categories'] . "</a></li>";
                                }
                                ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION["USER_ID"])) { ?>
                    <li><a href="wishlist.php">Wishlist
                            (
                            <?php echo $wishlist_count; ?>)
                        </a></li>
                <?php } ?>
                <li><a href="cart.php">Cart
                        (
                        <?php echo $totalProduct; ?>)
                    </a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION["USER_LOGIN"])) { ?>
                    <div class="dropdown inline-block relative">
                        <button class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                            <span class="mr-1">Hi,
                                <?php echo $_SESSION["USER_NAME"]; ?>
                            </span>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
                            <li><a href="my_order.php"
                                    class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Order</a></li>
                            <li><a href="profile.php"
                                    class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Profile</a>
                            </li>
                            <li><a href="logout.php"
                                    class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Logout</a></li>
                        </ul>
                    </div>
                    <?php
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                }
                ?>
                <form action="search.php" method="get">
                    <input placeholder="Search here... " type="text" name="str"
                        class="px-4 py-2 rounded-md border border-gray-300">
                    <button type="submit"></button>
                </form>
            </ul>
        </div>
    </nav>