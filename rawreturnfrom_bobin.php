<?php
include "config.php";


 // Check if 'uname' session variable is not set or empty
 if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}


if (isset($_POST['save'])) {
   
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time

$currentDateTime = date('Y-m-d H:i:s'); // Format: Year-Month-Day Hours:Minutes:Seconds

//echo "Current date and time in Indian Standard Time: " . $currentDateTime;

  $id = $_POST['workname'];
  //$clb = $_POST['returnweight'];
  //$finish_qty = $_POST['bobin_qty'];
  $finish_wght = $_POST['ttlweight'];

  $bobins = $_POST['bobins'];
  $wghts = $_POST['wghts'];
  $finish_qty =$_POST['bobin_qty'];
  date_default_timezone_set("Asia/Kolkata"); // Set the timezone to Asia/Kolkata
  $finish_date = date("Y-m-d H:i:s"); // Generate the current date and time in the specified format

  $items = $_POST["items"];
  $colors = $_POST['colors'];
  $ret_weight = $_POST['bln_wght_hnd'];
  $from_name = $_POST['unit'];
  $dept_id = $_POST['hidden_fromlocto'];
  $dept = $_POST['fromlocto'];

  $sql = "UPDATE `work_progress` SET  `work_prog`=0,`from_name_ret`='$from_name',`dept_id`='$dept_id',`dept_ret`='$dept', `work_end`=1,`finish_date`='$finish_date', `finish_qty`='$finish_qty', `finish_wght`='$finish_wght' WHERE id='$id'";

  if ($con->query($sql) === TRUE) {
    // Success: You can perform any additional actions if needed
    for ($key = 0; $key < count($bobins); $key++) {
      if ($bobins[$key] !== "" && $wghts[$key] > 0) { // Corrected variable name 'amts' to 'wghts'
        $bobin = $bobins[$key];
        $wght = $wghts[$key];
        $item = $items[$key];
        $color = $colors[$key];
        
        $txn_type = "RET";
        $sql = "UPDATE `bobin_trans` SET `return_date` = '$currentDateTime', `ret_wghts_withbobin` = '$wght',`itm_nam` = '$item',`col_nam` = '$color',`txn_type` = '$txn_type',`ttl_wght_withbobin`='$finish_wght',`ret_ttl_wght` = '$ret_weight' WHERE `bobin_id` = '$bobin' and `reff_id` = '$id'"; // Add WHERE condition to specify which row to update
        $con->query($sql); // Execute the SQL query for each bobin
      }
    }

  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();
  header('Location: rawreturnfrom_bobin.php');
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
          <input style="outline:2px solid yellow;" type="number" id="bln_wght_hnd" value="0" name="bln_wght_hnd" onclick="this.select()"  required >
        </div>
      </div>

      <div class="input-div">
        <label for="bobin_qty">No of Bobins issued:</label>
        <input class="bgwhite" type="number" id="bobin_qty" name="bobin_qty" readonly>
      </div>
     <div class="column">
        <label for="ttlweight">Total Bobin Weight:</label>
        <input type="number" id="ttlweight" name="ttlweight" readonly >
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
                  <td><input  class="form-control" type="text" name="bobins[]" value=""readonly></td>
                  <td><input  class="form-control" type="text" name="items[]" value=""readonly id="itemsInput"></td>
                  <td><input  class="form-control" type="text" name="colors[]" value=""readonly id="colorsInput"></td>
                  <td><input  class="form-control" type="number" name="wghts[]"onclick="this.select()" required oninput="calculateTotalSum()"></td>
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
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 

</body>

</html>