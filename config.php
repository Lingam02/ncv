<?php

// session_start();

// $host = "localhost"; /* Host name */
// $user = "root"; /* User */
// //$user = "admin"; /* User */
// $password = ""; /* Password */
// $dbname = "ncv"; /* Database name */
// //$dbname = "pcw"; /* Database name */
// $con = mysqli_connect($host, $user, $password,$dbname);
// // Check connection
// if (!$con) {
//  die("Connection failed: " . mysqli_connect_error());
// }


session_start();

$host = "localhost"; /* Host name */
$user = "u296169589_ncv23"; /* User */
//$user = "admin"; /* User */
$password = "PkYp@1971"; /* Password PkYp@1969 */
$dbname = "u296169589_ncv23"; /* Database name u296169589_ncv24 */
//$dbname = "pcw"; /* Database name */
$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

