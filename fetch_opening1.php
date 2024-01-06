<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM tbl_opening WHERE loc_id = '" . $id . "'";
$result = mysqli_query($con,$query);
if (mysqli_num_rows($result) > 0) {
    $rows = array();
  
    while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
    }
  
    echo json_encode($rows);
  } else {
    echo "No items found.";
  }
  
  mysqli_close($con);
  ?>
  