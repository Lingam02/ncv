<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// include "config.php";

// // Retrieve posted data
// $boxIds = $_POST['boxIds'];
// $items = $_POST['items'];
// $colors = $_POST['colors'];
// $weights = $_POST['weights'];
// var_dump($_POST);
// // Prepare and execute SQL insert statements
// $stmt = $con->prepare("INSERT INTO weaver_detail (box_id, box_item, box_color, box_weight) VALUES (?, ?, ?, ?)");

// // Bind parameters and execute for each row of data
// for ($i = 0; $i < count($boxIds); $i++) {
//     $stmt->bind_param("sssd", $boxIds[$i], $items[$i], $colors[$i], $weights[$i]);
//     $stmt->execute();
// }

// // Close prepared statement and database connection
// $stmt->close();
// $con->close();

// echo "Data inserted successfully into weaver_detail table.";





// Retrieve posted data
$boxIds = $_POST['box_nos'];
$items = $_POST['items'];
$colors = $_POST['colors'];
$weights = $_POST['wghts'];
$enablepost = $_POST['enablepost']; // Array of checkboxes

// Open connection to database
include "../config.php";

// Prepare and execute SQL insert statements for checked rows only
$stmt = $con->prepare("INSERT INTO weaver_detail (box_no, box_item, box_color, box_weight) VALUES (?, ?, ?, ?)");
for ($i = 0; $i < count($boxIds); $i++) {
    if (!empty($enablepost[$i])) { // Check if checkbox is checked
        $stmt->bind_param("sssd", $boxIds[$i], $items[$i], $colors[$i], $weights[$i]);
        $stmt->execute();
    }
}

// Close prepared statement and database connection
$stmt->close();
$con->close();

echo "Data inserted successfully into weaver_detail table.";
?>

