<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to a logout confirmation page or any other page you want
header("Location: index.php");
exit();
