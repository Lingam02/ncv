<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bobin Transaction Report</title>
  <!-- Bootstrap CSS link -->
  <style>
    .table-responsive{
        max-height:600px;
    }
    th,td{
        text-wrap: nowrap;
    }
    @media print {
    
      .table-responsive {
       
        max-height: 100%;
      }
      .non_print{
        display:none !important;
        float:right;
      }
    }
  </style>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid">
    <h2>Bobin Transaction Report</h2>
    <a href="admin.php">  <button type="button" class="non_print btn btn-success mb-3">Home</button></a>
    <button type="button" class="non_print btn btn-dark mb-3" onclick="window.print()">Print</button>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Reference ID</th>
            <th>Bobin ID</th>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Colour ID</th>
            <th>Colour Name</th>
            <th>Transaction Type</th>
            <th>Issued Weights</th>
            <th>Returned Weights with Bobin</th>
            <th>Returned Total Weight</th>
            <th>Total Weight</th>
            <th>Total Weight with Bobin</th>
            <th>Issue Date</th>
            <th>Return Date</th>
            <th>No. of Pirns Finished</th>
            <th>Total Weight of Pirns</th>
            <th>Returned Bobin Weights in Pirn</th>
            <th>Total Returned Bobin Weight in Pirn</th>
            <!-- Add more headers for other fields -->
          </tr>
        </thead>
        <tbody>
          <?php
            // Database connection
        include "config.php";
            // Your SQL query to retrieve data from the bobin_trans table
            $sql = "SELECT * FROM `bobin_trans` where txn_type = 'RET'"; // Retrieve all fields
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['reff_id'] . "</td>";
                echo "<td>" . $row['bobin_id'] . "</td>";
                echo "<td>" . $row['itm_id'] . "</td>";
                echo "<td>" . $row['itm_nam'] . "</td>";
                echo "<td>" . $row['col_id'] . "</td>";
                echo "<td>" . $row['col_nam'] . "</td>";
                echo "<td>" . $row['txn_type'] . "</td>";
                echo "<td>" . $row['iss_wghts'] . "</td>";
                echo "<td>" . $row['ret_wghts_withbobin'] . "</td>";
                echo "<td>" . $row['ret_ttl_wght'] . "</td>";
                echo "<td>" . $row['ttl_wght'] . "</td>";
                echo "<td>" . $row['ttl_wght_withbobin'] . "</td>";
                echo "<td>" . $row['issue_date'] . "</td>";
                echo "<td>" . $row['return_date'] . "</td>";
                echo "<td>" . $row['no_of_pirnsfinished'] . "</td>";
                echo "<td>" . $row['ttl_wghtof_pirns'] . "</td>";
                echo "<td>" . $row['ret_bobinwghts_inpirn'] . "</td>";
                echo "<td>" . $row['ttl_retbobin_wght_inpirn'] . "</td>";
                // Add more table data cells for other fields
                // Example: echo "<td>" . $row['FIELD_NAME'] . "</td>", ...
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='19'>No records found</td></tr>";
            }

            mysqli_close($con); // Close the database connection
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Bootstrap JS and jQuery links (for Bootstrap functionality) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
