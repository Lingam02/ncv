<?php
include "config.php";
$id = $_POST['auto_id'];
$query = "SELECT * FROM pur_hd WHERE auto_id = '" . $id . "'";
$result = $con->query($query);
$cust = $result->num_rows;

echo ($cust);

?>