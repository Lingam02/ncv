<?php
include "config.php";
$id = $_POST['id'];
// $query = "SELECT * FROM bobin_trans WHERE reff_id = '" . $id . "'";
$query = "SELECT * FROM bobin_trans WHERE reff_id = $id AND txn_type = 'ISS';";

$result = mysqli_query($con,$query);
$invdet = array(); // Initialize an empty array to store the data

while ($row = mysqli_fetch_assoc($result)) {
    // Add each row to the $invdet array
    $invdet[] = $row;
}

if (!empty($invdet)) {
    echo json_encode($invdet);
} else {
    echo "No data found"; // Modify the message as needed
}
?>