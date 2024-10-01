<?php
include 'database.php';
include 'function.php';

if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {

} else {
    header('Location: ' . SERVER_PATH . 'admin/login.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="author" content="sumanta ghosh" />
    <meta name="description" content="e commerce admin dashboard" />
    <meta name="keywords" content="e-commerce, dashboard" />

    <!--==================== favicon ====================-->
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon-16x16.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/apple-touch-icon.png" />
    <link rel="manifest" href="./assets/images/site.webmanifest" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="msapplication-TileColor" content="#000000" />
    <meta name="theme-color" content="#000000" />

    <!--==================== canonical ====================-->
    <link rel="canonical" href="http://example.com/home" />

    <!--==================== fontawesome cdn ====================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />

    <!--==================== jQuery cdn ====================-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--==================== custom css ====================-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />

    <title>Dashboard</title>
</head>

<body class="bg-white">
    <nav class="bg-blue-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Logo</a>
            <ul class="flex space-x-4">
                <div class="dropdown inline-block relative">
                    <button class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                        <span class="mr-1">Manage</span>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
                        <li><a href="product.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Products</a>
                        </li>
                        <li><a href="order_master.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Orders</a>
                        </li>
                        <li><a href="product_review.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Product
                                Review</a></li>
                        <li><a href="color.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Colors</a>
                        </li>
                        <li><a href="size.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Sizes</a>
                        </li>
                        <li><a href="banner.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Banners</a>
                        </li>
                        <li><a href="vendor_management.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Vendor
                                Management</a></li>
                        <li><a href="categories.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Categories</a>
                        </li>
                        <li><a href="sub_categories.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Sub
                                Categories</a></li>
                        <li><a href="users.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Users</a>
                        </li>
                        <li><a href="coupon_master.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Coupons</a>
                        </li>
                        <li><a href="contact_us.php"
                                class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Contact
                                Us</a></li>
                    </ul>
                </div>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>