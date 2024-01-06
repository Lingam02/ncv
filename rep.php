<?php
include "config.php";

// Execute SQL queries to get aggregated data
$sqlRawStore = "SELECT loc_name, tbl_type, SUM(wght) AS total_weight
                FROM tbl_opening
                WHERE loc_name = 'RAW STORE' AND tbl_type = 'WEFT'
                GROUP BY loc_name, tbl_type";

$sqlDyedSilkStore = "SELECT loc_name, tbl_type, SUM(wght) AS total_weight
                     FROM tbl_opening
                     WHERE loc_name = 'DYED SILK STORE' AND tbl_type = 'WEFT'
                     GROUP BY loc_name, tbl_type";

$sqlBobinStore = "SELECT loc_name, tbl_type, SUM(wght) AS total_weight, date_time AS from_date_time
                     FROM tbl_opening
                     WHERE loc_name = 'BOBIN STORE' AND tbl_type = 'WEFTBS'
                     GROUP BY loc_name, tbl_type";

$sqlPirnStore = "SELECT loc_name, tbl_type, SUM(wght) AS total_weight, date_time AS from_date_time
                     FROM tbl_opening
                     WHERE loc_name = 'PIRN STORE' AND tbl_type = 'WEFTPS'
                     GROUP BY loc_name, tbl_type";

// Execute the queries and fetch data
$resultRawStore = mysqli_query($con, $sqlRawStore);
$resultDyedSilkStore = mysqli_query($con, $sqlDyedSilkStore);
$resultBobinStore = mysqli_query($con, $sqlBobinStore);
$resultPirnStore = mysqli_query($con, $sqlPirnStore);

// Fetch data and process results
$rowRawStore = mysqli_fetch_assoc($resultRawStore);
$rowDyedSilkStore = mysqli_fetch_assoc($resultDyedSilkStore);
$rowBobinStore = mysqli_fetch_assoc($resultBobinStore);
$rowPirnStore = mysqli_fetch_assoc($resultPirnStore);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, th, td {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 10px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Raw Store</th>
                <th>Dyed Silk Store</th>
                <th>BOBIN Store</th>
                <th>PIRN Store</th>
                <th>FROM Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $rowRawStore['total_weight']; ?></td>
                <td><?php echo $rowDyedSilkStore['total_weight']; ?></td>
                <td><?php echo $rowBobinStore['total_weight']; ?></td>
                <td><?php echo $rowPirnStore['total_weight']; ?></td>
                <td><?php echo $rowBobinStore['from_date_time']; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
