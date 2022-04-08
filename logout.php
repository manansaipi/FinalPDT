<?php 

session_start();
$_SESSION=[];
session_unset();
session_destroy();
$_SESSION["login"] = true;
header("Location: login.php");
exit;
?>