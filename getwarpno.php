<?php
include_once "config.php";
include_once "utils.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if 'totsrl' parameter is provided via POST
if (isset($_POST['totsrl'])) {
    $n = intval($_POST['totsrl']); // Convert the parameter to an integer
    $barser = array(); // Initialize an array to store serial numbers

    // Begin a database transaction
    $con->begin_transaction();

    $cmp__id = '1';
    $query = "SELECT * FROM setup WHERE cmp_id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt === false) {
        die("Preparation failed: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "s", $cmp__id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo "Voucher Config Error?";
        $con->rollback(); // Rollback the transaction
        return;
    }

    $cust = mysqli_fetch_array($result);
    if ($cust === false) {
        die("Error fetching data: " . mysqli_error($con));
    }

    // Get the current warp number and update it after generating the serial numbers
    $curtag = $cust["warp_no"];

    if ($curtag === null) {
        die("Error in tagcal function.");
    }

    for ($i = 0; $i < $n; $i++) {
        $newtag = tagcal($curtag);
        $barser[] = $newtag; // Add the generated serial number to the array
        $curtag = $newtag;
    }

    // Update the setup table with the new warp number
    $sql = "UPDATE setup SET warp_no = ? WHERE cmp_id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt === false) {
        die("Preparation failed: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "ss", $curtag, $cmp__id);
    if (mysqli_stmt_execute($stmt)) {
        // Commit the transaction if the update is successful
        $con->commit();
    } else {
        echo "Update failed: " . mysqli_error($con);
        $con->rollback(); // Rollback the transaction
    }

    mysqli_stmt_close($stmt);

    // Return the array of serial numbers as JSON response
    echo json_encode($barser);
} else {
    // If 'totsrl' parameter is not provided, return an error message
    echo json_encode(array('error' => 'Number not provided'));
}
?>
