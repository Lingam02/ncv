<?php
include "config.php";
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit(); // Ensure that code stops executing after the redirect
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tnx_nam = $_POST['txn_nam'];

    $id = $_POST['hidden_dyer_id3'];
    $retid = $_POST['dyerissid'];
    //issue
    $dyer_nam = $_POST['dyer_nam'];
    $dyer_id = $_POST['dyer_id'];
    $fromloc = $_POST['fromloc'];
    $fromloc_id = $_POST['fromloc_id'];
    $iss_itm_nam = $_POST['iss_itm_nam'];
    $iss_itm_id = $_POST['iss_itm_id'];
    $iss_desc = $_POST['iss_desc'];
    $iss_wght = $_POST['iss_wght'];
    $iss_date = $_POST['iss_date'];
    $iss_time = $_POST['iss_time'];

    //return
    $ret_dyer_nam = $_POST['ret_dyer_nam'];
    $ret_dyer_id = $_POST['ret_dyer_id'];
    $ret_to_loc = $_POST['to_loc'];
    $ret_to_loc_id = $_POST['to_loc_id'];
    $ret_itm_nam = $_POST['ret_itm_nam'];
    $ret_itm_id = $_POST['ret_itm_id'];
    $col_nam = $_POST['col_nam'];
    $col_id = $_POST['ret_col_id'];
    $col_nam2 = $_POST['col_nam2'];
    $col_id2 = $_POST['iss_col_id2'];
    $ret_desc = $_POST['ret_desc'];
    $ret_wght = $_POST['ret_wght'];
    $ret_date = $_POST['ret_date'];
    $ret_time = $_POST['ret_time'];
    $waste_wght = $_POST['waste_wght'];

    $comp_id = "1";
    $txn_type = "DYE";
$trans_id =  $_POST['id'];
    if ($tnx_nam != "") {

        // -----------------------------------------------------------------------
        $con = mysqli_connect($host, $user, $password, $dbname);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        // -----------------------------------------------------------------------

        // -----------------------------------------------------------------------
        if ($tnx_nam === "KORA_ISS" && $dyer_nam !== "") {
            $status = "ISS";
            $insertQuery = "INSERT INTO tbl_dyer (tbl_status,loc_id,loc_nam, iss_date, iss_time, dyer_id, dyer_nam, iss_itm_nam, iss_itm_id, iss_desc, iss_wght,col_id,col_nam) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";
            $stmt = mysqli_prepare($con, $insertQuery);

            if (!$stmt) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            mysqli_stmt_bind_param($stmt, 'ssssssssssdss', $status,$fromloc_id, $fromloc, $iss_date, $iss_time, $dyer_id, $dyer_nam, $iss_itm_nam, $iss_itm_id, $iss_desc, $iss_wght, $col_id2, $col_nam2);
            mysqli_stmt_execute($stmt);
            //$iss_no = 0;
            $lastid = mysqli_insert_id($con);
            $iss_no = "ISS" . $lastid;

            mysqli_stmt_close($stmt);
            //-----------------------------------------//stock table insert------------------------------------------------------------

            $qty2 = -1 * ($iss_wght);
            $comp_id = "1";
            $iss = "0";
            $txn_type = "DYE";
            $insertQuery_stock = "INSERT INTO stock (trans_id,loc_id,loc_nam, trans_dat,txn_typ, it_id, col_id, col_nam,ac_id, qty, qty2,cmp_id,iss) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_stock = mysqli_prepare($con, $insertQuery_stock);

            if (!$stmt_stock) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            mysqli_stmt_bind_param($stmt_stock, 'sssssssssddss', $lastid,$fromloc_id,$fromloc, $iss_date, $txn_type, $iss_itm_id, $col_id2, $col_nam2, $dyer_id, $iss_wght, $qty2, $comp_id, $iss);
            mysqli_stmt_execute($stmt_stock);
            mysqli_stmt_close($stmt_stock);
            //--------------------------------------------//stock table insert ends------------------------------------------------------------
        } else if ($tnx_nam === "SILK_RET") {
            // -------------------  silk return -------------- and kora waste -------------------------
            $status_ret = "RET";

            $updateQuery_ret = "UPDATE tbl_dyer SET tbl_status = ?,to_loc_id = ?,to_loc_nam = ?, ret_date = ?, ret_time = ?, dyer_id = ?, dyer_nam = ?, ret_itm_nam = ?, ret_itm_id = ?, ret_desc = ?, ret_wght = ? ,waste_wght = ? WHERE id = ?";

            $stmt_ret = mysqli_prepare($con, $updateQuery_ret);

            if (!$stmt_ret) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            mysqli_stmt_bind_param($stmt_ret, 'ssssssssssdds', $status_ret,$ret_to_loc_id,$ret_to_loc, $ret_date, $ret_time, $dyer_id, $ret_dyer_nam, $ret_itm_nam, $ret_itm_id, $ret_desc, $ret_wght, $waste_wght, $retid);
            mysqli_stmt_execute($stmt_ret);
            mysqli_stmt_close($stmt_ret);
            //--------------------------------------------//stock table insert ret starts------------------------------------------------------------
           
            $qtyr2 = 1 * ($ret_wght);
         
            $iss_ret = "1";
           
            $insertQuery_stockr = "INSERT INTO stock (trans_id,loc_id,loc_nam, trans_dat,txn_typ, it_id, col_id, col_nam,ac_id, qty, qty2,cmp_id,iss,reff_dat) 
            VALUES (?, ?, ?,?,?,?, ?, ?,?,?,?,?,?,?)";
            $stmt_stock_r = mysqli_prepare($con, $insertQuery_stockr);

            if (!$stmt_stock_r) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            mysqli_stmt_bind_param($stmt_stock_r, 'sssssssssddsss', $trans_id,$ret_to_loc_id,$ret_to_loc, $ret_date, $txn_type, $ret_itm_id, $col_id2, $col_nam2, $dyer_id, $ret_wght, $qtyr2, $comp_id, $iss_ret,$iss_date);
            mysqli_stmt_execute($stmt_stock_r);
            //$iss_no = 0;


            mysqli_stmt_close($stmt_stock_r);
            //--------------------------------------------//stock table insert ends------------------------------------------------------------

        } else if ($tnx_nam === "EDIT") {

            // The SQL query template
            $updateQuery_edit = "UPDATE tbl_dyer  SET loc_id = ?,loc_nam = ?,to_loc_id = ?, to_loc_nam = ?, dyer_nam = ?, dyer_id = ?, iss_itm_nam = ?, iss_itm_id = ?, iss_desc = ?, iss_wght = ?, iss_date = ?, iss_time = ?, ret_itm_nam = ?, ret_itm_id = ?, col_nam = ?, col_id = ?, ret_desc = ?, ret_wght = ?, ret_date = ?,ret_time = ?, waste_wght = ? WHERE id = ?";

            // Prepare the statement
            $stmt_edit = mysqli_prepare($con, $updateQuery_edit);
            if (!$stmt_edit) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }
            // Bind parameters to the statement
            mysqli_stmt_bind_param($stmt_edit, "sssssssssdsssssssdssds",$fromloc_id,$fromloc,$ret_to_loc_id,$ret_to_loc, $dyer_nam, $dyer_id, $iss_itm_nam, $iss_itm_id, $iss_desc, $iss_wght, $iss_date, $iss_time, $ret_itm_nam, $ret_itm_id, $col_nam, $col_id, $ret_desc, $ret_wght, $ret_date, $ret_time, $waste_wght, $id);

            mysqli_stmt_execute($stmt_edit);

            mysqli_stmt_close($stmt_edit);
        }

        // -----------------------------------------------------------------------

        else {
            echo "DYER NAME AND TXN TYPE CAN'T BE EMPTY";
        }

        mysqli_close($con);
        header("location: dyer_form.php");
    } else {
        echo "<p class='phperror'>Form not summited ! You need to select tnx_type!</p>";
    }
}

?>



<!-- attach php code here ends-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- headlinks starts -->
    <?php
    include_once "main/headlinks.php";
    ?>
    <!-- headlinks ends -->

    <!-- attach form css link here-->
    <link rel="stylesheet" href="css/dyer_form.css">
    <!-- attach form css link here ends-->


</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar starts-->
        <?php
        include_once "main/sidebar.php";
        ?>
        <!-- sidebar ends -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <!-- navbar starts -->
            <?php
            include_once "main/navbar.php";
            ?>
            <!-- navbar ends -->

            <div class="container-fluid">

                <!-- attach form container here starts -->
                <div class="container">
                    <form id="form_1" action="" method="post" autocomplete="off">
                        <h4 class="topic">Dyer Entry</h4>
                        <div class="row">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                <label for="id" class="col-sm-6 col-form-label text-right">Txn Type</label>

                                    <select name="txn_nam" id="txn_nam" style='width:400px; background-color:transparent;margin:0;padding:6px;' required>
                                        <option name="txn_nam" value="">--Select--</option>
                                        <option name="txn_nam" id="KORA_ISS" value="KORA_ISS"> Issue</option>
                                        <!-- <option name="txn_nam" id="KORA_RET" value="KORA_RET">Kora Return</option> -->
                                        <!-- <option value="Kora Waste">Kora Waste</option> -->
                                        <option name="txn_nam" id="SILK_RET" value="SILK_RET">Return</option>
                                        <option name="txn_nam" id="EDIT" value="EDIT">Edit</option>
                                    </select>
                                </div>
                                <div class="col-sm-6" id="from_loc">
                                    <label for="fromloc" class="col-sm-6 col-form-label text-right">From</label>
                                    <input list="fromlocs" name="fromloc" id="fromloc" class="form-control" placeholder="Select Where">
                                    <datalist id="fromlocs">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" name="fromloc_id" id="fromloc_id">
                                </div>
                                <div class="col-sm-6" id="to_loc_div">
                                    <label for="to_loc" class="col-sm-6 col-form-label text-right">To</label>
                                    <input list="to_locs" name="to_loc" id="to_loc" class="form-control" placeholder="Select Where">
                                    <datalist id="to_locs">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" name="to_loc_id" id="to_loc_id">

                                </div>
                            </div>
                            <div class="form-group row" style="display:none">
                                <label for="id" class="col-sm-12 col-form-label text-right">Id</label>
                                <div class="col-sm-12">
                                    <input type="text" style='width:400px' class="form-control" id="id" name="id" placeholder="" value="NEW" readonly>
                                </div>
                            </div>
                            <!-- Labels on the right side -->
                            <div class="col-md-6" id="issue_div">
                                <h4 class="topic">Issue</h4>


                                <div class="form-group row">
                                    <label for="iss_date" class="col-sm-6 col-form-label text-right">Issue Date</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="iss_date" name="iss_date" placeholder="" onkeydown="handleEnterKey(event, 'iss_time')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="iss_time" class="col-sm-6 col-form-label text-right">Issue Time</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="iss_time" name="iss_time" placeholder="" onkeydown="handleEnterKey(event, 'dyer_nam')" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dyer_nam" class="col-sm-6 col-form-label text-right">Dyer Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="twisterlist" class="form-control" id="dyer_nam" name="dyer_nam" placeholder="" onkeydown="handleEnterKey(event, 'iss_itm_nam')">
                                        <datalist id="twisterlist">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                            }
                                            ?>
                                        </datalist>

                                        <input type="hidden" class="form-control" id="dyer_id" name="dyer_id" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="iss_itm_nam" class="col-sm-6 col-form-label text-right">Issue Item Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="item_list" class="form-control" id="iss_itm_nam" name="iss_itm_nam" placeholder="" onchange="checkForSubstring2()" onkeydown="handleEnterKey(event, 'iss_desc')" onclick="this.select()">
                                        <datalist id="item_list">
                                            <?php
                                            $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE itm_sl='D/T' ORDER BY `itm_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                            }
                                            ?>
                                        </datalist> <input type="hidden" class="form-control" id="iss_itm_id" name="iss_itm_id" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="iss_itm_nam" class="col-sm-6 col-form-label text-right">Issue Item</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="item_list" class="form-control" id="iss_itm_nam" name="iss_itm_nam" placeholder="" onchange="checkForSubstring2()" onkeydown="handleEnterKey(event, 'iss_desc')" onclick="this.select()">
                                        <datalist id="item_list">
                                            <?php
                                            $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE itm_sl='D/T' ORDER BY `itm_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                            }
                                            ?>
                                        </datalist> <input type="hidden" class="form-control" id="iss_itm_id" name="iss_itm_id" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row" id='color_div2' style="visibility:hidden">
                                    <label for="col_nam2" class="col-sm-6 col-form-label text-right">Issue Colour Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="iss_col_list" class="form-control" id="col_nam2" name="col_nam2" placeholder="" onclick="this.select()">
                                        <datalist id="iss_col_list">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                                            }
                                            ?>
                                        </datalist>
                                        <input type="hidden" class="form-control" id="iss_col_id2" name="iss_col_id2" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="iss_desc" class="col-sm-6 col-form-label text-right">Description</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="iss_desc" name="iss_desc" placeholder="" onkeydown="handleEnterKey(event, 'iss_wght')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="iss_wght" class="col-sm-6 col-form-label text-right">Weight</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="iss_wght" name="iss_wght" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <!-- Labels on the left side -->
                            <div class="col-md-6" id="return_div">
                                <h4 class="topic">Return</h4>


                                <div class="form-group row">
                                    <label for="ret_date" class="col-sm-6 col-form-label text-right">Return Date</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="ret_date" name="ret_date" placeholder="" onkeydown="handleEnterKey(event, 'ret_time')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ret_time" class="col-sm-6 col-form-label text-right">Return Time</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="ret_time" name="ret_time" placeholder="" onkeydown="handleEnterKey(event, 'ret_dyer_nam')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ret_dyer_nam" class="col-sm-6 col-form-label text-right">Dyer Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="twisterlist" class="form-control" id="ret_dyer_nam" name="ret_dyer_nam" placeholder="" onkeydown="handleEnterKey(event, 'ret_itm_nam')">
                                        <datalist id="twisterlist1">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                            }
                                            ?>
                                        </datalist>
                                        <input type="hidden" class="form-control" id="ret_dyer_id" name="ret_dyer_id" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ret_itm_nam" class="col-sm-6 col-form-label text-right">Return Item Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="ret_item_list" class="form-control" id="ret_itm_nam" name="ret_itm_nam" placeholder="" onkeydown="handleEnterKey(event, 'col_nam')" onchange="checkForSubstring()" onclick="this.select()">
                                        <datalist id="ret_item_list">
                                            <?php
                                            $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE  itm_sl='BTH' ORDER BY `itm_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                            }
                                            ?>
                                        </datalist>

                                        <input type="hidden" class="form-control" id="ret_itm_id" name="ret_itm_id" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row" id='color_div' style="visibility:hidden">
                                    <label for="col_nam" class="col-sm-6 col-form-label text-right">Return Colour Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" list="ret_col_list" class="form-control" id="col_nam" name="col_nam" placeholder="" onkeydown="handleEnterKey(event, 'ret_desc')" onclick="this.select()">
                                        <datalist id="ret_col_list">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                                            }
                                            ?>
                                        </datalist>
                                        <input type="hidden" class="form-control" id="ret_col_id" name="ret_col_id" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ret_desc" class="col-sm-6 col-form-label text-right">Return Description</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="ret_desc" name="ret_desc" placeholder="" onkeydown="handleEnterKey(event, 'ret_wght')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ret_wght" class="col-sm-6 col-form-label text-right"> Return Weight</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="ret_wght" name="ret_wght" placeholder="" onkeydown="handleEnterKey(event, 'waste_wght')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="waste_wght" class="col-sm-6 col-form-label text-right"> Waste Weight</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" id="waste_wght" name="waste_wght" placeholder="" onkeydown="handleEnterKey(event, 'save')">
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- Submit button -->
                        <div class="row">
                            <div class="col-md-12">

                                <div class="right-side">
                                    <div class="buttons">
                                        <button type="submit" id='save'>Save</button>
                                        <button type="submit" id='update'>Update</button>
                                        <button type="button" onclick="window.location.reload();">New</button>
                                        <a href="admin.php"> <button type="button">Home</button></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Items From Dyers</h2>
                                <div class="input-div">
                                    <label for="dyer_nam_modal">Select Issued </label>

                                    <input list="twisterlists" type="text" name="dyer_nam_modal" id="dyer_nam_modal" placeholder="Type to search...">
                                    <datalist id="twisterlists">

                                        <?php
                                        $sql = mysqli_query($con, "SELECT  `id`, `iss_date`, `iss_time`, `dyer_id`, `dyer_nam`, 
                                            `iss_itm_id`, `iss_itm_nam`, `iss_desc`, `iss_wght` from `tbl_dyer` where tbl_status='ISS' order by id");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . $row['iss_date'] . $row['dyer_nam'] . "' data-grpid='" . $row['id'] . "'>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" id="hidden_dyer_id2" name="hidden_dyer_id2">
                                    <div class="btn btn-primary" onclick="fetch_dyer()">Proceed</div>
                                </div>


                            </div>
                        </div>

                        <div id="modaledit" class="modal">
                            <div class="modal-content">
                                <span class="close" id="close2">&times;</span>
                                <h2>Items From Dyer</h2>
                                <div class="input-div">
                                    <label for="dyer_nam_modal3">Select </label>

                                    <input list="twisterlists3" type="text" name="dyer_nam_modal3" id="dyer_nam_modal3" placeholder="Type to search...">
                                    <datalist id="twisterlists3">

                                        <?php

                                        $sql = mysqli_query($con, "SELECT  `id`, `iss_date`, `iss_time`, `dyer_id`, `dyer_nam`, 
                                        `iss_itm_id`, `iss_itm_nam`, `iss_desc`, `iss_wght` from `tbl_dyer` order by id desc");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . $row['iss_date'] . $row['dyer_nam'] . $row['iss_wght'] . "' data-grpid='" . $row['id'] . "'>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" id="hidden_dyer_id3" name="hidden_dyer_id3">
                                    <div class="btn btn-primary" onclick="fetch_dyer_edit()">Proceed</div>

                                </div>


                            </div>
                        </div>
                        <input type="hidden" id="dyerissid" name="dyerissid">

                    </form>
                </div>

                <!-- attach form container here ends -->

            </div>
        </div>

        <!-- /#page-content-wrapper ends-->
    </div>

    <!-- footer starts -->
    <?php
    include_once "main/footer.php";
    ?>
    <!-- footer ends -->

    <!-- attach form js code here  -->

    <script src="js/dyer_form.js"></script>
    <!-- attach form js code here  -->
</body>

</html>