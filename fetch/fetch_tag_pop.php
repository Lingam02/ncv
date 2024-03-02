<?php

include "../config.php";

// Get the ID from the POST data
$id = $_POST['id'];

// Prepare the query with a placeholder for the ID
$query = "SELECT * FROM warp_details WHERE id = ?";
$stmt = $con->prepare($query);

// Bind the parameter (assuming hd_id is an integer, change "i" to "s" if it's a string)
$stmt->bind_param("i", $id);

// Execute the prepared statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Process results and prepare data array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
