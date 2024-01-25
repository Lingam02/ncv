<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tnx_nam = $_POST['txn_nam'];
    $dye_nam = $_POST['to_from'];
    $dye_id = $_POST['hidden_dyer_id'];
    $dye_nam2 = $_POST['dyer_nam_modal'];
    $dye_id2 = $_POST['hidden_dyer_id2'];
    $doc_no =  $_POST['doc_no'];
    $doc_date = $_POST['doc_date'];
    $reff_no = $_POST['reff_no'];
    $reff_date = $_POST['reff_date'];
    $it_nam = $_POST['itm_name'];
    $it_id = $_POST['it_id'];
    $wght = $_POST['qty'];
    $tot_qty = $_POST['tot_qty'];
    $remarks = $_POST['remarks'];

    if ($tnx_nam != "") {

        // -----------------------------------------------------------------------
        $con = mysqli_connect($host, $user, $password, $dbname);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        // -----------------------------------------------------------------------

        // -----------------------------------------------------------------------
        if ($tnx_nam === "KORA_ISS" && $dye_nam !== "") {

            $tnx_type = "RAW_ISS";

            $insertQuery = "INSERT INTO dyer_hd (txn_type,txn_nam, iss_date, dyer_id, dyer_nam, ttl_wght) 
                        VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertQuery);

            if (!$stmt) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            mysqli_stmt_bind_param($stmt, 'sssssd', $tnx_type, $tnx_nam, $doc_date, $dye_id, $dye_nam, $tot_qty);
            mysqli_stmt_execute($stmt);
            //$iss_no = 0;
            $lastid = mysqli_insert_id($con);
            $iss_no = "ISS" . $lastid;

            mysqli_stmt_close($stmt);

            //----------------------- update issue no ------------------------------------------------------
            $updateQuery = "UPDATE dyer_hd SET iss_no = ? WHERE id = ?";
            $stmt = mysqli_prepare($con, $updateQuery);

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'ss', $ret_id_value, $condition_value);

            $ret_id_value = $iss_no;
            $condition_value = $lastid;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            //-------------------------- update issue no end ----------------------------------------------

            $insertQuery2 = "INSERT INTO dyer_det (txn_type,txn_nam, dyer_id, iss_no, itm_id, itm_nam, remarks, wght) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($con, $insertQuery2);

            if (!$stmt2) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            for ($i = 0; $i < count($it_id); $i++) {
                if ($it_id[$i] !== "") {
                    mysqli_stmt_bind_param($stmt2, 'sssssssd', $tnx_type, $tnx_nam, $dye_id, $iss_no, $it_id[$i], $it_nam[$i], $remarks[$i], $wght[$i]);
                    mysqli_stmt_execute($stmt2);
                }
            }

            mysqli_stmt_close($stmt2);

            // //warp table --------------starts
            // $status = "DYING";
            // $query_warp_tbl = "INSERT INTO warp ( dyer_id, iss_no,iss_date,status_code, wght) 
            //             VALUES (?, ?, ?, ?, ?)";
            // $stmt_warp = mysqli_prepare($con, $query_warp_tbl);

            // if (!$stmt_warp) {
            //     echo "Statement preparation failed: " . mysqli_error($con);
            //     exit();
            // }

            // for ($i = 0; $i < count($it_id); $i++) {
            //     if ($it_id[$i] !== "") {
            //         mysqli_stmt_bind_param($stmt_warp, 'ssssd',  $dye_id, $iss_no, $doc_date, $status, $wght[$i]);
            //         mysqli_stmt_execute($stmt_warp);
            //     }
            // }

            // mysqli_stmt_close($stmt_warp);

            // //warp table --------------ends

        }
        // -----------------------------------------------------------------------
        
        else if ($tnx_nam === "SILK_RET") {
            // -------------------  silk return -------------- and kora waste -------------------------
            $tnx_type2 = "SILK_RET";

            $tot_qty_silk_ret = "-" . $tot_qty;
            $ret_wght = $wght;

            $insertQuery_silkret = "INSERT INTO dyer_hd (txn_type,txn_nam,iss_no, ret_date,iss_date, dyer_id, dyer_nam, ttl_wght) 
            VALUES (?, ?, ?, ?,?, ?, ?, ?)";
            $stmt_silkret = mysqli_prepare($con, $insertQuery_silkret);



            if (!$stmt_silkret) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            mysqli_stmt_bind_param($stmt_silkret, 'sssssssd', $tnx_type2, $tnx_nam, $reff_no, $doc_date, $reff_date, $dye_id, $dye_nam, $tot_qty_silk_ret);
            mysqli_stmt_execute($stmt_silkret);

            $lastid = mysqli_insert_id($con);
            $ret_no = "RET" . $lastid;

            mysqli_stmt_close($stmt_silkret);

            $insertQuery3 = "INSERT INTO dyer_det (txn_type,txn_nam, dyer_id,iss_no, ret_no, itm_id, itm_nam, remarks, wght) 
                                   VALUES (?, ?, ?, ?, ?, ?,?, ?, ?)";
            $stmt3 = mysqli_prepare($con, $insertQuery3);

            if (!$stmt3) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            for ($i = 0; $i < count($it_id); $i++) {
                if ($it_id[$i] !== "") {
                    $qty = $ret_wght[$i] * (-1);
                    mysqli_stmt_bind_param($stmt3, 'ssssssssd', $tnx_type2, $tnx_nam, $dye_id, $reff_no,$ret_no,$it_id[$i],$it_nam[$i],$remarks[$i],$qty );
                    mysqli_stmt_execute($stmt3);
                }
            }
            mysqli_stmt_close($stmt3);

            //warp table --------------starts
            $status = "HAND";
            $query_warp_tbl = "INSERT INTO warp ( dyer_id, iss_no,ret_no,ret_date,iss_date,status_code, wght) 
                        VALUES (?, ?, ?, ?, ?,?, ?)";
            $stmt_warp = mysqli_prepare($con, $query_warp_tbl);

            if (!$stmt_warp) {
                echo "Statement preparation failed: " . mysqli_error($con);
                exit();
            }

            for ($i = 0; $i < count($it_id); $i++) {
                if ($it_id[$i] !== "") {
                    $qty = $wght[$i] * (-1);

                    mysqli_stmt_bind_param($stmt_warp, 'ssssssd',  $dye_id, $reff_no, $doc_no, $doc_date, $reff_date, $status, $qty);
                    mysqli_stmt_execute($stmt_warp);
                }
            }

            mysqli_stmt_close($stmt_warp);

            //warp table --------------ends
        }

        // -----------------------------------------------------------------------
       
        else {
            echo "DYER NAME AND TXN TYPE CAN'T BE EMPTY";
        }

        mysqli_close($con);
        header("location: dyer.php");
    } else {
        echo "<p class='phperror'>Form not summited ! You not select To/From Name !</p>";
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
    <link rel="stylesheet" href="css/dyer.css">
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
                <form action="" id="dyerform" method="post" autocomplete="off">
                    <h4 class="text-center">DYE / TWISTER ENTRY</h4>
                    <div class="wrap-all">
                        <div class="left-side">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="input-div">
                                            <label for="txn_nam">Txn Type</label>
                                            <select name="txn_nam" id="txn_nam">
                                                <option name="txn_nam" value="">--Select--</option>
                                                <option name="txn_nam" id="KORA_ISS" value="KORA_ISS">Kora Issue</option>
                                                <!-- <option name="txn_nam" id="KORA_RET" value="KORA_RET">Kora Return</option> -->
                                                <!-- <option value="Kora Waste">Kora Waste</option> -->
                                                <option name="txn_nam" id="SILK_RET" value="SILK_RET">Silk Return</option>
                                            </select>
                                        </div>
                                        <div class="input-div">
                                            <label for="To/From">To/From</label>

                                            <input list="twisterlist" type="text" name="to_from" id="to_from" placeholder="Type to search...">
                                            <datalist id="twisterlist">

                                                <?php
                                                $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                                while ($row = $sql->fetch_assoc()) {
                                                    echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="input-div">
                                            <label for="Doc.No.">Doc.No.</label>
                                            <input type="text" name="doc_no" value="NEW" id="doc_no">
                                        </div>
                                        <div class="input-div">
                                            <label for="Doc.Date">Doc.Date</label>
                                            <input type="date" name="doc_date" id="doc_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4" id="reff_none">
                                        <div class="input-div">
                                            <label for="Reff.no">Reff.no</label>
                                            <input type="text" name="reff_no" id="reff_no">
                                        </div>
                                        <div class="input-div">
                                            <label for="reff.Date">Reff.Date</label>
                                            <input type="date" name="reff_date" id="reff_date">
                                        </div>
                                        <input type="hidden" name="hidden_dyer_id" id="hidden_dyer_id">
                                        <input type="hidden" name="hidden_dyer_id2" id="hidden_dyer_id2">
                                        <!-- <input type="hidden" name="hidden_dyer_id3" id="hidden_dyer_id3"> -->
                                    </div>
                                </div>
                            </div>


                            <div class="table-container">
                                <table id="raw_table">
                                    <thead>
                                        <tr>
                                            <th style="width:40vw;">Item Name</th>
                                            <th style="width:60vw;">Description</th>
                                            <th style="width:30vw;">Wght</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <tr class="item-row">
                                            <td>
                                                <input list="dyerlist" type="text" name="itm_name[]" class="itm-name" id="item-name" placeholder="Search item name..." onchange="getitemid(this)" onclick="this.select()">
                                                <datalist id="dyerlist">
                                                    <?php
                                                    $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE  itm_sl='BTH' or itm_sl='D/T' ORDER BY `itm_nam`");
                                                    while ($row = $sql->fetch_assoc()) {
                                                        echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                                    }
                                                    ?>
                                                </datalist>
                                            </td>


                                            <td>
                                                <input type="text" name="remarks[]" class="descr">
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" class="qty">
                                            </td>
                                            <td style="display:none">
                                                <input type="hidden" name="it_id[]" class="it_id">
                                            </td>
                                            <!-- 
                                            <td>
                                                <button type="button" class="delete-row">x</button>
                                            </td> -->
                                        </tr>
                                    </tbody>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th style="width:40vw;"></th>
                                                <th style="width:60vw;"></th>
                                                <th style="width:30vw;">
                                                    <input type="number" name="tot_qty" id="tot_qty" readonly>
                                                </th>


                                            </tr>
                                        </tbody>
                                    </table>
                                </table>
                                <button type="button" class="add-row" id="add-row" onclick="addRow()">Add Row</button>
                            </div>

                            <div class="right-side">
                                <div class="buttons">
                                    <button type="submit">Save</button>
                                    <button type="button" onclick="window.location.reload();">New</button>
                                    <a href="admin.php"> <button type="button">Exit</button></a>
                                    <button type="button">Delete</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div id="modal" class="modal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h2>Items From Dyer</h2>
                                    <div class="input-div">
                                        <label for="To/From">To/From</label>

                                        <input list="twisterlist" type="text" name="dyer_nam_modal" id="dyer_nam_modal" placeholder="Type to search...">
                                        <datalist id="twisterlist">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="table-container">
                                        <table id="raw_table2">
                                            <thead>
                                                <tr>
                                                    <th>Return</th>
                                                    <th>Issue Date</th>
                                                    <th>Issue NO</th>
                                                    <th>Item Name</th>
                                                    <th>Description</th>
                                                    <th>Wght</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body2">
                                                <tr class="item-row">
                                                    <td>
                                                        <input type="checkbox" name="tick" id="tick" onchange="transferValue(this)">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="iss_date2[]" class="descr">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="iss_no2[]" class="descr">
                                                    </td>
                                                    <td>
                                                        <input list="dyerlist" type="text" name="itm_name2[]" class="itm-name" id="item-name" placeholder="Search item name..." onchange="getitemid(this)">
                                                        <datalist id="dyerlist">
                                                            <?php
                                                            $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE  itm_sl='BTH' or itm_sl='D/T' ORDER BY `itm_nam`");
                                                            while ($row = $sql->fetch_assoc()) {
                                                                echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </td>


                                                    <td>
                                                        <input type="text" name="remarks2[]" class="descr">
                                                    </td>

                                                    <td>
                                                        <input type="number" name="qty2[]">
                                                    </td>
                                                    <td style="display:none">
                                                        <input type="hidden" name="it_id2[]" class="it_id">
                                                    </td>

                                                </tr>
                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            </div>
                            <!-- <div id="raw_return" class="modal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h2>KORA RETURN</h2>
                                    <div class="input-div">
                                        <label for="To/From">To/From</label>

                                        <input list="twisterlist" type="text" name="dyer_nam_modal2" id="dyer_nam_modal2" placeholder="Type to search...">
                                        <datalist id="twisterlist">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="table-container">
                                        <table id="raw_table3">
                                            <thead>
                                                <tr>
                                                    <th>Return</th>
                                                    <th>Issue Date</th>
                                                    <th>Issue NO</th>
                                                    <th>Item Name</th>
                                                    <th>Description</th>
                                                    <th>Wght</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body3">
                                                <tr class="item-row">
                                                <td>
                                                        <input type="checkbox" name="tick" id="tick" onchange="transferValue2(this)">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="iss_date3[]" class="descr">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="iss_no3[]" class="descr">
                                                    </td>
                                                    <td>
                                                        <input list="dyerlist" type="text" name="itm_name3[]" class="itm-name" id="item-name" placeholder="Search item name..." onchange="getitemid(this)">
                                                        <datalist id="dyerlist">
                                                            <?php
                                                            $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE  itm_sl='BTH' or itm_sl='D/T' ORDER BY `itm_nam`");
                                                            while ($row = $sql->fetch_assoc()) {
                                                                echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="remarks3[]" class="descr">
                                                    </td>

                                                    <td>
                                                        <input type="number" name="qty3[]" class="qty">
                                                    </td>
                                                    <td style="display:none">
                                                        <input type="hidden" name="it_id3[]" class="it_id">
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div> -->
                        </div>

                </form>
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

    <script src="js/dyer.js"></script>
    <!-- attach form js code here  -->
</body>

</html>