<?php
include "../config.php";

// Get the ID from the POST data
$id = $_POST['id'];

// Prepare the query with a placeholder for the ID
$query = "SELECT bobin_trans.*, cnf.* FROM bobin_trans INNER JOIN cnf ON bobin_trans.col_id = cnf.auto_id WHERE bobin_trans.id = ?";
$stmt = $con->prepare($query);

// Bind the parameter (assuming id is an integer, change "i" to "s" if it's a string)
$stmt->bind_param("i", $id);

// Execute the prepared statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Initialize data array
$data = [];

// Process results and prepare data array
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
