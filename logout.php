<?php
require "./includes/database.php";

unset($_SESSION["USER_LOGIN"]);
unset($_SESSION["USER_ID"]);
unset($_SESSION["USER_NAME"]);

header("Location: index.php");
die();
?>