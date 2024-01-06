<?php
include "config.php";

$user_name = "";
$start_date = date("d-m-Y");
$end_date = date("d-m-Y");
// Initialize variables
$reportOutput = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = $_POST["user_name"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    // Sanitize the input to prevent SQL injection
    $user_name = mysqli_real_escape_string($con, $user_name);

    // Assuming "work_progress" table structure:
    // Add all the columns you mentioned here
    $sql = "SELECT id, work_sess, work_prog, st_datetime, it_id, it_nam, work_id, work_nam, work_end, opb, clb, finish_date, finish_qty, finish_wght, dept_id, dept, col_id, col_nam, close_datetime, cmp_id FROM work_progress WHERE work_nam IN (SELECT ac_nam FROM acct WHERE user_nam = '$user_name') AND finish_date BETWEEN '$start_date' AND '$end_date'";
    $result = $con->query($sql);

    // For demonstration purposes, let's build the report output
    if ($result->num_rows > 0) {

        $reportOutput .= "<table>";
        $reportOutput .=
            "<tr>
        <th>Company</th>
        <th class='none'>ID</th>
        <th>Work Session</th>
        <th>Work End</th>

        <th>Work Program</th>   
        <th>Starting Time</th>
        <th class='none'>Item ID</th>
        <th>Item Name</th>
        <th class='none'>Work ID</th>
        <th class='none'>Work Name</th>
        <th>Opening</th>
        <th>Closing</th>
        <th>Finish Date</th>
        <th>Finish Quantity</th>
        <th>Finish Weight</th>
        <th class='none'>Dept ID</th>
        <th>Unit</th>
        <th class='none'>Column ID</th>
        <th>Column Name</th>
        <th>Closing Time</th>
      
    </tr>";
        while ($row = $result->fetch_assoc()) {
            $reportOutput .= "<tr>";
            $reportOutput .=

                "
            <td>" . $row["cmp_id"] . "</td>
            <td class='none'>" . $row["id"] . "</td>
            <td>" . $row["work_sess"] . "</td>
            <td>" . $row["work_end"] . "</td>
            <td>" . $row["work_prog"] . "</td>
            <td>" . $row["st_datetime"] . "</td>
            <td class='none'>" . $row["it_id"] . "</td>
            <td>" . $row["it_nam"] . "</td>
            <td class='none'>" . $row["work_id"] . "</td>
            <td class='none'>" . $row["work_nam"] . "</td>
           
            <td>" . $row["opb"] . "</td>
            <td>" . $row["clb"] . "</td>
            <td>" . $row["finish_date"] . "</td>
            <td>" . $row["finish_qty"] . "</td>
            <td>" . $row["finish_wght"] . "</td>
            <td class='none'>" . $row["dept_id"] . "</td>
            <td>" . $row["dept"] . "</td>
            <td class='none'>" . $row["col_id"] . "</td>
            <td>" . $row["col_nam"] . "</td>
            <td>" . $row["close_datetime"] . "</td>

            ";
            $reportOutput .= "</tr>";
        }
        $reportOutput .= "</table>";
    } else {
        $reportOutput = "No results found !";
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single user reports</title>
    <link rel="stylesheet" href="css/weaver_report.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <h2 class="form-heading">Single User Report</h2>
    <div class="container-custom">

        <form action="" method="post">
            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" required>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            <button type="submit" id="generate">Generate Report</button>
            <a href="admin.php"> <button class="homebutton" type="button">Home</button></a>
        </form>
    </div>
    <div class="report">

        <div id="userdiv">
            <h3>User Name <span> <?php echo $user_name; ?></span></h3> <!-- Add the user name heading here -->
            <h3>User report from <span> <?php echo  $start_date ?></span> to <span><?php echo  $end_date ?></span></h3>
        </div>
        <?php echo $reportOutput; ?>
    </div>

    <!-- 
    <script>
        // Set default values for start_date and end_date to today's date
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').value = today;
        document.getElementById('end_date').value = today;
    </script> -->
    <script src="js/weaver_report.js"></script>
</body>

</html>