<?php
include "config.php";
 // Check if 'uname' session variable is not set or empty
 if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

if (isset($_POST['save'])) {
  

  $id = $_POST['workname'];
  //-------------------------------------------

  //$fromid = $_POST['hidden_id_unitid'];
  //$fromname = $_POST['unit'];

  //$to_id = $_POST['hidden_id_fromloc'];
  //$to_name = $_POST['fromloc'];
  //--------------------------------------------
  $finish_qty = $_POST['no_ofpirns'];
  $finish_wght = $_POST['wght_of_pirns'];

  $bobins = $_POST['bobins'];
  $wghts = $_POST['wghts'];
  $ttl_wght_bobin = $_POST['ttl_retbobin_wght_inpirn'];

  date_default_timezone_set("Asia/Kolkata"); // Set the timezone to Asia/Kolkata
  $finish_date = date("Y-m-d H:i:s"); // Generate the current date and time in the specified format

  $sql = "UPDATE `work_progress` SET  `work_prog`=0, `work_end`=1,
   `finish_date`='$finish_date',
   `finish_wght`='$finish_wght' WHERE id='$id'";

  if ($con->query($sql) === TRUE) {
    // Success: You can perform any additional actions if needed
    for ($key = 0; $key < count($bobins); $key++) {
      if ($bobins[$key] !== "" && $wghts[$key] > 0) { // Corrected variable name 'amts' to 'wghts'
        $bobin = $bobins[$key];
        $wght = $wghts[$key];
        $txn_type = "PIRN_RET";
        $sql = "UPDATE `bobin_trans` SET `return_date` = '$finish_date', `ret_bobinwghts_inpirn` = '$wght',`no_of_pirnsfinished`='$finish_qty',`txn_type` = '$txn_type',`ttl_wghtof_pirns`='$finish_wght',`ttl_retbobin_wght_inpirn` = '$ttl_wght_bobin'
         WHERE `bobin_id` = '$bobin' and `reff_id` = '$id'";
        $con->query($sql); // Execute the SQL query for each bobin
      }
    }
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }

  $con->close();
  header('Location: rawreturnfrom_pirn.php');
}

if (isset($_POST['log-out'])) {
  session_destroy();
  header('Location: index.php');
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
  <link rel="stylesheet" href="css/return_pirn.css">
  <link rel="stylesheet" href="css/modal.css">

  <title>AcPro Software</title>
</head>

<body>
  <div class="form_container">
    <h2>Return From Pirn</h2>

    <form action="" method="post" autocomplete="off">
      <div class="input-div">
        <label for="workname">Name:</label>
        <select readonly name="workname" id="workname" onchange="funfetch()" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select Worker</option>
          <?php
          $sql = mysqli_query($con, "SELECT * FROM work_progress where work_prog=1 and work_end=0 and txn_type='PIRN' order by work_nam");
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
        <label for="fromloc">To:</label>
        <input list="fromlocs" name="fromloc" id="fromloc" class="form-control" placeholder="Select Where" required>
        <datalist id="fromlocs">
          <?php
           $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
           while ($row = $sql->fetch_assoc()) {
             echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
           }
          ?>
        </datalist>
      </div>

      <!------------------------------------------------------------------------------------------------------->

      <!-------------------------------------------------------------------------------------------------------->

      <div class="input-div">
        <label for="no_ofbobin_issued">No of Bobin Given</label>
        <input type="number" id="no_ofbobin_issued" name="no_ofbobin_issued" required readonly>
      </div>
      <div class="input-div">
        <label for="ttl_retbobin_wght_inpirn">Total Bobins Wght</label>
        <input type="number" id="ttl_retbobin_wght_inpirn" name="ttl_retbobin_wght_inpirn" required readonly>
      </div>
      <div class="input-div">
        <label for="no_ofpirns">No of Pirns finished</label>
        <input style="border:1px solid yellow" type="number" id="no_ofpirns" placeholder="ENTER NO OF PIRNS FINISHED" name="no_ofpirns" required oninput="updateInput2(this.value)">
      </div>
      <div class="input-div">
        <label for="wght_of_pirns">Weight of finished pirns</label>
        <input style="border:1px solid yellow" type="number" id="wght_of_pirns" placeholder="ENTER TOTAL PIRNS WEIGHT" name="wght_of_pirns" required>
      </div>
      <!-- <div class="input-div">
        <label for="result">No of box finished</label>
        <input type="number" id="result" name="result" required>
      </div> -->

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

                  <th>Bobin Wght</th>
                </tr>
              </thead>
              <tbody id="tbody">
                <tr>
                  <td><input type="text" name="bobins[]" value="" readonly></td>
                  <!-- <td><input type="text" name="items[]" value=""readonly id="itemsInput"></td>
                  <td><input type="text" name="colors[]" value=""readonly id="colorsInput"></td> -->
                  <td><input type="number" name="wghts[]" onclick="this.select()" required oninput="calculateTotalSum()"></td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <div id="inputContainer2">
          <P class="heading_modal">ENTER PIRN QTY AND WEIGHT</P>  
            <table id="modaltable2">
              <thead>
                <tr>
                  <th style="width:80px">Box NO</th>

                  <th style="width:40%">Colour</th>
                  <th style="width:80px">No of Pirns</th>
                  <th style="width:80px">Weight</th>
                </tr>
              </thead>
              <tbody id="tbody2">
                <tr>
                  <td><input style="width:80px" type="text" name="boxes[]" value="" readonly></td>
                  <!-- <td><input type="text" name="items[]" value=""readonly id="itemsInput"></td>-->
                  <td><input type="text" name="colors[]" value=""readonly id="colors"></td> 
                  <td><input style="width:80px" type="number" name="nos[]" onclick="this.select()" required oninput="calculateTotalSum()"></td>
                  <td><input style="width:80px" type="number" name="nos[]" onclick="this.select()" required oninput="calculateTotalSum()"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <input type="submit" name="save" value="Save">

        </div>
      </div>
      <!-- MODAL ENDS -->
      <!-- MODAL STARTS -->
      <!-- <div id="modal_bobin2" class="modal2">
        <div class="modal-content2">
          <span class="close2">&times;</span>
          <p class="heading_modal2">ENTER BOBIN WGHT</p>

          
          <input type="submit" name="save" value="Save">

        </div>
      </div> -->
      <!-- MODAL ENDS -->
      <div class="input-div buttons">
        <button type="submit" name="save" value="Save">Save</button>
        <button type="button" name="new" value="new" onclick="location.reload()">New</button>

        <a href="admin.php"> <button type="button">Home</button>
        </a>
      </div>
      <!-- <div id="pirn_calci">
        <div class="inline">
          <div class="griditem">
            <label for="no_pirnss">No of pirns</label>

            <input type="number" class="form-control" name="no_pirnss" id="no_pirnss" >
          </div>
         

          <div class="griditem">
            <label for="empty_pirn_wght">1 Pirn Wght</label>

            <input type="number" class="form-control" name="empty_pirn_wght" value="1.2" id="empty_pirn_wght">
          </div>
          <div class="griditem">
            <label for="box_wght">Empty Box Wght</label>

            <input type="number" class="form-control" name="box_wght" value="35" id="box_wght" >
          </div>
          <div class="griditem">
            <label for="t_wght">Total Wght</label>

            <input type="number" class="form-control" name="t_wght" id="t_wght">
          </div>
        </div>
        <div class="input-div">
          <label for="pure_wght">Pure wght</label>
          <input style="border:1px solid green" type="number" id="pure_wght" name="pure_wght">
        </div>
      </div> -->
      <input type="hidden" id="hidden_id_unitid" name="hidden_id_unitid">
      <!-- <input type="hidden" id="hidden_id_fromloc" name="hidden_id_fromloc"> -->
      <input type="hidden" id="selectedid" name="selectedid">

    </form>
  </div>
  <script src="js/returnfrom_pirn.js"></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>  -->
  <!-- <script>
  var pirnqtyinput = document.getElementById("no_ofpirn");
var boxinput = document.getElementById("result");

pirnqtyinput.addEventListener('input', function() {
  var inputValue = parseInt(pirnqtyinput.value);

  if (inputValue <= 100000) {
    // Calculate the box based on the value
    var boxValue = Math.ceil(inputValue / 20 );
    let bal = boxValue;
    boxinput.value = boxValue;
  } else {
    // Handle values greater than 1000 here, if needed
    // For example, set boxinput to a specific value or display an error message.
  }
}); -->

  </script>

</body>

</html>