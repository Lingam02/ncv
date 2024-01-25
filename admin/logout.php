<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the index page in the parent folder
header("Location: ../index.php");
exit();
