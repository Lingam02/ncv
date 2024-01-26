<!-- attach php code here -->
<?php
include "config.php";
//session_start();

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: ../index.php");
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
    if ($location == 'RAW STORE') {
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
    if ($location == 'RAW STORE') {
      // RS table INSERT
      $itm_type_RS = "RS"; //Raw Store
      $tbl_type2 = "WEFT";
      $query2 = "INSERT INTO `tbl_opening`(`loc_id`, `loc_name`, `itm_type`, `tbl_type`, `col_nam`, `wght`) VALUES (?, ?, ?, ?,?,?)";
      $stmt21 = mysqli_prepare($con, $query2);

      if ($stmt21) {
        for ($key = 0; $key < count($wept_nos); $key++) {
          if ($wept_nos[$key] > 0 && $wept_wghts[$key] !== "") {
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
    if ($location == 'RAW STORE') {
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
  <style>
    .content-section {
      display: none;
    }

    select {
      color: blue;
      font-weight: bold;
    }
  </style>

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
      <form id="form1" action="" method="post" autocomplete="off">
        <div class="container-fluid px-4">

          <!-- attach form container here starts -->
          <div class="body">



            <div class="container-fluid" id="rawstore">

              <h4 class="text-center mt-2 text-success">Inward Raw Material</h4>
              <!-- MAIN TAB-->
              <div class="row">
                <div class="col-lg-3">

                  <label for="tabSelector">Select a Type:</label>
                  <select id="tabSelector" onchange="openSection()">
                    <option value="select">SELECT</option>
                    <option value="section1">Warp</option>
                    <option value="section2">Weft</option>
                    <option value="section3">Zari</option>
                  </select>
                </div>
                <div class="col-lg-6">
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
              </div>


              <!-- 1 -->
              <div id="section1" class="content-section">
                <div class="container-fluid" id="tbl_1">
                  <div class="row">

                    <h4 class="text-center">Warp</h4>
                    <div class="col-md-2 mb-1">
                      <label for="bill_no">Select Bill No</label>
                      <input type="text" list="pur_bill" id="bill_no" name="bill_no" placeholder="SELECT BILL NO" onchange="fetch_bill_id()">
                      <datalist id="pur_bill">
                        <?php
                        $sql = mysqli_query($con, "SELECT auto_id, id FROM pur_hd WHERE vch_id = 'RAW_PUR' order by id");
                        while ($row = $sql->fetch_assoc()) {
                          echo "<option class='text-uppercase' value='" . $row['id'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                        }
                        ?>
                      </datalist>
                      <input type="hidden" name="pur_bill_id" id="pur_bill_id">
                    </div>
                    <div class="col-md-10 mb-1">
                      <label for="remarks">Remarks</label>
                      <input type="text" name="remarks" id="remarks">
                    </div>
                    <div class="col-md-2 mb-1">
                      <label for="ply_type">Select Ply Type</label>
                      <select name="ply_type" id="ply_type">
                        <option name="ply_type" value="1"> 1</option>
                        <option name="ply_type" value="2"> 2</option>
                        <option name="ply_type" value="3"> 3</option>
                      </select>
                    </div>
                    <div class="col-md-2 mb-1">
                      <label for="bill_no">Enter No of Warp</label>
                      <input type="number" id="no_of_warp" name="no_of_warp" placeholder="ENTER NO OF WARP">
                    </div>


                    <div class="col-lg-12 col-md-6">

                      <table id="warp_tbl">
                        <thead>
                          <tr class="tbl_heading">
                            <td colspan="5">Warp</td>
                          </tr>
                          <tr>
                            <th>Warp No</th>
                            <th>Warp Weight</th>
                            <th>Section</th>
                            <th>One Section</th>
                            <th>Count</th>
                          </tr>
                        </thead>
                        <tbody id="tbody_ds_warp">
                          <tr>

                            <td>
                              <input type="text" class="form-control" id="warp_nos" name="warp_nos[]">
                            </td>
                            <td>
                              <input type="number" class="form-control" id="warp_wghts" value="0" name="warp_wghts[]" class="form-control">
                            </td>
                            <td>
                              <input type="number" class="form-control" id="section" value="0" name="section[]" class="form-control" oninput="multiply_section()">
                            </td>
                            <td>
                              <input type="number" class="form-control" id="one_section" value="0" name="one_section[]" class="form-control" oninput="multiply_section()">
                            </td>
                            <td>
                              <input type="number" class="form-control" id="count" value="0" readonly name="count[]" class="form-control">
                            </td>
                            <!-- <td>1 </td> -->
                          </tr>

                        </tbody>
                      </table>
                    </div>


                  </div>
                </div>
              </div>

              <!-- 2 -->
              <div id="section2" class="content-section">
                <div class="container">
                  <div class="row">
                    <div class="my-2 col-md-6">
                      <table id="wept_tbl">
                        <thead>
                          <tr class="tbl_heading">
                            <td colspan="3">Weft</td>
                          </tr>
                          <tr>
                            <th> Batch No</th>
                            <th> Weight</th>

                          </tr>
                        </thead>
                        <tbody id="tbody_ds_wept">
                          <tr>
                            <td>
                              <input type="text" id="wept_nos" name="wept_nos[]" class="form-control" placeholder="">
                            </td>
                            <td>
                              <input type="number" id="wept_wghts" name="wept_wghts[]" class="form-control" value="0">
                            </td>
                          </tr>
                        </tbody>
                      </table>


                    </div>
                  </div>
                </div>

              </div>

              <!-- 3 -->
              <div id="section3" class="content-section">
                <div class="container">
                  <div class="row">
                    <div class="my-2 col-md-6">
<label for="">Select item</label>
                      <input type="text" list="itemnamess" id="zarinames" name="zarinames[]" class="form-control" placeholder="Select" onchange="getitemname(this)">
                      <datalist id="itemnamess">
                        <?php
                        $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK' or itm_grp_id='ZARI' order by itm_nam");
                        while ($row = $sql->fetch_assoc()) {
                          echo "<option class='text-uppercase' value='" . $row['itm_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                        }
                        ?>
                      </datalist>

                      <label for="">Select No of Reel </label>
                      <select name="reel_no" id="reel_no">
                        <option value="select">select</option>
                        <option value="4">4</option>
                        <option value="8">8</option>
                      </select>

                      <label for="">Enter No of Marc </label>
                      <input type="number" id="no_of_marc" name="no_of_marc" class="my-2" placeholder="ENTER NO OF MARC">
                     
                     
                      <table>
                        <thead>
                        <tr class="tbl_heading">
                            <th>Zari</th>
                            <!-- <th>hidden</th> -->
                          </tr>

                        </thead>
                        <tbody id="t_one">
                          <tr class="t_class">
                            <td>
                              <!--  -->
                              <table>
                                <tbody id="sub">
                                <tr class="tbl_heading">
                                    <td colspan="3">Zari</td>
                                  </tr>
                                  <tr>
                                    <th>Marc No</th>
                                    <th>Reel No</th>
                                    <th>Zari Weight</th>
                                  </tr>
                                  <tr class="zari_row">
                                    <td>
                                      <input type="number" class="form-control" value="0" name="zari_marc[]" class="form-control">
                                    </td>
                                    <td>
                                      <input type="number" class="form-control" value="0" name="zari_reel[]" class="form-control">
                                    </td>
                                    <td>
                                      <input type="number" class="form-control" value="0" name="zari_wghts[]" class="form-control">
                                    </td>

                                  </tr>
                                </tbody>
                              </table>

                              <!--  -->
                            </td>
                            <td style="display:none">
                            <td style="display:none">
                              <input type="hidden" name="hidden_ROW_id[]">
                            </td>
                            </td>
                          </tr>
                        </tbody>
                      </table>






                    </div>
                  </div>
                </div>
              </div>


              <!-- MAIN TAB-->

              <div class="mt-3 col-md-6">
                <button type="button" id="refresh" name="refresh" onclick="clearpage()" class="btn btn-primary float-end mx-3">Clear</button>
                <a href="admin.php" class="btn btn-success float-end">Home</a>
                <button type="submit" id="save" name="save" class="btn btn-primary float-end mx-3">Save</button>

              </div>



              <!-- <div id="loader" class="loader"></div> -->

            </div>



          </div>
          <!-- attach form container here ends -->

        </div>
    </div>

    <!-- /#page-content-wrapper ends-->
  </div>
  </form>
  <!-- footer starts -->
  <?php
  include_once "main/footer.php";
  ?>
  <!-- footer ends -->

  <!-- attach form js code here  -->


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="js/inward.js?<?php echo filemtime('js/inward.js'); ?>"></script>
  <Script>
    //---------------------------------------------------------------------------------------

    document.getElementById("no_of_warp").addEventListener('change', function() {
      var numrows = document.getElementById("no_of_warp").value;
      deleteRowsExceptLast();
      for (let i = 1; i < numrows; i++) {
        addRow_warp();
      }
    });
    document.getElementById("no_of_marc").addEventListener('change', function() {
      var numrows_marc = document.getElementById("no_of_marc").value;
      // deleteRowsExceptLast();
      for (let i = 1; i < numrows_marc; i++) {
        addRow_marc();
      }
    });
    document.getElementById("reel_no").addEventListener('change', function() {
      var numrows_reel = document.getElementById("reel_no").value;
      deleteRowsExceptLast();
      for (let i = 1; i < numrows_reel; i++) {
        addRow_reel();
      }
    });

    /* ------------------------------------------------------------------------------------------------------------------------------  */

    function addRow_warp() {
      const tableBody = document.getElementById("tbody_ds_warp");
      const firstRow = tableBody.querySelector("tr");
      const newRow = firstRow.cloneNode(true);

      // Clear the input fields in the new row
      const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
      addinginputs.forEach((input) => (input.value = ""));

      // Append the new row to the table body
      tableBody.appendChild(newRow);
    }

    function addRow_marc() {
      // alert('ok')
      const tableBody = document.getElementById("t_one");
      const firstRow = tableBody.querySelector(".t_class");
      const newRow = firstRow.cloneNode(true);

      // Clear the input fields in the new row
      const addinginputs = newRow.querySelectorAll(".tbl_adding");
      addinginputs.forEach((input) => (input.value = ""));

      // Append the new row to the table body
      tableBody.appendChild(newRow);
    }
    function addRow_reel() {
      // alert('ok')
      const tableBody = document.getElementById("sub");
      const firstRow = tableBody.querySelector(".zari_row");
      const newRow = firstRow.cloneNode(true);

      // Clear the input fields in the new row
      const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
      addinginputs.forEach((input) => (input.value = ""));

      // Append the new row to the table body
      tableBody.appendChild(newRow);
    }


    function deleteRowsExceptLast() {
      const tableBody = document.getElementById("tbody_ds_warp");
      const rows = tableBody.querySelectorAll("tr");
      // Keep the last row and remove the others
      for (let i = 0; i < rows.length - 1; i++) {
        rows[i].remove();
      }
      // Clear the input fields in the last row
      const lastRowInputs = rows[rows.length - 1].querySelectorAll("input[type='text'], input[type='number']");
      lastRowInputs.forEach((input) => (input.value = ""));
    }

    /* ------------------------------------------------------------------------------------------------------------------------------  */
  </Script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- attach form js code here  -->
</body>

</html>