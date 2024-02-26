<?php
include ('config.php');
// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['zari_item_name'];
    $email = $_POST['weft_batch_no'];
    var_dump($_POST);
    // Validate form data (you can add more validation as needed)
    if (!empty($name) && !empty($email)) {
        // Prepare and bind SQL statement
        $stmt = $con->prepare("INSERT INTO inward (zari_item_name, weft_batch_no) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Send a success response back to the client
            $response = array('status' => 'success', 'message' => 'Form submitted successfully!');
            echo json_encode($response);
        } else {
            // Send an error response back to the client if SQL statement execution fails
            $response = array('status' => 'error', 'message' => 'Error submitting form.');
            echo json_encode($response);
        }

        // Close statement
        $stmt->close();
    } else {
        // Send an error response back to the client if required fields are empty
        $response = array('status' => 'error', 'message' => 'Please fill in all required fields.');
        echo json_encode($response);
    }
} else {
    // Send an error response if form is not submitted using POST method
    $response = array('status' => 'error', 'message' => 'Invalid request method.');
    echo json_encode($response);
}

// Close database connection
$con->close();
?>
