

 <!-- attach php code here -->
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
  
  $wept_nos = $_POST['wept_nos'];
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
    if ($location == 'RAW MATERIAL STORE') {
   //---------------------------
    //raw store starts
    $itm_type_RS = "RS"; //Raw Store
    $tbl_type0 = "WARP";

    // raw table INSERT
    $query0 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `warp_no`, `wght`) VALUES (?, ?,?, ?, ?, ?)";
    $stmt0 = mysqli_prepare($con, $query0);

    if ($stmt0) {
      for ($key = 0; $key < count($warp); $key++) {
        if ($warp[$key] !== "") {
          mysqli_stmt_bind_param($stmt0, "sssssd", $locationid, $location, $itm_type_RS, $tbl_type0, $warp[$key], $warp_wghts[$key]);
          mysqli_stmt_execute($stmt0);
        }
      }
      echo "Details Saved successfully";
    } else {
      echo "Statement preparation failed: " . mysqli_error($con);
    }
    //ENDS RAW STORE
    //-----------------------------
  }

 
    // Second table INSERT
    if ($location == 'RAW MATERIAL STORE') {
       // RS table INSERT
    $itm_type_RS = "RS"; //Raw Store
    $tbl_type2 = "WEFT";
    $query2 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `col_nam`, `wght`) VALUES (?, ?, ?, ?,?,?)";
    $stmt21 = mysqli_prepare($con, $query2);

    if ($stmt21) {
      for ($key = 0; $key < count($wept_nos); $key++) {
        if ($wept_nos[$key] > 0 && $wept_wghts[$key] !== "" ) {
          mysqli_stmt_bind_param($stmt21, "sssssd", $locationid, $location, $itm_type_RS, $tbl_type2, $wept_nos[$key], $wept_wghts[$key]);
          mysqli_stmt_execute($stmt21);
        }
      }
      echo "Details Saved successfully";
    } else {
      echo "Statement preparation failed: " . mysqli_error($con);
    }
    //second end
    }
    if ($location == 'RAW MATERIAL STORE') {
    // Third table INSERT
  $itm_type_RS = "RS";
  $tbl_type3 = "ZARI";
  $query3 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `itm_id`, `itm_nam`, `wght`) VALUES (?,?, ?, ?, ?, ?, ?)";
  $stmt23 = mysqli_prepare($con, $query3);

  if ($stmt23) {
    for ($key = 0; $key < count($zari_id); $key++) {
      if ($zari_id[$key] > 0 && $zari_wghts[$key] > 0 && $zari[$key] !== "") {
        mysqli_stmt_bind_param($stmt23, "ssssssd", $locationid, $location, $itm_type_RS, $tbl_type3, $zari_id[$key], $zari[$key], $zari_wghts[$key]);
        mysqli_stmt_execute($stmt23);
      }
    }
    echo "Details Saved successfully";
    header("location: opening_raw.php");
  } else {
    echo "Statement preparation failed: " . mysqli_error($con);
  }
  }
   
    mysqli_stmt_close($stmt2);
    mysqli_stmt_close($stmt21);
    mysqli_stmt_close($stmt23);
    mysqli_close($con);
  } else {
    echo "Location ID not set.";
  }
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

  <!-- attach form css link here-->
  <link rel="stylesheet" href="css/opening.css?<?php echo filemtime('css/opening.css'); ?>">

  <!-- attach form css link here ends-->
 

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

        <!-- attach form container here starts -->
      <div class="body">


      <div class="container" id="rawstore">
    <h4 class="text-center mt-2 text-success">Opening Balance of Raw Material Store</h4>
    <form id="form1" action="" method="post" autocomplete="off">
      <div class="row">

        <div class="my-2 col-md-12">
          <label for="location" class="form-label me-2">Location</label>
          <input list="locations" id="location" type="text" name="location" class="form-control" required>
          <datalist id="locations">
            <?php
            $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores WHERE loc_nam ='RAW MATERIAL STORE'  order by loc_nam");
            while ($row = $sql->fetch_assoc()) {
              echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
            }
            ?>
          </datalist>
          <input type="hidden" name="hidden_location_id" id="hidden_location_id">
        </div>
        <div class="my-2 col-md-6"id="tbl_1">
          <table id="warp_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="3">Warp</td>
              </tr>
              <tr>
                <th>Warp</th>
                <th>Warp Weight</th>
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
          <button type="button" id="btn_ds1" class="btn btn-primary my-2" onclick="addwarpRow()">Add</button>
          
        </div>
    
        <div class="my-2 col-md-6">
          <table id="wept_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="3">Weft</td>
              </tr>
              <tr>
                <th>Weft</th>
                <th>Weft Weight</th>
              </tr>
            </thead>
            <tbody id="tbody_ds_wept">
              <tr>
                <td>
                  <input type="text" id="wept_nos" name="wept_nos[]" class="form-control" placeholder="" >
                </td>
                <td>
                  <input type="number" id="wept_wghts" name="wept_wghts[]" class="form-control" value="0" >
                </td>
              </tr>
            </tbody>
          </table>
          <button type="button" id="btn_ds2" class="btn btn-primary my-2" onclick="addweptRow()">Add</button>
          

        </div>
        <div class="my-2 col-md-6">
          <table id="zari_tbl">
            <thead>
              <tr class="tbl_heading">
                <td colspan="3">Zari</td>
              </tr>
              <tr>
                <th>Zari</th>
                <th>Zari Weight</th>
              </tr>
            </thead>
            <tbody id="tbody_ds_zari">
              <tr>
                <td>
                  <input type="text" list="itemnamess" id="zarinames" name="zarinames[]" class="form-control" placeholder="Select" onchange="getitemname(this)">
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
                  <input type="hidden" name="hidden_zari_id[]">
                </td>
        
              </tr>

            </tbody>
          </table>
          <button type="button" id="btn_ds3" class="btn btn-primary my-2" onclick="addzariRow()">Add</button>
          

        </div>


        <div class="mt-3 col-md-6">
          <button type="button" id="refresh" name="refresh" onclick="clearpage()" class="btn btn-primary float-end mx-3">Clear</button>
          <a href="admin.php" class="btn btn-success float-end">Home</a>
          <button type="submit" id="save" name="save" class="btn btn-primary float-end mx-3">Save</button>

        </div>
      </div>

   
      <!-- <div id="loader" class="loader"></div> -->
    </form>
  </div>


      
      </div>
        <!-- attach form container here ends -->

      </div>
    </div>

    <!-- /#page-content-wrapper ends-->
  </div>

  <!-- footer starts -->
  <?php
  include_once "main/footer.php";
  ?>
  <!-- footer ends -->

 <!-- attach form js code here  -->

 
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/opening_raw.js?<?php echo filemtime('js/opening_raw.js'); ?>"></script>

<script src="//code.jquery.com/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <!-- attach form js code here  -->
</body>

</html>