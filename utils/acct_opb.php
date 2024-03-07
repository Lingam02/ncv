<?php
    include_once('../config.php');
    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $ac_id = $_GET['acid'];
    $given_date = $_GET['frmdate'];
    // Get the opening balance from acct table
    $sql_opb = "SELECT ac_op_bal FROM accts WHERE id = $ac_id";
    $result_opb = $con->query($sql_opb);

    if ($result_opb->num_rows > 0) {
        $row_opb = $result_opb->fetch_assoc();
        $opb = $row_opb["ac_op_bal"];
    } else {
        // Handle the case where the account ID is not found
        return "Account ID not found";
    }

    // Get total credit amount (cr = 1) before the given date
    $sql_total_cr = "SELECT SUM(amt) as total_cr FROM ac_trans WHERE ac_id = $ac_id AND cr = 1 AND trans_dat < '$given_date'";
    $result_total_cr = $con->query($sql_total_cr);
    $row_total_cr = $result_total_cr->fetch_assoc();
    $total_cr = $row_total_cr["total_cr"];

    // Get total debit amount (cr = 0) before the given date
    $sql_total_dr = "SELECT SUM(amt) as total_dr FROM ac_trans WHERE ac_id = $ac_id AND cr = 0 AND trans_dat < '$given_date'";
    $result_total_dr = $con->query($sql_total_dr);
    $row_total_dr = $result_total_dr->fetch_assoc();
    $total_dr = $row_total_dr["total_dr"];

    // Calculate closing balance
    $closing_balance = $opb + $total_cr - $total_dr;

   // return $closing_balance;
   echo json_encode($closing_balance);

?>