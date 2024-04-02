<?php
include "config.php";

$id = $_POST['id'];
$query = "SELECT * FROM cnf WHERE auto_id = '" . $id . "'";
$result = $con->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(array('success' => true, 'data' => $row));
} else {
    echo json_encode(array('success' => false, 'message' => 'Query failed'));
}
?>
