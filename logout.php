<?php

session_start();

// Clearing all session variables
$_SESSION = array();

// Destroying the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroying the session
session_destroy();

// Clearing cart-specific session variables
unset($_SESSION['cart']);
unset($_SESSION['productIds']);
unset($_SESSION['logged-in']);
unset($_SESSION['username']);
unset($_SESSION['user_id']);

// Redirecting back to the home page
header("Location: index.php");
exit();
?>
