<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM bobin WHERE id = '" . $id . "'";
$result = mysqli_query($con,$query);
$bobin = mysqli_fetch_array($result);
if($bobin) {
echo json_encode($bobin);
} else {
echo "Error: " . $sql . "" . mysqli_error($con);
}
?>
