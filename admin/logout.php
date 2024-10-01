<?php
session_start();

unset($_SESSION["ADMIN_ID"]);
unset($_SESSION["ADMIN_LOGIN"]);

header('Location: ' . SERVER_PATH . 'admin/login.php');
?>