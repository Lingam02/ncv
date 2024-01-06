<?php
include "config.php";
$sql1  = "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam";
$result = $con -> query($sql1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $colour_name = $_POST["colourname"];

  if ($colour_name !== "") {
    $sql = "INSERT INTO cnf (nam, cls, id) VALUES ('$colour_name', 'COLOR', 'COLOR')";

    if ($con->query($sql) === TRUE) {
      // Redirect to the same page with a success parameter
      header('Location: colour_creation.php?success=1');
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $con->error;
    }
  }

  $con->close();
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
  <style>
    .btn_tog {
      width: 200px;
      height: 40px;
      /* margin-left: 10px; */
      margin-bottom: 10px;
      background-color: rgb(26, 26, 110);
      color: #fff;
      border: 1px solid #fff;
      font-weight: bold;
      padding: 6px 10px;

    }
    .tbl_1{
      max-height: 500px;
      overflow: auto;
    }
    thead{
      position: sticky;
      top: 0;
    }
  </style>
  <!-- attach form css link here-->
  <link rel="stylesheet" href="css/user.css">
  <link rel="stylesheet" href="css/opening_report1.css">
  <!-- attach form css link here ends-->
  <script>
    window.onload = function() {
      const urlParams = new URLSearchParams(window.location.search);
      const success = urlParams.get('success');

      if (success === '1') {
        const snackbar = document.getElementById("snackbar");
        snackbar.textContent = "Colour Created Successfully";
        snackbar.className = "show";
        setTimeout(function() {
          snackbar.className = snackbar.className.replace("show", "");
        }, 3000);
      }
    }
  </script>

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

      <div class="container-fluid px-4">
          <button id="btn_toggle_report" class="btn_tog" type="button">View List</button>
          <button id="btn_toggle_form" class="btn_tog" type="button" onclick="location.reload()">View Creation</button>
          <div class="printonly" id="report">
            <a href="admin.php"><button id="print" class="non-print">Home</button></a>
            <button onclick="printTableContainer()" id="print" class="non-print">Print</button>
            <!-- attach form container here starts -->

            <div class="tbl_1">
              <table>
                <thead>
                  <tr style="text-align:center;font-weight:600" >
                    <td class="tbl_heading" colspan="4">List of Colours</td>
                  </tr>
                  <tr>
                    <th>S.No</th>
                    <!-- <th>Id</th> -->
                    <!-- <th>Colour Id</th> -->
                    <th>Colour Name</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                    $serialNumber = 1;
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $serialNumber . "</td>";
                      // echo "<td>" . $row["id"] . "</td>";
                      // echo "<td>" . $row["auto_id"] . "</td>";
                      echo "<td>" . $row["nam"] . "</td>";
                      // Edit and Delete links added in the Action column
                      // echo "<td class='non-print'><a href='edit_bobin.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_bobin.php?id=" . $row['id'] . "'>Delete</a></td>";
                      echo "</tr>";
                      $serialNumber++;
                    }
                  } else {
                    echo "<tr><td colspan='4'>0 results</td></tr>";
                  }
                  ?>
                </tbody>
              </table>


            </div>

            <!-- attach form container here ends -->

          </div><!-- attach form container here starts -->


          <div class="body" id='create_bobin'>
          <div class="container-custom">
          <h2>Colour Creation</h2>
          <form id="colour_creationform" action="" method="post" autocomplete="off">

            <div class="form-group">
              <label for="colourname">Colour Name</label>
              <input class="text-uppercase" type="text" id="colourname" name="colourname" required>
            </div>

            <div class="form-group buttons">
              <button type="submit">Create Colour</button>
              <a href="admin.php"><button type="button">Home</button></a>
            </div>

          </form>

        </div>
          </div>
          <!-- attach form container here ends -->

        </div>

      <!-- /#page-content-wrapper ends-->
    </div>

    <!-- footer starts -->
    <?php
    include_once "main/footer.php";
    ?>
    <!-- footer ends -->

    <!-- attach form js code here  -->
    <div id="snackbar"></div>
    <script>
      function printTableContainer() {
        var content = document.querySelector('.printonly').innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title><link rel="stylesheet" href="css/opening_report1.css"></head><body>' + content + '</body></html>');
        printWindow.document.close();
        printWindow.print();
        // Close the print window/tab after printing
        printWindow.setTimeout(function() {
          printWindow.close();
        }, 1000); // Adjust the delay if needed (in milliseconds)
      }


      document.getElementById('report').style.display = 'none';
      document.getElementById('btn_toggle_form').style.display = 'none';
      document.getElementById('btn_toggle_report').addEventListener('click', function() {
        document.getElementById('report').style.display = 'block';
        document.getElementById('create_bobin').style.display = 'none';
        document.getElementById('btn_toggle_report').style.display = 'none';
        document.getElementById('create_bobin').style.display = 'none';
        document.getElementById('btn_toggle_form').style.display = 'block';


      })
    </script>
    <!-- attach form js code here  -->
</body>

</html>