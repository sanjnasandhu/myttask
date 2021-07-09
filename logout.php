<?php
require_once 'config.php';
session_destroy();
// unset($_SESSION['facebook_access_token']);
// unset($_SESSION['userData']);
header("Location:index.php");
?>
