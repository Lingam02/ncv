<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM wev_usage WHERE id = '" . $id . "'";
$result = mysqli_query($con,$query);
$work = mysqli_fetch_array($result);
if($work) {
echo json_encode($work);
} else {
echo "Error: " . $result . "" . mysqli_error($con);
}
?>
