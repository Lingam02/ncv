<?php
include "config.php";
$id = $_POST['pid'];
$query = "SELECT *
          FROM warp_details  
          WHERE pur_invno = '$id'";
$result = $con->query($query);
if ($result->num_rows > 0) {
    $res = 'Yes'; // Add semicolon at the end of the line
    echo json_encode($res);
} else {
    $res = 'No'; // Add semicolon at the end of the line
    echo json_encode($res);
}
?>
