<?php

// include "../config.php";
// $id = $_POST['id'];

// $query = "SELECT * FROM warp_details WHERE hd_id = '" . $id . "'";

// $result = mysqli_query($con,$query);
// $invdet = array(); // Initialize an empty array to store the data

// while ($row = mysqli_fetch_assoc($result)) {
//     // Add each row to the $invdet array
//     $invdet[] = $row;
// }

// if (!empty($invdet)) {
//     echo json_encode($invdet);
// } else {
//     echo "No data found"; // Modify the message as needed
// }

include "../config.php";

// Get the ID from the POST data
$id = $_POST['id'];

// Prepare the query with a placeholder for the ID
$query = "SELECT * FROM warp_details WHERE hd_id = ?";
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
