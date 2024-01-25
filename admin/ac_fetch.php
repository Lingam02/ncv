<?php
include "config.php";
$id = $_POST['id'];
$query="SELECT * from acct WHERE user_nam = '" . $id . "'";
$result = $con->query($query);
$cust = $result->num_rows;

echo ($cust);
    // if ($result->num_rows > 0) {
    //     echo "This Item allready Exists !";
    //    echo '1';
    // }else
    // {
    //     echo '0';
    // }
    
?>