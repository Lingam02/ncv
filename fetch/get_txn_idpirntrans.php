<?php
// Include your database configuration file
include "../config.php";

// Check if the box_col_nam parameter is set in the POST request
if(isset($_POST['box_col_nam'])) {
    // Sanitize the input
    $box_col_nam = mysqli_real_escape_string($con, $_POST['box_col_nam']);

    // Construct the SQL query to retrieve data based on the selected box_col_nam
    $query = "SELECT * FROM bobin_trans WHERE box_col_nam = ? AND txn_type = 'PIRN_RET'";
    $stmt = $con->prepare($query);

    // Bind the parameter
    $stmt->bind_param("s", $box_col_nam);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Initialize an empty array to store the retrieved data
    $data = array();

    // Loop through the result set and fetch the data
    while($row = $result->fetch_assoc()) {
        // Add each row to the $data array
        $data[] = $row;
    }

    // Close the prepared statement
    $stmt->close();

    // Send the JSON response containing the retrieved data
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // If box_col_nam parameter is not set, send an error response
    header('HTTP/1.1 400 Bad Request');
    echo "Error: Missing parameter box_col_nam";
}
?>
