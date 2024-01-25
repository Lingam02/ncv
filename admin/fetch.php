<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM work_progress WHERE id = '" . $id . "'";
$result = mysqli_query($con,$query);
$work = mysqli_fetch_array($result);
if($work) {
echo json_encode($work);
} else {
echo "Error: " . $sql . "" . mysqli_error($con);
}
?>
