

<?php
include "config.php";
// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

$uname = $_SESSION['uname'];
if (isset($_POST['save'])) {

  date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time

  $currentDateTime = date('Y-m-d H:i:s'); // Format: Year-Month-Day Hours:Minutes:Seconds
  // echo "data submited";
  $workid = $_POST['workname'];
  $workname = $_POST['selectedName'];

  $fromid = $_POST['selectedloc'];
  $fromname = $_POST['fromloc'];

  $unitid = $_POST['selectedunit'];
  $unitname = $_POST['unitname'];

  $opb_qty = $_POST['itemopb_bobinqty'];

  $bobins = $_POST['bobins'];
  $bobins_id = $_POST['hidden_bobin_id'];

  $box_nam = $_POST['boxes'];
  $hidden_box_id = $_POST['hidden_box_id'];

  $hidden_colorid = $_POST['hidden_colorid'];
  $box_colornames = $_POST['colornames'];


  
  if ($workname != "" && $unitname != "") {
    $sql = "INSERT INTO `work_progress`(`work_sess`, `work_prog`, `work_id`, `work_nam`,`no_bobins`,`dept_id`, `dept`, `cmp_id`,`from_id`, `from_name`, `txn_type`) 
            VALUES ('1','1','$workid','$workname','$opb_qty','$unitname','$unitid','1','$fromname','$fromid','PIRN')";
            
    if ($con->query($sql) === TRUE) {
      $reff_id = mysqli_insert_id($con);
      $txn_type = "PIRN_ISS";
      $query = "INSERT INTO `bobin_trans`(`issue_date`,`reff_id`, `bobin_id`,`bobin_no`,`box_no`, `box_id`,`box_col_id`, `box_col_nam`,`txn_type`) VALUES (?,?,?,?,?,?,?,?,?)";

      $stmt = mysqli_prepare($con, $query);

      for ($key = 0; $key < count($bobins); $key++) {
        if ($bobins[$key] !== "") {
          mysqli_stmt_bind_param($stmt, "sisssssss", $currentDateTime, $reff_id, $bobins_id[$key], $bobins[$key], $box_nam[$key], $hidden_box_id[$key], $hidden_colorid[$key], $box_colornames[$key], $txn_type);
          mysqli_stmt_execute($stmt);
        }
      }

      for ($innerKey = 0; $innerKey < count($box_nam); $innerKey++) {
        if ($box_nam[$innerKey] !== "") {
          mysqli_stmt_bind_param($stmt, "sisssssss", $currentDateTime, $reff_id, $bobins_id[$innerKey], $bobins[$innerKey], $box_nam[$innerKey], $hidden_box_id[$innerKey], $hidden_colorid[$innerKey], $box_colornames[$innerKey], $txn_type);
          mysqli_stmt_execute($stmt);
        }
      }

      mysqli_stmt_close($stmt);
      echo "Details Saved successfully";
      // printf($sql);
      // printf($query);
      header('Location: rawissueto_pirn.php');
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $con->error;
      $con->close();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" href="css/issue_pirn.css">
  <link rel="stylesheet" href="css/modal.css">
  <title>AcPro Software</title>
</head>

<body>

  <div class="container">
    <h2>Transfer from Bobin to Pirn</h2><br>
    <form action="" method="post" autocomplete="off">
      <div class="form-group">
        <label for="name">Name:</label>
        <select name="workname" id="workname" class="selectpicker" value="" data-show-subtext="true" data-live-search="true" required>
          <option value="" selected disabled>Select Worker</option>
          <?php
          $sql = mysqli_query($con, "SELECT ac_nam,id FROM acct where ac_grp_nam='WORKER' order by ac_nam");
          while ($row = $sql->fetch_assoc()) {
            $ac_nam = $row['ac_nam'];
            echo "<option value='" . $row['id'] . "'>" . $row['ac_nam'] . " </option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="unit">From:</label>
        <select name="fromloc" id="fromloc" class="selectpicker" data-show-subtext="true" data-live-search="true" required>
          <option value="" selected disabled>Select From Where</option>
          <?php
          $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores ORDER BY loc_nam");
          while ($row = $sql->fetch_assoc()) {
            echo "<option class='text-uppercase' value='" . $row['id'] . "' data-subtext='" . $row['loc_nam'] . "'>" . $row['loc_nam'] . "</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="unitname">To / Unit:</label>
        <select name="unitname" id="unitname" class="selectpicker" data-show-subtext="true" data-live-search="true" required>
          <option value="" selected disabled>Select Unit</option>
          <?php
          $sql = mysqli_query($con, "SELECT nam,auto_id,maj_nam FROM cnf where cls='WRK_UNIT' and val!='Loom' order by nam");
          while ($row = $sql->fetch_assoc()) {

            echo "<option value='" . $row['auto_id'] . "'>" . trim($row['nam']) . " ( " . trim($row['maj_nam']) . " )" . " </option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="itemopb_bobinqty">Bobin qty:</label>
        <input required type="number" id="itemopb_bobinqty" name="itemopb_bobinqty" required oninput=' limitToRange(this)'>
      </div>

      <!-- <div class="form-group">
        <label for="weight">Bobin Weight</label>
        <input type="number" id="weight" name="weight"required>
      </div> -->


      <div class="form-group"><br>
        <input type="submit" name="save" value="Save">
        <br><br>
        <a href="admin.php"> <button type="button">Home</button></a>
      </div>

      <!-- MODAL STARTS -->
      <div id="modal_bobin" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <p class="heading_modal">SELECT BOBIN TO ISSUE</p>

          <div id="inputContainer">
            <table id="modaltable">
              <thead>
                <tr>
                  <th>Bobin Id</th>
                  <!-- <th>Item Wght</th> -->
                </tr>
              </thead>
              <tbody id="tbody">
                <tr>
                  <td>
                    <input required type="text" class="form-control" list="bobin_options" name="bobins[]" class='text-uppercase' placeholder="Type to select category..." onchange="getbobin_id(this)">
                    <datalist id="bobin_options">
                      <?php
                      $sql = "SELECT bobin_id, id FROM bobin ORDER BY bobin_id";
                      $result = $con->query($sql);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<option class='text-uppercase' value='" . $row['bobin_id'] . "' data-acid='" . $row['id'] . "'></option>";
                        }
                      }
                      ?>
                    </datalist>


                  </td>
                  <td style="display:none;">
                    <input type="hidden" class="form-control" name="hidden_bobin_id[]">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="form-group">
           <h4>SELECT BOX TO ISSUE</h4>
            <input required type="number" placeholder="Enter no of pirn box and press tab" id="box_qty" name="box_qty">
          </div>
          <table id="box_table">
              <thead>
                <tr>
                  <th>Box No</th>
                  <th>Colour</th>
                </tr>
              </thead>
              <tbody id="tbody2">
                <tr>
                  <td>
                    <input required type="text" class="form-control" list="box_options" name="boxes[]" class='text-uppercase' placeholder="Type to select category..." onchange="getbox_id(this)">
                    <datalist id="box_options">
                      <?php
                      $sql = "SELECT box_no, id FROM pirn_box ORDER BY box_no";
                      $result = $con->query($sql);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<option class='text-uppercase' value='" . $row['box_no'] . "' data-acid='" . $row['id'] . "'></option>";
                        }
                      }
                      ?>
                    </datalist>


                  </td>
                  <td style="display:none;">
                    <input type="hidden" class="form-control" name="hidden_box_id[]">
                  </td>
                  <td id="colortd">
                    <input list="colornamess" name="colornames[]" id="colorname" class="form-control" placeholder="Select Colour" onchange="getitemcolor(this)">
                    <datalist id="colornamess">
                      <?php
                      $sql = mysqli_query($con, "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam");
                      while ($row = $sql->fetch_assoc()) {
                        echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                      }
                      ?>
                    </datalist>
                  </td>
                  <td style="display:none;">
                    <input type="text" class="form-control" name="hidden_colorid[]">
                  </td>
                </tr>
              </tbody>
            </table>
          <input type="submit" name="save" value="Save" class="btn btn-primary">
        </div>
      </div>
      <!-- MODAL ENDS -->
      <input type="hidden" id="selectedName" name="selectedName">
      <input type="hidden" id="selectedunit" name="selectedunit">
      <input type="hidden" id="selectedloc" name="selectedloc">
      <input type="hidden" id="selectedlocname" name="selectedlocname">
    </form>
  </div>
  <script src="js/issueto_pirn.js"></script>
  <script src="js/pirn_iss_modal.js"></script>

  <script>
    /*  */
    function limitToRange(input) {
      const value = parseInt(input.value, 10); // Parse the input value as an integer

      if (isNaN(value) || value < 1 || value > 30) {
        input.value = ""; // Clear the input value if it's not a number or not within the range [1, 12]
      }
    }
  </script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>

</html>