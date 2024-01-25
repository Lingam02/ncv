<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/stock_report.css">
</head>

<body>

    <div class="container-fluid pagecover">
        <h4 class="form-heading">Stock Report</h4>

        <!-- attach form container here starts -->
        <div class="container-fluid mt-2 rep">
            <div class="input-div">
                <label for="">Group Name</label>
                <input class="form-control" type="text" name="grp_name" id="grp_name" onkeydown="handleEnterKey(event, 'itm_name')">
            </div>
            <div class="input-div">
                <label for="">Item Name</label>

                <input class="form-control" type="text" name="itm_name" id="itm_name" list="itm_name_options" class='text-uppercase' placeholder="Type to select category..." onkeydown="handleEnterKey(event, 'from')">
                <datalist id="itm_name_options">
         
                </datalist>
            </div>
            <div class="input-div">
                <label for="">Report Period</label>
                <input class="form-control" type="date" name="from" id="from" onkeydown="handleEnterKey(event, 'to')">

            </div>
            <div class="input-div">
                <label for="">to</label>
                <input class="form-control" type="date" name="to" id="to" onkeydown="handleEnterKey(event, 'getreport')">
            </div>
        </div>
        <div class="buttons">
            <div><button id="getreport">Get Report</button></div>
            <div><button>Exit</button></div>
        </div>

        <!-- attach form container here ends -->
        <div class="clearfix"></div>

    </div>
    <div class="table-frame">
        <table id="report-table">
            <thead>
                <tr>
                    <th rowspan="2">Date</th>
                    <th rowspan="2">Doc.No</th>
                    <th rowspan="2">From/To</th>
                    <th rowspan="2">Description</th>
                    <th colspan="2">Rec.Qty</th>
                    <th colspan="2">Iss.Qty</th>
                </tr>
                <tr>

                    <th>Sta.Qty</th>
                    <th>End.Qty</th>
                    <th>Sta.Qty</th>
                    <th>End.Qty</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>
                <tr>
                    <td>03/05/2023</td>
                    <td>1231137</td>
                    <td>Elangovan C/O</td>
                    <td>Silk Warp(Pavu)</td>
                    <td>546</td>
                    <td>700</td>
                    <td>546</td>
                    <td>700</td>
                </tr>


            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total Transaction</th>
                    <th>5003</th>
                    <th>400</th>
                    <th>5003</th>
                    <th>400</th>
                </tr>
                <tr>
                    <th colspan="4">Closing Balance</th>
                    <th colspan="2">5000</th>
                    <th colspan="2">5000</th>

                </tr>
            </tfoot>

        </table>
    </div>


</body>

</html>