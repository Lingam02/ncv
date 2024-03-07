<?php

function tagcals($currentTagNo)
{
    // Extract the numeric portion from the current tagno
    $numericPart = (int) preg_replace('/[^0-9]/', '', $currentTagNo);

    // Increment the numeric portion by 1
    $nextNumericPart = $numericPart + 1;

    // Determine the length of the numeric portion in the original tagno
    $numericLength = strlen($numericPart);

    // Pad the incremented numeric portion with leading zeros to match the original length
    $nextNumericPartPadded = str_pad($nextNumericPart, $numericLength, '0', STR_PAD_LEFT);

    // Extract the prefix from the original tagno
    $prefix = substr($currentTagNo, 0, strlen($currentTagNo) - $numericLength);

    // Combine the prefix and incremented numeric portion to generate the next tagno
    $nextTagNo = $prefix . $nextNumericPartPadded;

    return $nextTagNo;
}
//========================================================================
function tagcal($string)
{
    // Extract numeric part and prefix from the input tag
    if (preg_match('/(\d+)$/', $string, $matches)) {
        $numericPart = $matches[1];
        $numlen = strlen($numericPart);
        $position = strlen($string) - $numlen;

        // Use substr to get the string part without the numeric part
        $stringPart = substr($string, 0, $position);

        $newIntValue = intval($numericPart) + 1;
        $newStrValue = sprintf('%0' . $numlen . 'd', $newIntValue);

        $newtag =  $stringPart . $newStrValue;

        return $newtag;
    } else {
        echo "No numeric part found\n";
    }
}
//==================================================================
//============  WEAVER OPENING BALACE ==============================

function getWevOp($wev_id, $pur_no)
{
    include_once("../config.php");

    // Check connection
    $con = mysqli_connect($host, $user, $password, $dbname);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch data from wev_op
    $op_query = "SELECT itm_grp, SUM(qty) as opening_balance FROM wev_op WHERE wev_id = ? GROUP BY itm_grp";
    $op_stmt = $con->prepare($op_query);
    $op_stmt->bind_param("i", $wev_id);
    $op_stmt->execute();
    $op_result = $op_stmt->get_result();

    // Fetch data from wev_trans
    $trans_query = "SELECT itm_grp, SUM(qty2) as qty FROM wev_trans WHERE wev_id = ? AND pur_no < ? GROUP BY itm_grp";
    $trans_stmt = $con->prepare($trans_query);
    $trans_stmt->bind_param("ii", $wev_id, $pur_no);
    $trans_stmt->execute();
    $trans_result = $trans_stmt->get_result();

    // Combine and calculate opening balance
    $opening_balance = array();

    // Process wev_op results
    while ($op_row = $op_result->fetch_assoc()) {
        $opening_balance[$op_row['itm_grp']] = $op_row['opening_balance'];
    }

    // Adjust opening balance based on wev_trans results
    while ($trans_row = $trans_result->fetch_assoc()) {
        $itm_grp = $trans_row['itm_grp'];
        if (isset($opening_balance[$itm_grp])) {
            $opening_balance[$itm_grp] -= $trans_row['qty'];
        }
    }

    // Close the statements
    $op_stmt->close();
    $trans_stmt->close();

    // Close the connection
    $con->close();

    return $opening_balance;
}
//===================================================================
//================ find A/C CLOSING BALANCE =========================
// Assume you have a database connection established
function get_Ac_Bal($ac_id, $given_date)
{
    include_once('../config.php');

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
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

    return $closing_balance;
}

//===========================================

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $acid = $_GET['acid'];
    $frmdate = $_GET['frmdate'];
    $result = get_Ac_Bal($acid, $frmdate);
    echo json_encode(array('result' => $result));
}
//====================================================================
function getGstinDetails($gstin, $chkGSTIN) {
    $subkey = "fa2ef6b4-2e3e-4c61-94d0-276296d8f966";
    $url = "https://einv.dsserp.in/prod/api/invoice/GetGstinDetails?chkGSTIN=" . $chkGSTIN;

    try {
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_HTTPHEADER, array(
            'dss-Subscription-Key: ' . $subkey,
            'gstin: ' . $gstin
        ));
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($request);
        curl_close($request);

        $decodedResponse = json_decode($response, true);
        return $decodedResponse;
    } catch (Exception $ex) {
        $payer = new stdClass();
        $payer->status = "0";
        $payer->ErrorDetails = array();

        $error = new stdClass();
        $error->ErrorCode = "dss001";
        $error->ErrorMessage = $ex->getMessage();

        $payer->ErrorDetails[] = $error;

        return $payer;
    }
}


//===================================================================================