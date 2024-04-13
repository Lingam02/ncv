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
  // echo "data submited";

  date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time

  $currentDateTime = date('Y-m-d H:i:s'); // Format: Year-Month-Day Hours:Minutes:Seconds

  //echo "Current date and time in Indian Standard Time: " . $currentDateTime;

  $page_date = $_POST['page_date'];
  $page_time = $_POST['page_time'];

  $workname = $_POST['workname'];
  $workid = $_POST['hidden_workername'];

  $fromname = $_POST['fromloc'];
  $fromid = $_POST['hidden_fromloc'];

  $unitname = $_POST['unitname'];
  $unitid = $_POST['hidden_unitname'];

  $no_bobins = $_POST['no_bobins'];
  $ttl_wght = $_POST['ttlweight'];

  $txnname = $_POST["txnname"];

  // MODAL INPUTS VARIABLES

  $bobins = $_POST['bobins'];
  $bobins_id = $_POST['hidden_bobin_id'];
  $itemnames = $_POST['itemnames'];
  $itemids = $_POST['hidden_itemid'];
  $colornames = $_POST['colornames'];
  $colorids = $_POST['hidden_colorid'];
  $wghts = $_POST['wghts'];


  // MODAL INPUTS VARIABLES ENDS

  if ($ttl_wght > 0 and $workname != "" and $unitname != "") {
    $sql = "INSERT INTO `work_progress`(`work_sess`, `work_prog`,`no_bobins`, `work_id`, `work_nam`, 
      `opb_wght`,`dept_id`, `dept`, `cmp_id`,`from_id`, `from_name`, `txn_type`) 
      VALUES ('1','1','$no_bobins','$workid','$workname','$ttl_wght','$unitid','$unitname',
     '1','$fromid','$fromname','BOBIN')";

    if ($con->query($sql) === TRUE) {
      //    echo "Details Saved successfully";
      $reff_id = mysqli_insert_id($con);
      $txn_type = "ISS";
      $txn_type_typ = "BOBIN_ISS";
      $query = "INSERT INTO `bobin_trans`(`issue_date`,`reff_id`, `bobin_id`,`bobin_no`, `txn_type`,`itm_id`,`itm_nam`, `col_id`,`col_nam`, `iss_wghts`,`ttl_wght`) 
      VALUES (?,?,?,?,?,?,?,?,?,?,?)";


      for ($key = 0; $key < count($bobins); $key++) {

        if ($bobins[$key] !== "") {

          if ($txnname === 'Zari') {
            $itemcolor = "";
            $colorid = "";
            echo "zari";
            $itemname = $itemnames[$key];
            $itemid = $itemids[$key];
          } else {

            $itemcolor = $colornames[$key];
            $colorid = $colorids[$key];
            echo "weft";
            $itemname = "";
            $itemid = "";
          }
          $stmt = mysqli_prepare($con, $query);
          mysqli_stmt_bind_param(
            $stmt,
            "sisssssssdd",
            $currentDateTime,
            $reff_id,
            $bobins_id[$key],
            $bobins[$key],
            $txn_type,
            $itemid,
            $itemname,
            $colorid,
            $itemcolor,
            $wghts[$key],
            $ttl_wght
          );
          mysqli_stmt_execute($stmt);
          $reff_id2 = mysqli_insert_id($con);
        }


        //=========================================================================================
        //==================================== stock report==============================================================================

        $query2 = "INSERT INTO `stock_report`(`save_date`,`save_time`, `txn_id`,`bobin_id`,`hd_id`,`txn_type`,
      `loc_id`,`reff_id`,`itm_id`, `col_id`,/*`box_id`,*/`remarks`,`qty`,`qty1`,`wght`,`inw_otw`) 
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $remarks = "BOBIN-ISSUE";

        $txnisstype = -1;
        $wght_minus = $txnisstype * ($wghts[$key]);

        if ($bobins[$key] !== "") {

          if ($txnname === 'Zari') {
            $colorid = "";
            echo "zari";
            $itemid = $itemids[$key];
          } else {

            $colorid = $colorids[$key];
            echo "weft";
            $itemid = "";
          }
          $bobvalue='';
          $stmt = mysqli_prepare($con, $query2);
          mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssdddi",
            $page_date,
            $page_time,
            $reff_id2,
            $bobvalue,
            $reff_id,
            $txn_type_typ,
            $fromid,
            $reff_id,
            $itemid,
            $colorid,
            $remarks,
            $wghts[$key],
            $wght_minus,
            $wghts[$key],
            $txnisstype
          );
          mysqli_stmt_execute($stmt);

          $txnisstype = 1;
          $wght_minus = $txnisstype * ($wghts[$key]);

          $stmt = mysqli_prepare($con, $query2);
          mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssdddi",
            $page_date,
            $page_time,
            $reff_id2,
            $bobins_id[$key],
            $reff_id,
            $txn_type_typ,
            $unitid,
            $reff_id,
            $itemid,
            $colorid,
            $remarks,
            $wghts[$key],
            $wght_minus,
            $wghts[$key],
            $txnisstype
          );
          mysqli_stmt_execute($stmt);
        }
      }

      //==================================================================================================================
      header('Location:rawissueto_bobin.php'); // Redirect before closing the connection
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $con->$error;

      $con->close();
    }
  }
}
// if ($ttl_wght > 0) {
//   $last_id = mysqli_insert_id($con) ;
//   $qty2 = (-1)*$ttl_wght;
//   $sql_stock = "INSERT INTO `stock`(`trans_id`, `trans_dat`,`loc_id`, `loc_nam`, `reff_id`, 
//   `reff_dat`,`txn_typ`, `it_id`, `col_id`,`col_nam`, `ac_id`, `qty`,`iss`,`qty2`,cmp_id) 
//   VALUES ('$last_id','$currentDateTime','$fromid','$fromname','no','$currentDateTime','BNI','$itemid',
//  '$colorid','$itemcolor','$workid','$ttl_wght','0','$qty2','1')";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- 
  <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->

  <link rel="stylesheet" href="css/issue.css">
  <link rel="stylesheet" href="css/modal.css">
  <title>AcPro Software</title>
</head>

<body>
  <?php
  // include_once "main/nav.php";
  ?>
  <!-- <a href="admin.php"><button class="home btn btn-success">HOME</button></a> -->

  <div class="containers">
    <h2 id="dynamicheading">Transfer to Bobin</h2><br>
    <form action="" method="post" autocomplete="off">

      <div class="form-group">
        <label for="workname">Name:</label>
        <input list="workers" name="workname" id="workname" class="form-control" placeholder="Select Worker" required>
        <datalist id="workers">
          <?php
          $sql = mysqli_query($con, "SELECT ac_nam,id FROM acct where ac_grp_nam='WORKER' OR ac_grp_nam='WEAVER' order by ac_nam");
          while ($row = $sql->fetch_assoc()) {
            $ac_nam = $row['ac_nam'];
            echo "<option value='" . $row['ac_nam'] . "' data-acid='" . $row['id'] . "'>";
          }
          ?>
        </datalist>
      </div>

      <div class="form-group">
        <label for="fromloc">From:</label>
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

      <div class="form-group">
        <label for="unitname">To / Unit:</label>
        <input list="unitnames" name="unitname" id="unitname" class="form-control" placeholder="Select Unit" required>
        <datalist id="unitnames">
          <?php
          $sql = mysqli_query($con, "SELECT nam,auto_id,maj_nam FROM cnf where cls='WRK_UNIT' and val!='Loom'order by nam");
          while ($row = $sql->fetch_assoc()) {
            echo "<option value='" . trim($row['nam']) . " ( " . trim($row['maj_nam']) . " )' data-id='" . $row['auto_id'] . "'> </option>";
          }
          ?>
        </datalist>
        <input type="hidden" name="page_date" id="page_date">
        <input type="hidden" name="page_time" id="page_time">
      </div>

      <div class="radio-div">
        <input type="radio" name="Itmgroup" id="Zari" value="Zari" onchange="checkselected()">
        <label for="Zari">Zari</label>
        <input type="radio" name="Itmgroup" id="Weft" value="Weft" onchange="checkselected()">
        <label for="Weft">Weft</label>
      </div>

      <div class="form-group">
        <label for="no_bobins">No of Bobin giving</label>
        <input type="number" id="no_bobins" name="no_bobins" class="form-control" placeholder="Enter a number" required oninput="limitToTwoDigits(this)">
      </div>
      <div class="form-group">
        <label for="ttlweight">Weight:</label>
        <input type="number" id="ttlweight" name="ttlweight" class="form-control" readonly>
      </div>

      <div class="form-group">
        <div class="row">
          <div class="col">
            <input type="submit" name="save" value="Save" class="btn btn-primary btn-block">
          </div>
          <div class="col">
            <button type="button" name="new" value="new" onclick="location.reload()">New</button>
          </div>
          <div class="col">
            <a href="admin.php">
              <input value="Home" readonly class="btn btn-success btn-block">
            </a>
          </div>
        </div>
      </div>

      <!-- MODAL STARTS -->
      <div id="modal_bobin" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <p class="heading_modal">SELECT</p>

          <div id="inputContainer">
            <table id="modaltable">
              <thead>
                <tr>
                  <th>Bobin Id</th>
                  <th id="itemth" style="display:none;">Item</th>
                  <th id="colorth" style="display:none;">Colour</th>
                  <th>Item Wght</th>
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
                  <td id="itemtd" style="display:none;">
                    <input list="itemnamess" name="itemnames[]" class="form-control" placeholder="Select Raw Material" onblur="getitemname(this)">
                    <datalist id="itemnamess">
                      <?php
                      $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK' or itm_grp_id='ZARI' order by itm_nam");
                      while ($row = $sql->fetch_assoc()) {
                        echo "<option class='text-uppercase' value='" . $row['itm_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                      }
                      ?>
                    </datalist>
                  </td>
                  <td style="display:none;">
                    <input type="text" class="form-control" name="hidden_itemid[]">
                  </td>

                  <td id="colortd" style="display:none;">
                    <input list="colornamess" name="colornames[]" id="colorname" class="form-control" placeholder="Select Colour" onblur="getitemcolor(this)">
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
                  <td>
                    <input type="number" class="form-control" value="0" name="wghts[]" onclick="this.select()" oninput="calculateTotalSum()" class="form-control">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <input type="submit" name="save" value="Save" class="btn btn-primary">
        </div>
      </div>
      <!-- MODAL ENDS -->

      <input type="hidden" id="txnname" name="txnname">
      <input type="hidden" id="hidden_workername" name="hidden_workername">
      <input type="hidden" id="hidden_fromloc" name="hidden_fromloc">
      <input type="hidden" id="hidden_unitname" name="hidden_unitname">

    </form>

  </div>
  <!-- Divs container -->


  <script src="js/issue.js"></script>
  <script src="js/date_time.js"></script>

  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</body>

</html>