<?php
session_start();

// Unset all of the session variables to clear the user's data
$_SESSION = array();

// Destroy the session completely
session_destroy();

// Redirect back to the login area
header("Location: login.php");
exit();
?>