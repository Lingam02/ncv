<?php
include "config.php";

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

if (isset($_POST['submit'])) {
  print_r($_POST);
  // Retrieve data from POST
  $wevname = $_POST['selectedName'];
  $loomnam = $_POST['selectedunit'];
  $silk_nam = $_POST['silk_nam'];
  $zari_nam = $_POST['zari_nam'];
  $hidden_box_id = $_POST['hidden_box_id'];
  $box = $_POST['box'];
  $wevid = $_POST['wevname'];
  $loomid = $_POST['loomnam'];
  $silk_id = $_POST['silk_nam'];
  $jari_id = $_POST['zari_nam'];
  $jari_qty = $_POST['jari_qty'];
  $jari_wght = $_POST['jari_wght'];
  $silk_qty = $_POST['silk_qty'];
  $silk_wght = $_POST['silk_wght'];
  $particulars = $_POST['particulars'];
  $fromid = $_POST['fromloc'];
  $fromname = $_POST['selectedloc'];
  $tnx_type = 'wev_iss';

  // Insert into 'wev_usage' table
  $sql = "INSERT INTO `wev_usage`(`txn_date`, `txn_typ`, `wev_id`, `wev_nam`, `work_id`, `work_nam`, `jari_qty`, 
        `jari_wght`, `jari_id`,`zari_nam`, `silk_id`, `silk_nam`, `silk_qty`, `silk_wght`, 
        `work_progress`, `cmp_id`,`particulars`,`from_id`, `from_name`,`box_id`,`box_no`) 
        VALUES (CURRENT_DATE(),'ISS','$loomid','$loomnam','$wevid', '$wevname', '$jari_qty','$jari_wght',
        '$jari_id','$zari_nam','$silk_id','$silk_nam','$silk_qty','$silk_wght','1','1','$particulars',
        '$fromid','$fromname','$hidden_box_id','$box')";

  $result = $con->query($sql);

  if ($result === TRUE) {
    // Get the last inserted ID
    echo "wev_usage inserted <br>";
    $last_id = $con->insert_id;

    // Retrieve posted data
    $boxIds = $_POST['box_nos'];
    $items = $_POST['items'];
    $colors = $_POST['colors'];
    $weights = $_POST['wghts'];
    $hide_id = $_POST['hide_id'];
    $enablepost = $_POST['enablepost']; // Array of checkboxes
    $reff_id = $_POST['hidden_txn_id'];
    // $tru = 1;

    // Insert data into 'wever_details' table
    $stmt = $con->prepare("INSERT INTO weaver_detail (hd_id, tnx_type, reff_id, box_no, box_item, box_color, box_weight) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("isssssd", $last_id, $tnx_type, $reff_id, $boxId, $boxItem, $boxColor, $boxWeight);

    // Loop through the checked rows and insert data into 'wever_details' table
for ($i = 0; $i < count($boxIds); $i++) {
  if (!empty($enablepost[$i])) { // Check if checkbox is checked
    $boxId = $boxIds[$i];
    $boxItem = $items[$i];
    $boxColor = $colors[$i];
    $boxWeight = $weights[$i];
    $stmt->execute();

    $sqlUpdate = "UPDATE `bobin_trans`
    SET `is_transfered` = 1
    WHERE `id` = " . $hide_id[$i];

    // Execute the update query
    $con->query($sqlUpdate);
  }
}

    // Close prepared statement
    $stmt->close();
    header("Location: weaverissue.php");
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
  $con->close();
}

// Check if 'Log-out' button is clicked
if (isset($_POST['Log-out'])) {
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
  <link rel="stylesheet" href="css/weave.css">
  <title>AcPro- Nc Varathan Silks</title>
</head>

<body>
<?php
    include_once "main/nav.php";
    ?>
  <div class="container-main">
    <h2>Weaver Transfer</h2>

    <form id="wev_form" action="" method="post" autocomplete="off">

      <div class="form-group">

        <label for="wevname">Name:</label>
        <select required name="wevname" id="wevname" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select Worker</option>
          <?php
          $sql = mysqli_query($con, "SELECT * FROM acct where ac_grp_nam='WORKER' OR ac_grp_nam='WEAVER' order by ac_nam");
          while ($row = $sql->fetch_assoc()) {
            $ac_nam = $row['ac_nam'];
            echo "<option value='" . $row['id'] . "'>" . $row['ac_nam'] . " </option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="fromloc">From:</label>
        <select required name="fromloc" id="fromloc" class="selectpicker" data-show-subtext="true" data-live-search="true">
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
        <label for="loomnam">To / Loom:</label>

        <select required name="loomnam" id="loomnam" class="selectpicker" value="" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select loom</option>
          <?php
          $sql = mysqli_query($con, "SELECT nam,auto_id,maj_nam FROM cnf where cls='WRK_UNIT' and val='Loom' order by nam");
          while ($row = $sql->fetch_assoc()) {

            echo "<option value='" . $row['auto_id'] . "'>" . trim($row['nam']) . " ( " . trim($row['maj_nam']) . " )" . " </option>";
          }
          ?>
        </select>
      </div><br>

      <div class="form-row">

        <div class="form-group">
          <label for="silk_nam">Silk:</label>
          <select name="silk_nam" id="silk_nam" class="selectpicker" data-show-subtext="true" data-live-search="true">
            <option value="" selected disabled>Select Silk</option>
            <?php
            $sql = mysqli_query($con, "SELECT itm_nam FROM itm where itm_grp_id='SILK'  order by itm_nam");
            while ($row = $sql->fetch_assoc()) {
              //            echo "<option value=\"owner1\">" . $row['acgrp_name'] ."</option>";
              echo "<option value='" . $row['id'] . "'>" . $row['itm_nam'] . " </option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="silk_nam">Colour:</label>
          <!-- <input type="text" list="box_nos" name="box" id="box" class="form-control" placeholder="Select Colour">
          <datalist id="box_nos">
            <?php
            // $sql = mysqli_query($con, "SELECT DISTINCT * FROM bobin_trans WHERE txn_type = 'PIRN_RET' AND is_transfered = 0");
            // while ($row = $sql->fetch_assoc()) {
            //   echo "<option class='text-uppercase' value='" . $row['box_col_nam'] . "' data-acid='" . $row['id'] . "' data-id='" . $row['reff_id'] . "'></option>";
            // }
            ?>
          </datalist> -->
          <input type="text" list="box_nos" name="box" id="box" class="form-control" placeholder="Select Colour" value="<?php $id = ''; echo htmlspecialchars($id); ?>">
<datalist id="box_nos">
  <?php
  $sql = mysqli_query($con, "SELECT DISTINCT box_col_nam, id, reff_id FROM bobin_trans WHERE txn_type = 'PIRN_RET' AND is_transfered = 0");
  while ($row = $sql->fetch_assoc()) {
    echo "<option class='text-uppercase' value='" . htmlspecialchars($row['box_col_nam']) . "' data-acid='" . htmlspecialchars($row['id']) . "' data-id='" . htmlspecialchars($row['reff_id']) . "'></option>";
  }
  ?>
</datalist>



          <input type="hidden" id="hidden_box_id" name="hidden_box_id">
          <input type="hidden" id="hidden_txn_id" name="hidden_txn_id">
        </div>


        <!-- <div class="form-group">
          <label for="col_nam">Colour:</label>
          <select name="col_nam" id="col_nam" class="selectpicker" data-show-subtext="true" data-live-search="true">
            <option value="" selected disabled>Select Colour</option>
            <?php
            // $sql = mysqli_query($con, "SELECT nam,id FROM cnf where cls='COLOR' order by nam");
            // while ($row = $sql->fetch_assoc()) {
            //   echo "<option value='" . $row['id'] . "'>" . $row['nam'] . " </option>";
            // }
            // 
            ?>
          </select>
        </div> -->



      </div>

      <div class="form-row">

        <div class="form-group" style="display:none">
          <label for="silk_wght">Weight:</label>
          <input type="Number" id="silk_wght" name="silk_wght">
        </div>

        <div class="form-group" style="display:none">
          <label for="silk_qty">Qty:</label>
          <input type="Number" id="silk_qty" name="silk_qty" value="0" onclick="this.select()">
        </div>
        <br>
      </div>

      <div class="form-group">
        <label for="particulars">Description:</label>
        <input type="text" id="particulars" name="particulars">
      </div>
      <br>
      <div class="line-container"></div>
      <br>
      <div class="form-row">

        <div class="form-group">
          <label for="zari_nam">Zari:</label>
          <select name="zari_nam" id="zari_nam" class="selectpicker" data-show-subtext="true" data-live-search="true">
            <option value="" selected disabled>Select Zari</option>
            <?php
            $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='ZARI'  order by itm_nam");
            while ($row = $sql->fetch_assoc()) {
              //            echo "<option value=\"owner1\">" . $row['acgrp_name'] ."</option>";
              echo "<option value='" . $row['id'] . "'>" . $row['itm_nam'] . " </option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="jari_wght">Weight:</label>
          <input type="Number" id="jari_wght" name="jari_wght" value="0" onclick="this.select()">
        </div>

        <div class="form-group">
          <label for="jari_qty">Qty:</label>
          <input type="Number" id="jari_qty" name="jari_qty" value="0" onclick="this.select()">
        </div>
      </div>
      <br>
      <!-- MODAL STARTS -->
      <div id="modal_bobin" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p class="heading_modal"></p>

        <div id="inputContainer">
          <table id="modaltable">
            <thead>
              <tr>
                <th>Box No</th>
                <!-- <th>Box items</th> -->
                <th>Box colours</th>
                <!-- <th>Box Wght</th> -->
              </tr>
            </thead>
            <tbody id="tbody">
              <!-- <tr>
                  <td><input style="width: 70px;" class="form-control" type="text" name="box_nos[]" value="" readonly></td>
                  <td><input class="form-control" type="text" name="items[]" value="" readonly id="itemsInput"></td>
                  <td><input class="form-control" type="text" name="colors[]" value="" readonly id="colorsInput"></td>
                  <td><input style="width: 70px;" class="form-control" type="number" name="wghts[]" onclick="this.select()" required></td>
                  <td><input class="form-control" type="checkbox" name="enablepost[]">
                    <input class="form-control" type="hidden" name="hide_id[]">
                  </td>
                </tr> -->
             

            </tbody>
          </table>
        </div>
        <!-- <button onclick="postData()">Post Data</button> -->

      </div>
      </div>
      <!-- MODAL ENDS -->
      <div class="form-group buttons">

        <button type="submit" name="submit" id="submit">Save</button>
        <a href="admin.php"> <button type="button">Home</button></a>

      </div>

      <input type="hidden" id="selectedName" name="selectedName">
      <input type="hidden" id="selectedunit" name="selectedunit">
      <input type="hidden" id="selecteditem" name="selecteditem">
      <input type="hidden" id="selectedcolor" name="selectedcolor">
      <input type="hidden" id="selectedzari" name="selectedzari">
      <input type="hidden" id="selectedloc" name="selectedloc">

  </div>
  </form>

  <script src="js/weave.js"></script>
  <!-- <script src="js/date_time.js"></script> -->
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>