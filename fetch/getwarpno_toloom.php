<?php
include_once "config.php";
include_once "utils.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if 'totsrl' parameter is provided via POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cmp_id = '1';
    // Begin a database transaction
    $con->begin_transaction();

    $query = "SELECT * FROM setup WHERE cmp_id = ?";
    $stmt = mysqli_prepare($con, $query);
  
    if ($stmt === false) {
      die("Preparation failed: " . mysqli_error($con));
    }
  
    mysqli_stmt_bind_param($stmt, "s", $cmp_id);
    mysqli_stmt_execute($stmt); // Corrected function name
  
    $result = mysqli_stmt_get_result($stmt);
  
    if (mysqli_num_rows($result) == 0) {
      showAlertAndRedirect("Voucher Config Error?");
    }
    $VoucHer = mysqli_fetch_array($result);
    if ($VoucHer === false) {
      die("Error fetching data: " . mysqli_error($con));
    }
  
   // $vch_typ = $VoucHer['vch_typ'];
    $warp_no2 = $VoucHer['warp_no2'];

    $cmp_id = '1';
  
  
    //=========================================================================
    $vchno = tagcal($VoucHer["warp_no2"]);
    //=========================================================================
    $sql = "UPDATE setup SET warp_no2 = ? WHERE cmp_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    // Check for preparation errors
    if ($stmt === false) {
      die("Preparation failed: " . mysqli_error($con));
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $vchno, $cmp_id); // Corrected parameter binding
    
    if (mysqli_stmt_execute($stmt)) {
      echo "Update successful!";
    } else {
      // Display more informative error message
      die("Update failed: " . mysqli_stmt_error($stmt));
    }
    
    // Close the prepared statement
    mysqli_stmt_close($stmt);
  }
 else {
    // If 'totsrl' parameter is not provided, return an error message
    echo json_encode(array('error' => 'Number not provided'));
}
?>
