<?php
include "config.php";
//session_start();

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {

  $locationid = $_POST['hidden_location_id'];
  $location = $_POST['location'];

  $bobinid = $_POST['hidden_bobins_id'];
  $bobin_name = $_POST['bobins'];
  $bobinid2 = $_POST['hidden_bobins_id2'];
  $bobin_name2 = $_POST['bobins2'];

  $wept_colours_id = $_POST['hidden_weft_id'];
  $wept_colours = $_POST['wept_colours'];
  $wghts = $_POST['wghts'];
  // $qtys = $_POST['qtys'];

  $zari_id = $_POST['hidden_zari_id'];
  $zari = $_POST['zarinames'];
  $wghts2 = $_POST['wghts2'];
  // $qtys2 = $_POST['qtys2'];

  if ($locationid != "") {
    $con = mysqli_connect($host, $user, $password, $dbname);

    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
    }

    $deleteQuery = "DELETE FROM `tbl_opening` WHERE `loc_id` = ?";
    $stmt = mysqli_prepare($con, $deleteQuery);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $locationid);
      mysqli_stmt_execute($stmt);
      // echo "Records with loc_id = $loc deleted successfully.";
    }

    $itm_type = "BS";
    $tbl_type1 = "WEFTBS";

    // First table INSERT
    $query1 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `reff_id`, `reff_nam`, `col_id`, `col_nam`, `wght`) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt1 = mysqli_prepare($con, $query1);

    if ($stmt1) {
      for ($key = 0; $key < count($wept_colours_id); $key++) {
        if ($wept_colours_id[$key] !== "") {
          mysqli_stmt_bind_param($stmt1, "ssssssssd", $locationid, $location, $itm_type, $tbl_type1, $bobinid[$key], $bobin_name[$key], $wept_colours_id[$key], $wept_colours[$key], $wghts[$key]);
          mysqli_stmt_execute($stmt1);
        }
      }
      echo "Details Saved successfully";
    } else {
      echo "Statement preparation failed: " . mysqli_error($con);
    }
    $tbl_type2 = "ZARIBS";
    // Second table INSERT
    $query2 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `reff_id`, `reff_nam`, `itm_id`, `itm_nam`, `wght`) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt2 = mysqli_prepare($con, $query2);

    if ($stmt2) {
      for ($key = 0; $key < count($zari_id); $key++) {
        if ($zari_id[$key] !== "") {
          mysqli_stmt_bind_param($stmt2, "ssssssssd", $locationid, $location, $itm_type, $tbl_type2, $bobinid2[$key], $bobin_name2[$key], $zari_id[$key], $zari[$key], $wghts2[$key]);
          mysqli_stmt_execute($stmt2);
        }
      }
      echo "Details Saved successfully";
      header('Location: opening2.php');
    } else {
      echo "Statement preparation failed: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);

    mysqli_close($con);
  } else {
    echo "Location ID not set.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Opening Balance Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/opening.css">
</head>

<body>

  <a href="admin.php"><button class="home btn btn-success">HOME</button></a>

  <!-- ------------------- 2 ------------------ -->
  <div class="container" id="bobinstore">
    <h4 class="text-center mt-2 text-danger">Opening Balance of Bobin Type </h4>
    <form action="" method="post" autocomplete="off">

      <div class="row">

        <div class="my-2 col-md-12">
          <label for="location" class="form-label me-2">Location</label>
          <input list="locations" id="location" name="location" class="form-control" required>
          <datalist id="locations">
            <?php
            $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores where loc_nam = 'BOBIN STORE' order by loc_nam");
            while ($row = $sql->fetch_assoc()) {
              echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
            }
            ?>
          </datalist>
        </div>
        <div class="my-2 col-md-6">
          <table id="wept_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="4">Bobin With Weft</td>
              </tr>
              <tr>
                <th>Bobin Id</th>
                <th>Weft Colour</th>
                <th>Weft Weight</th>
              </tr>
            </thead>
            <tbody id="tbody_bs_wept">
              <tr>
                <td>
                  <input type="text" class="form-control" list="bobin_options" name="bobins[]" class='text-uppercase' placeholder="SELECT BOBIN ID" onchange="bobinid(this)">
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
                <td>
                  <input type="text" list="colornamess" name="wept_colours[]" class="form-control" placeholder="Select Colour" onchange="getitemcolor(this)">
                  <datalist id="colornamess">
                    <?php
                    $sql = mysqli_query($con, "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                </td>
                <td style="display:none">
                  <input type="hidden" name="hidden_weft_id[]">
                </td>
                <td style="display:none">
                  <input type="hidden" name="hidden_bobins_id[]">
                </td>
                <td>
                  <input type="number" class="form-control" value="0" name="wghts[]" onclick="this.select()" oninput="calculateTotalSum()">
                </td>

              </tr>

            </tbody>
            <!-- <tfoot>
            <tr>
              <th colspan = "2">TOTAL</th>
              <th> 
                <input type="number" class="form-control" value="0" name="ttlweight"id="ttlweight">
              </th>
              <th>
                <input type="number" class="form-control" value="0" name="ttlqty"id="ttlqty">
              </th>
            </tr>
          </tfoot> -->
          </table>
          <button type="button" id="btn_bs1" class="btn btn-primary my-2" onclick="addweptRow()">Add</button>
        </div>
        <div class="my-2 col-md-6">
          <table id="zari_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="4">Bobin With Zari</td>
              </tr>
              <tr>
                <th>Bobin Id</th>
                <th>Zari Name</th>
                <th>Zari Weight</th>

              </tr>
            </thead>
            <tbody id="tbody_bs_zari">
              <tr>
                <td>
                  <input type="text" class="form-control" list="bobin_options" name="bobins2[]" class='text-uppercase' placeholder="SELECT BOBIN ID" onchange="bobinid2(this)">
                  <datalist id="bobin_options2">
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
                <td>
                  <input type="text" list="itemnamess" name="zarinames[]" class="form-control" placeholder="Select Raw Material" onchange="getitemname(this)">
                  <datalist id="itemnamess">
                    <?php
                    $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK' or itm_grp_id='ZARI' order by itm_nam");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['itm_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                </td>
                <td style="display:none">
                  <input type="hidden" name="hidden_zari_id[]">
                </td>
                <td style="display:none">
                  <input type="hidden" name="hidden_bobins_id2[]">
                </td>
                <td>
                  <input type="number" class="form-control" value="0" name="wghts2[]" onclick="this.select()" oninput="calculateTotalSum2()">
                </td>
                <!-- <td>
                <input type="number" class="form-control" value="0" name="qtys2[]" onclick="this.select()" oninput="calculateTotalSumqty2()">
              </td> -->
              </tr>
            </tbody>
            <!-- <tfoot>
            <tr>
              <th colspan = "2">TOTAL</th>
              <th> 
                <input type="number" class="form-control" value="0" name="ttlweight2"id="ttlweight2">
              </th>
              <th>
                <input type="number" class="form-control" value="0" name="ttlqty2"id="ttlqty2">
              </th>
            </tr>
          </tfoot> -->
          </table>
          <button type="button" id="btn_bs2" class="btn btn-primary my-2" onclick="addzariRow()">Add</button>
        </div>
        <div class="my-3 col-md-12">
          <a href="admin.php" class="btn btn-success float-start">Home</a>
          <button type="submit" name="save" class="btn btn-primary float-start mx-3">Save</button>
        </div>
      </div>
      <input type="hidden" name="hidden_location_id" id="hidden_location_id">
      <!-- loader -->
      <div id="loader" class="loader"></div>
      <button type="button" onclick="toggleScroll()" class="scroll-toggle-button" id="scroll">Scroll</button>
    </form>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/opening2.js"></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</body>

</html>