<?php
include "config.php";

$sql = "SELECT col_nam
        FROM `cnf`
        JOIN `bobin_trans` ON `cnf`.`auto_id` = `bobin_trans`.`col_id`
        WHERE `cnf`.`auto_id` AND `bobin_trans`.`col_id` AND `bobin_trans`.`txn_type`='RET'";

$result = mysqli_query($con, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Process each row here
        print_r($row); // Example: print row data
    }
} else {
    echo "Error executing the query: " . mysqli_error($con);
}

mysqli_close($con);
?>
