<?php
include './includes/database.php';

if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
    header('Location: ' . SERVER_PATH . 'admin/index.php');
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

    <title>Login</title>
</head>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-4 text-black">Admin Login</h1>
        <h2 class="text-gray-600 mb-6 text-black">Admin login to dashboard</h2>
        <span id="form_msg" class="text-green-500 font-bold text-center my-3"></span>
        <form class="mb-6" id="login_form">
            <div class="mb-4">
                <input type="email" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your email" name="email" />
                <span id="email_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <div class="mb-4">
                <input type="password" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your password" name="password" />
                <span id="password_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <button type="submit" id="login_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Login</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#login_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#login_submit").attr("disabled", true);
            $("#login_submit").text("Processing...");

            $.ajax({
                url: "http://localhost:3000/admin/includes/auth.php",
                type: "post",
                data: $("#login_form").serialize(),
                success: function (result) {
                    $("#login_submit").attr("disabled", false);
                    $("#login_submit").text("Login");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#" + data.field).html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#" + data.field).html(data.msg);
                        $("#login_form")[0].reset();
                        window.location.href = "./index.php";
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<!--==================== add noscript ====================-->
<noscript>please enable JavaScript in your website.</noscript>

<!--==================== tailwind js ====================-->
<script src="https://cdn.tailwindcss.com"></script>

<!--==================== custom js ====================-->
<script src="./assets/js/main.js"></script>
</body>

</html>