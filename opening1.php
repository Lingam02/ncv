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
    $warp = $_POST['warp_nos'];
    $warp_wghts = $_POST['warp_wghts'];
    $wept_colours_id = $_POST['hidden_colorid'];
    $wept_colours = $_POST['wept_colours'];
    $wept_wghts = $_POST['wept_wghts'];
    $zari_id = $_POST['hidden_zari_id'];
    $zari = $_POST['zarinames'];
    $zari_wghts = $_POST['zari_wghts'];

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

        $itm_type = "DSS";
        $tbl_type1 = "WARP";
        
        // First table INSERT
        $query1 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `warp_no`, `wght`) VALUES (?, ?,?, ?, ?, ?)";
        $stmt1 = mysqli_prepare($con, $query1);

        if ($stmt1) {
            for ($key = 0; $key < count($warp); $key++) {
                if ($warp[$key] !== "") {
                    mysqli_stmt_bind_param($stmt1, "sssssd", $locationid, $location, $itm_type,$tbl_type1, $warp[$key], $warp_wghts[$key]);
                    mysqli_stmt_execute($stmt1);
                }
            }
            echo "Details Saved successfully";
        } else {
            echo "Statement preparation failed: " . mysqli_error($con);
        }
        $tbl_type2 = "WEFT";
        // Second table INSERT
        $query2 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `col_id`, `col_nam`, `wght`) VALUES (?, ?, ?, ?, ?,?,?)";
        $stmt2 = mysqli_prepare($con, $query2);

        if ($stmt2) {
            for ($key = 0; $key < count($wept_colours_id); $key++) {
                if ($wept_colours_id[$key] !== "") {
                    mysqli_stmt_bind_param($stmt2, "ssssssd", $locationid, $location, $itm_type, $tbl_type2, $wept_colours_id[$key], $wept_colours[$key], $wept_wghts[$key]);
                    mysqli_stmt_execute($stmt2);
                }
            }
            echo "Details Saved successfully";
        } else {
            echo "Statement preparation failed: " . mysqli_error($con);
        }
        $tbl_type3 = "ZARI";
        // Third table INSERT
        $query3 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `itm_id`, `itm_nam`, `wght`) VALUES (?,?, ?, ?, ?, ?, ?)";
        $stmt3 = mysqli_prepare($con, $query3);

        if ($stmt3) {
            for ($key = 0; $key < count($zari_id); $key++) {
                if ($zari_id[$key] !== "") {
                    mysqli_stmt_bind_param($stmt3, "ssssssd", $locationid, $location, $itm_type, $tbl_type3, $zari_id[$key], $zari[$key], $zari_wghts[$key]);
                    mysqli_stmt_execute($stmt3);
                }
            }
            echo "Details Saved successfully";
            header("location: opening1.php");
        } else {
            echo "Statement preparation failed: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
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

  <!-- ------------------ 1 ------------------- -->

  <div class="container" id="dyedsilkstore">
    <h4 class="text-center mt-2 text-success">Opening Balance</h4>
    <form id="form1" action="" method="post" autocomplete="off">
      <div class="row">

        <div class="my-2 col-md-12">
          <label for="location" class="form-label me-2">Location</label>
          <input list="locations" id="location" type="text" name="location" class="form-control" required>
          <datalist id="locations">
          <?php
                    $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                    }
                    ?>
           
          </datalist>
        </div>
        <div class="my-2 col-md-6">
        <table id="warp_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="3">Warp</td>
              </tr>
              <tr>
                <th>Warp</th>
                <th>Warp Wght</th>
                <!-- <th>Warp Qty</th> -->
              </tr>
            </thead>
            <tbody id="tbody_ds_warp">
              <tr>

                <td>
                  <input type="text" class="form-control" id="warp_nos" name="warp_nos[]">
                </td>
                <td>
                  <input type="number" class="form-control" id="warp_wghts" value="0" name="warp_wghts[]" onclick="this.select()" oninput="calculateTotalSum()" class="form-control">
                </td>
                <!-- <td>1 </td> -->
              </tr>

            </tbody>
          </table>
          <button type="button" id="btn_ds1" class="btn btn-primary my-2"onclick ="addwarpRow()">Add</button>
        </div>
        <div class="my-2 col-md-6">
          <table id="wept_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="3">Wept</td>
              </tr>
              <tr>
                <th>Wept colour</th>
                <th>Wept Wght</th>
               
              </tr>
            </thead>
            <tbody id="tbody_ds_wept">
              <tr>
                <td>
                  <input type="text" list="colornamess" id="wept_colours" name="wept_colours[]" class="form-control" placeholder="Select Colour" onchange="getitemcolor(this)">
                  <datalist id="colornamess">
                    <?php
                    $sql = mysqli_query($con, "SELECT nam,id FROM cnf where cls='COLOR' order by nam");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                </td>
                <td>
                  <input type="number" class="form-control" value="0" id="wept_wghts" name="wept_wghts[]" onclick="this.select()" oninput="calculateTotalSum()">
                </td>
                <td style="display:none">
                  <input type="hidden"name="hidden_colorid[]">
                </td>
                <!-- <td>
                <input type="number" class="form-control" value="1" name="qtys_ds[]" onclick="this.select()">
              </td> -->
              </tr>

            </tbody>
          </table>
          <button type="button" id="btn_ds2" class="btn btn-primary my-2"onclick ="addweptRow()">Add</button>
        </div>
        <div class="my-2 col-md-6">
        <table id="zari_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="3">Zari</td>
              </tr>
              <tr>
                <th>Zari</th>
                <th>Zari Wght</th>
                <!-- <th>Zari Qty</th> -->
              </tr>
            </thead>
            <tbody id="tbody_ds_zari">
              <tr>

                <td>
                  <input type="text" list="itemnamess" id="zarinames" name="zarinames[]" class="form-control" placeholder="Select Raw Material" onchange="getitemname(this)">
                  <datalist id="itemnamess">
                    <?php
                    $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK' or itm_grp_id='ZARI' order by itm_nam");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['itm_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                </td>
                <td>
                  <input type="number" class="form-control" value="0" id="zari_wghts" name="zari_wghts[]" onclick="this.select()" oninput="calculateTotalSum()" class="form-control">
                </td>
                <td style="display:none">
                  <input type="hidden"name="hidden_zari_id[]">
                </td>
                <!-- <td>
                <input type="number" class="form-control" value="0" name="qtys[]" onclick="this.select()" class="form-control">
              </td> -->
              </tr>

            </tbody>
          </table>
          <button type="button" id="btn_ds3" class="btn btn-primary my-2" onclick ="addzariRow()">Add</button>
        </div>

        <div class="mt-3 col-md-6">
          <a href="admin.php" class="btn btn-success float-end">Home</a>
          <button type="submit" id="save" name="save" class="btn btn-primary float-end mx-3">Save</button>
        </div>
      </div>

      <input type="hidden" name="hidden_location_id" id="hidden_location_id">
    </form>
  </div>
 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/opening1.js"></script>
  <!-- <script>

document.getElementById('save').addEventListener('click', function saveForm1(event) {
 // event.preventDefault(); // Prevents the default form submission behavior
  
  // Submit the form with ID 'form1'
  if (document.getElementById('location').value === "") {
     alert('"please select location"');
  } else {
  document.getElementById('form1').submit();
    
  }
});

  </script> -->
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 
</body>

</html>