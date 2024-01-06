<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM tbl_dyer WHERE id = '" . $id . "'";
$result = mysqli_query($con, $query);

if ($result) {
    $cust = mysqli_fetch_assoc($result);
    if ($cust) {
        echo json_encode($cust);
    } else {
        echo "No data found for the provided ID.";
    }
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}
?>

  