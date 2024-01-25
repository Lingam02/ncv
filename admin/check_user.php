<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["userName"];

    // Sanitize input to prevent SQL injection
    $user_name = mysqli_real_escape_string($con, $user_name);

    // Check if the username exists
    $check_query = "SELECT COUNT(*) FROM acct WHERE user_nam = '$user_name'";
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
