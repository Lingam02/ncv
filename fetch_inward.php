<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM pur_hd WHERE auto_id = '" . $id . "'";
$result = $con->query($query);
$cust = mysqli_fetch_array($result);
if($cust) {
echo json_encode($cust);
} else {
echo "Error: " . $sql . "" . mysqli_error($con);
}

?>