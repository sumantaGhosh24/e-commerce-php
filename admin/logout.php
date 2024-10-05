<?php
include './includes/database.php';

unset($_SESSION["ADMIN_ID"]);
unset($_SESSION["ADMIN_LOGIN"]);

header('Location: ' . SERVER_PATH . 'admin/login.php');
?>