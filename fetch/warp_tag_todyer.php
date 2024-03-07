<?php

// include "../config.php";
// $id = $_POST['id'];
// $query = "SELECT * FROM sep_ret WHERE new_warp_no = $id ";
// $result = $con->query($query);

// $cust = mysqli_fetch_array($result);
// if($cust) {
// echo json_encode($cust);
// } else {
// echo "Error: " . $sql . "" . mysqli_error($con);
// }

include "../config.php";

// Check if 'id' parameter is set in the POST request
if(isset($_POST['id'])) {
    // Sanitize the input
    $id = mysqli_real_escape_string($con, $_POST['id']);
    
    // Prepare the SQL query
    $query = "SELECT * FROM sep_ret WHERE new_warp_no = ?";
    
    // Initialize an empty array to store the data
    $invdet = array();

    // Prepare and bind the statement
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        
        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch data and add each row to the $invdet array
        while ($row = mysqli_fetch_assoc($result)) {
            $invdet[] = $row;
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle preparation error
        echo "Preparation failed: " . mysqli_error($con);
    }

    // Check if any data was found
    if (!empty($invdet)) {
        // Return the data as JSON
        echo json_encode($invdet);
    } else {
        // Return a message if no data was found
        echo "No data found";
    }
} else {
    // Handle case where 'id' parameter is not set
    echo "ID parameter is not set";
}
?>
