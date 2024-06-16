<?php
// Initialize session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page (you can change 'login.php' to your actual login page)
header("Location: index.php");
exit();
?>
