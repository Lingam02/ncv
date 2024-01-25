<!DOCTYPE html>
<html>
<head>
    <title>Work Progress Report</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        /* Basic styling for print */
        @media print {
            body {
                font-size: 12pt;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
        }
        
        /* Styling for screen view */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            margin: 10px;
            text-align: center;
            font-size: 22px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
            background-color: white;
            overflow: auto;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            position: absolute;
            position: sticky;
            top: 0%;
            /* width: 100%; */
            background-color: #f2f2f2;
        }
        button {
            display: block;
            /* margin: 20px auto; */
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
     .TABLE-CONTAINER{
        overflow: auto;
     }
    </style>
</head>
<body>
 
    <h1>Work Progress Report</h1>
  <div class="TABLE-CONTAINER">
  <table>
        <thead>
        <tr>
            <th>Dept ID</th>
            <th>Start Date and Time</th>
            <th>Department</th>
            <th>Worker ID</th>
            <th>Worker Name</th>
            <th>Item Name</th>
            <th>Work start</th>
            <th>Work End</th>
            <th>Opening Balance</th>
            <th>Closing Balance</th>
            <th>Finish Quantity</th>
            <th>Finish Weight</th>
            <th>Finish Date</th>
        </tr>
        </thead>
        <?php
            include "config.php";

            $sql = "SELECT dept_id, dept, work_id, work_nam, it_nam,work_sess, work_end, opb_wght, clb_wght, finish_qty, finish_wght, st_datetime, close_datetime FROM work_progress";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "
                     
                <tr>
                    <td>" . $row["dept_id"] . "</td>
                    <td>" . $row["st_datetime"] . "</td>
                    <td>" . $row["dept"] . "</td>
                    <td>" . $row["work_id"] . "</td>
                    <td>" . $row["work_nam"] . "</td>
                    <td>" . $row["it_nam"] . "</td>
                    <td>" . $row["work_sess"] . "</td>
                    <td>" . $row["work_end"] . "</td>
                    <td>" . $row["opb_wght"] . "</td>
                    <td>" . $row["clb_wght"] . "</td>
                    <td>" . $row["finish_qty"] . "</td>
                    <td>" . $row["finish_wght"] . "</td>

                    <td>" . $row["close_datetime"] . "</td>
                    
                </tr>";
                }
            } else {
                echo "0 results";
            }

            $con->close();
        ?>
    </table>
  </div>
    <br>
    <div style="display:flex">
    <button onclick="window.print()">Print Report</button>
    <a href="admin.php">    <button class="homebutton">Home</button>
</a>
    </div>
</body>
</html>
