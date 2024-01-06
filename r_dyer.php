<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    //tot_iss
    $sql_tot_iss = "SELECT SUM(iss_wght) AS total_iss_wght FROM `tbl_dyer` WHERE `iss_date` BETWEEN '{$start_date}' AND '{$end_date}'";
    //tot_ret
    $sql_tot_ret = "SELECT SUM(ret_wght) AS total_ret_wght FROM `tbl_dyer` WHERE `ret_date` BETWEEN '{$start_date}' AND '{$end_date}'";

    //warp_iss
    $sql_tot_warp_iss = "SELECT SUM(iss_wght) AS total_iss_wght FROM `tbl_dyer`
    WHERE col_id = '' and `iss_date` BETWEEN '{$start_date}' AND '{$end_date}'";

    //warp_ret
    $sql_tot_warp_ret = "SELECT SUM(ret_wght) AS total_ret_wght FROM `tbl_dyer`
    WHERE col_id = '' and `ret_date` BETWEEN '{$start_date}' AND '{$end_date}'";

    //weft_iss
    $sql_tot_weft_iss = "SELECT SUM(iss_wght) AS total_iss_wght FROM `tbl_dyer`
         WHERE col_id != ''and `iss_date` BETWEEN '{$start_date}' AND '{$end_date}'";

    //weft_ret
    $sql_tot_weft_ret = "SELECT SUM(ret_wght) AS total_ret_wght FROM `tbl_dyer`
    WHERE col_id != ''and `ret_date` BETWEEN '{$start_date}' AND '{$end_date}'";

    // waste total wght
    $sql_tot_waste = "SELECT SUM(waste_wght) AS waste_wght FROM `tbl_dyer` WHERE `ret_date` BETWEEN '{$start_date}' AND '{$end_date}'";
    //warp waste total wght
    $sql_warp_waste = "SELECT SUM(waste_wght) AS waste_wght FROM `tbl_dyer` WHERE col_id = ''and `ret_date` BETWEEN '{$start_date}' AND '{$end_date}'";
    //weft waste total wght
    $sql_weft_waste = "SELECT SUM(waste_wght) AS waste_wght FROM `tbl_dyer` WHERE col_id != ''and `ret_date` BETWEEN '{$start_date}' AND '{$end_date}'";

    //table_all

    $result_sql_tot_iss = mysqli_query($con, $sql_tot_iss);
    $result_sql_tot_ret = mysqli_query($con, $sql_tot_ret);

    $result_sql_tot_warp_iss = mysqli_query($con, $sql_tot_warp_iss);
    $result_sql_tot_warp_ret = mysqli_query($con, $sql_tot_warp_ret);

    $result_sql_tot_weft_iss = mysqli_query($con, $sql_tot_weft_iss);
    $result_sql_tot_weft_ret = mysqli_query($con, $sql_tot_weft_ret);

    $result_sql_tot_waste = mysqli_query($con, $sql_tot_waste);

    $result_sql_warp_waste = mysqli_query($con, $sql_warp_waste);
    $result_sql_weft_waste = mysqli_query($con, $sql_weft_waste);



    $fetch_tot_iss = mysqli_fetch_assoc($result_sql_tot_iss);
    $fetch_tot_ret = mysqli_fetch_assoc($result_sql_tot_ret);

    $fetch_tot_warp_iss = mysqli_fetch_assoc($result_sql_tot_warp_iss);
    $fetch_tot_warp_ret = mysqli_fetch_assoc($result_sql_tot_warp_ret);

    $fetch_tot_weft_iss = mysqli_fetch_assoc($result_sql_tot_weft_iss);
    $fetch_tot_weft_ret = mysqli_fetch_assoc($result_sql_tot_weft_ret);

    $fetch_sql_tot_waste = mysqli_fetch_assoc($result_sql_tot_waste);

    $fetch_sql_warp_waste = mysqli_fetch_assoc($result_sql_warp_waste);
    $fetch_sql_weft_waste = mysqli_fetch_assoc($result_sql_weft_waste);
}
// 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Weight Statistics</title>
    <style>
        input:not([type="radio"]) {
            height: 28px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            border-radius: 2px !important;
            border: 1px solid #c7c5c5 !important;
            margin-bottom: 2px !important;
            background: transparent !important;
            /* background:  rgba(125, 188, 230, 0.533) !important; */
            color: blue !important;
            padding: 4px !important;

        }

        input:not([type="radio"]):focus {
            border-color: rgb(185, 183, 183) !important;
            box-shadow: 2px 2px 5px #bcbbbd !important;
            color: blue !important;
            background-color: #fff !important;
            outline-color: blue;
            outline-width: 1px;
        }

        .wraper {
            width: 70%;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            color: #000;
        }

        .contain {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            color: #000;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 14px;
            font-weight: 600;
        }

        td {
            color: blue;
            font-weight: bold;
        }

        .total {
            color: green;
        }

        @media print {
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px auto;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
                text-wrap: nowrap;
            }

            th {
                background-color: #f2f2f2;
                font-size: 14px;
                font-weight: 600;
            }

            td {
                color: #000;
                font-weight: normal;

            }

            .total {
                color: #000;
            }

            .wraper {
                width: 100%;
            }

            .non_print {
                display: none;
            }
        }

        .heading,
        .tbl_heading {
            text-align: center;
            text-transform: uppercase;
        }

        .btn_submit {
            width: 120px;
            height: 40px;
            /* margin-left: 10px; */
            margin-bottom: 10px;
            background-color: rgb(26, 26, 110);
            color: #fff;
            border: 1px solid #fff;
            font-weight: bold;
            padding: 6px 10px;

        }

        .date_title {
            text-align: left;
            color: blue;
        }
    </style>
</head>

<body>
    <div class="wraper">
        <form method="post" action="">
            <h2 class="heading">Dyer Transaction</h2>
            <div class="contain non_print">
                <label for="start_date">From:</label>
                <input type="date" id="start_date" name="start_date" required>
                <label for="end_date">To:</label>
                <input type="date" id="end_date" name="end_date" required>
                <button class="btn_submit" id="save"type="submit">Submit</button>
                <button class="btn_submit" type="button" onclick="window.print()">Print</button>
                <a href="admin.php"><button class="btn_submit" type="button">Home</button></a>
            </div>
        </form>
        <div id="wrap2">
        <?php echo '<h4 class="date_title">' . "From" . "&nbsp;  " . "&nbsp;" . $start_date . " " . "&nbsp;  " . "to" . "&nbsp;  " . "&nbsp;  " . $end_date . '</h4>' ?>
        <table>
            <tbody>
                <tr>
                    <td colspan='6' class='tbl_heading'>Total Item Weights Transaction</td>

                </tr>

                <tr>
                    <th>Warp Issued</th>
                    <td>
                        <?php
                        //warp iss 
                        if ($result_sql_tot_warp_iss && isset($fetch_tot_warp_iss['total_iss_wght'])) {
                            echo $fetch_tot_warp_iss['total_iss_wght'];
                        }
                        ?>
                    </td>
                    <th>Warp Returned</th>
                    <td>
                        <?php
                        //warp ret
                        if ($result_sql_tot_warp_ret && isset($fetch_tot_warp_ret['total_ret_wght'])) {
                            echo $fetch_tot_warp_ret['total_ret_wght'];
                        }
                        ?>
                    </td>
                    <th>Warp Waste</th>
                    <td>
                        <?php
                        //total warp waste
                        if ($result_sql_warp_waste && isset($fetch_sql_warp_waste['waste_wght'])) {
                            echo  $fetch_sql_warp_waste['waste_wght'];
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Weft Issued</th>
                    <td>
                        <?php
                        //weft iss 
                        if ($result_sql_tot_weft_iss && isset($fetch_tot_weft_iss['total_iss_wght'])) {
                            echo  $fetch_tot_weft_iss['total_iss_wght'];
                        }
                        ?>
                    </td>
                    <th>Weft Returned</th>
                    <td>
                        <?php
                        //weft ret
                        if ($result_sql_tot_weft_ret && isset($fetch_tot_weft_ret['total_ret_wght'])) {
                            echo $fetch_tot_weft_ret['total_ret_wght'];
                        }
                        ?>
                    </td>
                    <th>Weft Waste</th>
                    <td>
                        <?php
                        //total weft waste
                        if ($result_sql_weft_waste && isset($fetch_sql_weft_waste['waste_wght'])) {
                            echo $fetch_sql_weft_waste['waste_wght'];
                        }

                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Total Issued</th>
                    <td class="total"><?php
                                        if ($result_sql_tot_iss && isset($fetch_tot_iss['total_iss_wght'])) {
                                            echo  $fetch_tot_iss['total_iss_wght'];
                                        } ?></td>
                    <th>Total Returned</th>
                    <td class="total">
                        <?php

                        if ($result_sql_tot_ret && isset($fetch_tot_ret['total_ret_wght'])) {
                            echo  $fetch_tot_ret['total_ret_wght'];
                        }

                        ?>
                    </td>
                    <th>Total Waste</th>
                    <td class="total">
                        <?php
                        //total waste
                        if ($result_sql_tot_waste && isset($fetch_sql_tot_waste['waste_wght'])) {
                            echo  $fetch_sql_tot_waste['waste_wght'];
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php


        $sql_warp = "SELECT `iss_date`, `iss_time`, `dyer_nam`, `iss_itm_nam`, `iss_desc`, `iss_wght` FROM `tbl_dyer` WHERE `tbl_status` = 'ISS' AND `col_id` = ''and `iss_date` BETWEEN '{$start_date}' AND '{$end_date}'";

        $result_warp = mysqli_query($con, $sql_warp);
        echo '<h4 class="date_title">' . "From" . "&nbsp;  " . "&nbsp;" . $start_date . " " . "&nbsp;  " . "to" . "&nbsp;  " . "&nbsp;  " . $end_date . '</h4>';

        if (mysqli_num_rows($result_warp) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<td colspan='6' class='tbl_heading'>" . 'Issued Warp Not Returned From Dyer' . "</td>";
            echo "</tr>";
            echo "<tr><th>Issue Date</th><th>Issue Time</th><th>Dyer Name</th><th>Item Name</th><th>Description</th><th>Weight</th></tr>";
            while ($row = mysqli_fetch_assoc($result_warp)) {


                echo "<tr>";


                echo "<td>" . $row['iss_date'] . "</td>";
                echo "<td>" . $row['iss_time'] . "</td>";
                echo "<td>" . $row['dyer_nam'] . "</td>";
                echo "<td>" . $row['iss_itm_nam'] . "</td>";
                echo "<td>" . $row['iss_desc'] . "</td>";
                echo "<td>" . $row['iss_wght'] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found";
        }


        $sql_weft = "SELECT `iss_date`, `iss_time`, `dyer_nam`, `iss_itm_nam`, `iss_desc`, `iss_wght`, `col_nam` FROM `tbl_dyer` WHERE `tbl_status` = 'ISS' AND `col_id` != ''and `iss_date` BETWEEN '{$start_date}' AND '{$end_date}'";

        $result_weft = mysqli_query($con, $sql_weft);
        echo '<h4 class="date_title">' . "From" . "&nbsp;  " . "&nbsp;" . $start_date . " " . "&nbsp;  " . "to" . "&nbsp;  " . "&nbsp;  " . $end_date . '</h4>';

        if (mysqli_num_rows($result_weft) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<td colspan='8' class='tbl_heading'>" . 'Issued Weft Not Returned From Dyer' . "</td>";
            echo "</tr>";
            echo "<tr><th>Issue Date</th><th>Issue Time</th><th>Dyer Name</th><th>Item Name</th><th>Description</th><th>Weight</th><th>Column Name</th></tr>";
            while ($row = mysqli_fetch_assoc($result_weft)) {


                echo "<tr>";


                echo "<td>" . $row['iss_date'] . "</td>";
                echo "<td>" . $row['iss_time'] . "</td>";
                echo "<td>" . $row['dyer_nam'] . "</td>";
                echo "<td>" . $row['iss_itm_nam'] . "</td>";
                echo "<td>" . $row['iss_desc'] . "</td>";
                echo "<td>" . $row['iss_wght'] . "</td>";
                echo "<td>" . $row['col_nam'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found";
        }

        //total weft 
        $sql_tot_weft = "SELECT `iss_date`, `iss_itm_nam`, `iss_desc`, `iss_wght`, `col_nam`,`ret_date`,`ret_wght`,`waste_wght` FROM `tbl_dyer` WHERE `tbl_status` = 'RET' AND `col_id` != ''and `iss_date` BETWEEN '{$start_date}' AND '{$end_date}'";

        $result_tot_weft = mysqli_query($con, $sql_tot_weft);
        echo '<h4 class="date_title">' . "From" . "&nbsp;  " . "&nbsp;" . $start_date . " " . "&nbsp;  " . "to" . "&nbsp;  " . "&nbsp;  " . $end_date . '</h4>';

        if (mysqli_num_rows($result_tot_weft) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<td colspan='8' class='tbl_heading'>" . 'WEFT IN DYEING' . "</td>";
            echo "</tr>";
            echo "<tr><th>Issue Date</th><th>Item Name</th><th>Description</th><th>Column Name</th><th>Issue Weight</th><th>Return Date</th><th>Return Wght</th><th>Loss of Wght</th></tr>";
            while ($row = mysqli_fetch_assoc($result_tot_weft)) {


                echo "<tr>";


                echo "<td>" . $row['iss_date'] . "</td>";
                echo "<td>" . $row['iss_itm_nam'] . "</td>";
                echo "<td>" . $row['iss_desc'] . "</td>";
                echo "<td>" . $row['col_nam'] . "</td>";
                echo "<td>" . $row['iss_wght'] . "</td>";
                echo "<td>" . $row['ret_date'] . "</td>";
                echo "<td>" . $row['ret_wght'] . "</td>";
                echo "<td>" . $row['waste_wght'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found";
        }


        ?>
</div>
    </div>
</body>
<script>
    //============ script for date set default in input field visible starts===============
    window.onload = function() {
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1; // Month is zero-based
        var year = currentDate.getFullYear();

        // Format the date as YYYY-MM-DD (ISO format)
        var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');

        // Set the value attribute of the input field

        document.getElementById('start_date').value = formattedDate;
        document.getElementById('end_date').value = formattedDate;

    };

    //=============== script for date ends ================= 
    // document.getElementById('wrap2').style.display = "none";
    // document.getElementById('save').addEventListener('click',function () {
    // document.getElementById('wrap2').style.display = "block";
        
    // })
</script>

</html>

<?php mysqli_close($con); ?>