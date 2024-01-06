<?php

session_start();

$host = "localhost"; /* Host name */
$user = "root"; /* User */
//$user = "admin"; /* User */
$password = ""; /* Password */
$dbname = "dyl23"; /* Database name */
//$dbname = "pcw"; /* Database name */
$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

