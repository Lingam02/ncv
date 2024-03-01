<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT *
          FROM pur_hd
          INNER JOIN pur_det ON pur_hd.id = pur_det.id 
          WHERE pur_det.it_id = 'IT0008' and pur_det.auto_id = '" . $id . "'";
$result = $con->query($query);
$cust = mysqli_fetch_array($result);
if($cust) {
echo json_encode($cust);
} else {
echo "Error: " . $sql . "" . mysqli_error($con);
}

?>