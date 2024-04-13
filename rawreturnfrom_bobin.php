<?php
include "config.php";

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['save'])) {
  // Retrieve POST data
  $page_date = $_POST['page_date'];
  $id = $_POST['workname'];
  $finish_wght = $_POST['ttlweight'];
  $hidden_trans_id = $_POST['hidden_trans_id'];
  $bobins = $_POST['bobins'];
  $wghts = $_POST['wghts'];
  $finish_qty = $_POST['bobin_qty'];
  $items = $_POST["items"];
  $colors = $_POST['colors'];
  $ret_weight = $_POST['bln_wght_hnd'];
  $from_name = $_POST['unit'];
  $dept_id = $_POST['hidden_fromlocto'];
  $dept = $_POST['fromlocto'];

  // Update work_progress table
  $sql = "UPDATE `work_progress` SET `work_prog`=0, `from_name_ret`='$from_name', `dept_id`='$dept_id', `dept_ret`='$dept', `work_end`=1, `finish_date`='$page_date', `finish_qty`='$finish_qty', `finish_wght`='$finish_wght' WHERE id='$id'";
  if ($con->query($sql) === TRUE) {
    // Loop through hidden_trans_id array
    foreach ($hidden_trans_id as $key => $ids) {
      // Check if bobin and weight are not empty and weight is greater than 0
      if (!empty($bobins[$key]) && isset($wghts[$key]) && $wghts[$key] > 0) {
        // Retrieve item, color, and txn_type
        $bobin = $bobins[$key];
        $item = $items[$key];
        $color = $colors[$key];
        $ret_wght = $wghts[$key];
        $txn_type = "RET";

        // Construct the update query
        $update_sql = "UPDATE `bobin_trans` SET `bobin_ret_date`='$page_date', `itm_nam`='$item', `col_nam`='$color', `txn_type`='$txn_type',`ret_wghts_withbobin`='$ret_weight' WHERE `id`='$ids'";

        // Execute the update query
        if ($con->query($update_sql) !== TRUE) {
          echo "Error updating record: " . $con->error;
        }
      }
    }
  } else {
    echo "Error updating work_progress table: " . $con->error;
  }
  header('Location: rawreturnfrom_bobin.php');

  // Close the database connection
  $con->close();
  exit(); // Add an exit() after the header redirection.
}

if (isset($_POST['log-out'])) {
  session_destroy();
  header('Location: index.php');
  exit(); // Add an exit() after the header redirection.
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/return.css">
  <link rel="stylesheet" href="css/modal.css">

  <title>AcPro Software</title>

</head>

<body>
<?php
    include_once "main/nav.php";
    ?>
  
  <div class="form_container">
    <h2>Return From Bobin</h2>

    <form action="" method="post" autocomplete="off">

      <div class="input-div">
        <label for="workname">Name:</label>
        <select name="workname" id="workname" onchange="funfetch()" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select Worker</option>
          <?php
          $sql = mysqli_query($con, "SELECT * FROM work_progress where work_prog=1 and work_end=0 and txn_type='BOBIN' order by work_nam");
          while ($row = $sql->fetch_assoc()) {
            // $id = $row['id'];
            echo "<option value='" . $row['id'] . "'>" . $row['work_nam'] . " </option>";
          }
          ?>
        </select>
      </div>

      <div class="input-div">
        <label for="unit">From Unit:</label>
        <input type="text" id="unit" name="unit" readonly>
      </div>
      <div class="input-div">
        <label for="fromlocto">To:</label>
        <input list="fromloctos" name="fromlocto" id="fromlocto" class="form-control" placeholder="Select Where" required>
        <datalist id="fromloctos">
          <?php
          $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
          while ($row = $sql->fetch_assoc()) {
            echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
          }
          ?>
        </datalist>
      </div>
      <!-- <div class="input-div">
        <label for="itemname">Item Name :</label>
        <input type="text" id="itemname" name="itemname" onchange="toggleColorDropdown()">
      </div>
      <div class="input-div" id="colorDropdown">
        <label for="colorname">Colour:</label>
        <input type="text" name="colorname" id="colorname" readonly>
      </div> -->
      <div class="row1">
        <div class="column">
          <label for="itemopb">Item opening:</label>
          <input type="number" id="itemopb" name="itemopb" readonly>
        </div>
        <div class="column">
          <label for="used_inbobin">Itm Used in bobin:</label>
          <input class="bgwhite" type="number" id="used_inbobin" name="used_inbobin" required readonly>
        </div>
        <div class="column">
          <label for="bln_wght_hnd">Blnc wght inhand</label>
          <input style="outline:2px solid yellow;" type="number" id="bln_wght_hnd" value="0" name="bln_wght_hnd" onclick="this.select()" required>
        </div>
      </div>
      <input type="hidden" name="page_date" id="page_date">
      <input type="hidden" name="page_time" id="page_time">
      <div class="input-div">
        <label for="bobin_qty">No of Bobins issued:</label>
        <input class="bgwhite" type="number" id="bobin_qty" name="bobin_qty" readonly>
      </div>
      <div class="column">
        <label for="ttlweight">Total Bobin Weight:</label>
        <input type="number" id="ttlweight" name="ttlweight" readonly>
      </div>
      <div class="buttons">
        <button type="submit" name="save" value="Save">Save</button>
        <button type="button" name="new" value="new" onclick="location.reload()">New</button>
        <a href="admin.php"> <button type="button">Home</button>
        </a>
      </div>

      <input type="hidden" id="selectedid" name="selectedid">
      <input type="hidden" id="hidden_fromlocto" name="hidden_fromlocto">

      <!-- MODAL STARTS -->
      <div id="modal_bobin" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <p class="heading_modal">ENTER BOBIN WGHT</p>

          <div id="inputContainer">
            <table id="modaltable">
              <thead>
                <tr>
                  <th>Bobin Id</th>
                  <th>Bobin items</th>
                  <th>Bobin colours</th>
                  <th>Bobin Wght</th>
                </tr>
              </thead>
              <tbody id="tbody">
                <tr>
                  <td><input class="form-control" type="text" name="bobins[]">
                    <input class="form-control" type="text" name="hidden_trans_id[]">
                  </td>
                  <td><input class="form-control" type="text" name="items[]"></td>
                  <td><input class="form-control" type="text" name="colors[]"></td>
                  <td><input class="form-control" type="number" name="wghts[]" onclick="this.select()" required oninput="calculateTotalSum()"></td>
                </tr>
              </tbody>
            </table>
          </div>

          <input type="submit" name="save" value="Save">

        </div>
      </div>
      <!-- MODAL ENDS -->
    </form>

  </div>

  <script src="js/return.js"></script>
  <script src="js/date_time.js"></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


</body>

</html>