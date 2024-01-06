<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_name = $_POST["workerName"];

    // Sanitize input to prevent SQL injection
    $worker_name = mysqli_real_escape_string($con, $worker_name);

    // Check if the worker name exists
    $check_query = "SELECT COUNT(*) FROM acct WHERE ac_nam = '$worker_name'";
    $result = mysqli_query($con, $check_query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        $count = $row[0];

        $response = array("exists" => ($count > 0));
        echo json_encode($response);
    } else {
        echo "Error checking for duplicates: " . $con->error;
    }
}
?>
