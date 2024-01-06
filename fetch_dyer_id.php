<?php
// include "config.php";
// $id = $_POST['id'];
// $query = "SELECT * FROM tbl_dyer WHERE dyer_id = '" . $id . "' AND  tbl_status = 'ISS'";
// $query = "SELECT * FROM tbl_dyer WHERE tbl_status = 'ISS' AND  dyer_id = '" . $id . "' ";

// $result = mysqli_query($con, $query);

// if ($result) {
//     $cust = mysqli_fetch_assoc($result);
//     if ($cust) {
//         echo json_encode($cust);
//     } else {
//         echo "No data found for the provided ID.";
//     }
// } else {
//     echo "Error: " . $query . "<br>" . mysqli_error($con);
// }
?>

<?php
include "config.php";
$id = $_POST['id'];
$query = "SELECT * FROM tbl_dyer WHERE id = '" . $id . "' AND  tbl_status = 'ISS'";
$result = mysqli_query($con,$query);
$cust = mysqli_fetch_array($result);
if($cust) {
echo json_encode($cust);
} else {
echo "Error: " . $sql . "" . mysqli_error($con);
}
?>