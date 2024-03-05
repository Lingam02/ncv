<?php
include "config.php";
//session_start();

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: ../index.php");
  exit(); // Ensure that code stops executing after the redirect
}

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  date_default_timezone_set('Asia/Kolkata'); // Set the time zone to India Standard Time
  $save_time = $_POST['page_time']; // Get the current time in 24-hour format (e.g., 14:30:00)
  $save_date = $_POST['page_date'];
  // $save_time = date("H:i:s"); // Assuming you want to save the current time
  $tbl_type = $_POST['tbl_type'];
  $loc_id = $_POST['hidden_location_id']; // Assuming you have a hidden input field for location ID
  $loc_name = $_POST['location'];
  $warp_wght = $_POST['warp_wghts']; // Assuming this is an array of warp weights
  $yard = $_POST['yard']; // Assuming this is an array of warp weights
  $muzham = $_POST['mozham']; // Assuming this is an array of warp weights
  $no_of_saree = $_POST['no_of_saree']; // Assuming this is an array of section values
  $section = $_POST['section']; // Assuming this is an array of section values
  $one_section = $_POST['one_section']; // Assuming this is an array of one_section values
  $count = $_POST['count']; // Assuming this is an array of count values
  $weft_batch_no = $_POST['wept_nos']; // Assuming this is an array of weft batch numbers
  $weft_wght = $_POST['wept_wghts']; // Assuming this is an array of weft weights
  $warp_ply = $_POST['ply_type']; // Assuming this is the ply type
  $no_of_warp = $_POST['no_of_warp']; // Assuming this is the number of warp
  $no_of_marc = $_POST['no_of_marc'];
  $reel = $_POST['reel_no'];
  $zari_wghts = $_POST['zari_wghts'];
  $zari_item_nam = $_POST['zarinames'];
  $bill_no = $_POST['bill_no'];
  $bill_no2 = $_POST['bill_no2'];
  $bill_no3 = $_POST['bill_no3'];
  $remarks = $_POST['remarks'];
  $pur_wght = $_POST['pur_tot_wght'];
  $acname = $_POST['pur_acname'];
  $pur_date = $_POST['pur_date'];
  $warp_tag = $_POST['warpsrl'];
  $sup_id = $_POST['sup_id'];
  $sep = '1';

  // Prepare and execute the INSERT statement based on table type
  switch ($tbl_type) {
    case 'section1':
      $sql = "INSERT INTO inward_hd (save_date, save_time, tbl_type, loc_id, loc_name, bill_no, pur_wght, remarks, acname, pur_date) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, "ssssssssss", $save_date, $save_time, $tbl_type, $loc_id, $loc_name, $bill_no, $pur_wght, $remarks, $acname, $pur_date);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      $last_id1 = mysqli_insert_id($con);

      if (!empty($warp_wght) && !empty($count)) {
        // Loop through the submitted data and insert each row into the database
        for ($keys = 0; $keys < count($warp_wght); $keys++) {
          if ($warp_wght[$keys] > 0.00 && $count[$keys] > 0.00) {
            $sql = "INSERT INTO warp_details (warp_no,hd_id,pur_date,iss_date, iss_time,pur_invno,sup_id,wght, tbl_type, loc_id, loc_nam, silk_wght,yard,no_saree,muzham, section, one_section, s_count, ply, no_warp) /*20*/
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssssssdssssssss",$warp_tag[$keys], $last_id1,$pur_date, $save_date, $save_time,$bill_no,$sup_id, $pur_wght, $tbl_type, $loc_id, $loc_name, $warp_wght[$keys],$yard[$keys],$no_of_saree[$keys],$muzham[$keys], $section[$keys], $one_section[$keys], $count[$keys], $warp_ply, $no_of_warp);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
          }
        }
        $sql = "UPDATE pur_det SET sepration = ? WHERE id = ? ";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $sep, $bill_no);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: inward.php");
      }
      break;
    case 'section2':
      $sql = "INSERT INTO inward_hd (save_date, save_time, tbl_type, loc_id, loc_name, bill_no, pur_wght, remarks, acname, pur_date) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, "ssssssssss", $save_date, $save_time, $tbl_type, $loc_id, $loc_name, $bill_no3, $pur_wght, $remarks, $acname, $pur_date);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      $reff_id2 = mysqli_insert_id($con);
      // Loop through the submitted data and insert each row into the database
      for ($i = 0; $i < count($weft_batch_no); $i++) {
        $sql = "INSERT INTO inward (reff_id,save_date, save_time, tbl_type, loc_id, loc_name, weft_batch_no, weft_wght) 
                        VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssd", $reff_id2, $save_date, $save_time, $tbl_type, $loc_id, $loc_name, $weft_batch_no[$i], $weft_wght[$i]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }
      header("location: inward.php");
      break;
    case 'section3':
      $sql = "INSERT INTO inward_hd (save_date, save_time, tbl_type, loc_id, loc_name, bill_no, pur_wght, remarks, acname, pur_date) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, "ssssssssss", $save_date, $save_time, $tbl_type, $loc_id, $loc_name, $bill_no2, $pur_wght, $remarks, $acname, $pur_date);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      $reff_id3 = mysqli_insert_id($con);
      // Loop through the submitted data and insert each row into the database

      // Assuming each reel has multiple zari entries
      // for ($j = 0; $j < $_POST['reel_no'][$i]; $j++) {
      $sql = "INSERT INTO inward (reff_id,save_date, save_time, tbl_type, loc_id, loc_name,zari_item_name, no_of_marc, reel_no, zari_wght) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, "sssssssssd", $reff_id3, $save_date, $save_time, $tbl_type, $loc_id, $loc_name, $zari_item_nam, $no_of_marc, $reel, $zari_wghts);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      // }

      header("location: inward.php");
      break;
    default:
      // Invalid table type
      break;
  }
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";

  // Close the database connection
  mysqli_close($con);
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
  <link rel="stylesheet" href="css/reportbills.css?<?php echo filemtime('css/reportbills.css'); ?>">
  <style>
    .content-section {
      display: none;
    }

    select {
      color: blue;
      font-weight: bold;
    }
    #warp_tbl input{
      padding:2px;
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
    <form id="form1" action="" method="post" autocomplete="off">

      <!-- navbar starts -->
      <?php
      include_once "main/navbar.php";
      ?>
      <!-- navbar ends -->
        <div class="container-fluid px-4">

          <!-- attach form container here starts -->
          <div class="body">



            <div class="container-fluid" id="rawstore">

              <h4 class="text-center mt-2 text-success">Inward Raw Material</h4>
              <!-- MAIN TAB-->
              <div class="row">
                <div class="col-lg-5">
                  <label for="location">Location</label>
                  <input list="locations" id="location" type="text" name="location" class="form-control" required onkeypress="handleEnterKey(event, 'bill_no')">
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
                <div class="col-lg-2">

                  <label for="tbl_type">Select a Type:</label>
                  <select id="tbl_type" name="tbl_type" onchange="openSection()" onkeypress="handleEnterKey(event, 'location')">
                    <option value="select">SELECT</option>
                    <option value="section1">Warp</option>
                    <option value="section2">Weft</option>
                    <option value="section3">Zari</option>
                    <option value="section4">View Warp Details</option>
                  </select>
                </div>

                <div class="col-lg-2 mb-1" id="kora_bill">
                  <label for="bill_no">Select Warp Bill No</label>
                  <input onkeypress="handleEnterKey(event, 'remarks')" type="text" list="pur_bill" id="bill_no" name="bill_no" placeholder="SELECT BILL NO">
                  <datalist id="pur_bill">
                    <?php
                    $sql = mysqli_query($con, "SELECT id,auto_id FROM pur_det WHERE it_id = 'IT0005' and sepration = 0 order by id");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['id'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                  <input type="hidden" name="pur_bill_id" id="pur_bill_id">
                </div>
               
                <div class="col-lg-2 mb-1" id="zari_bill">
                  <label for="bill_no2">Select Zari Bill No</label>
                  <input onkeypress="handleEnterKey(event, 'remarks')" type="text" list="pur_bill2" id="bill_no2" name="bill_no2" onclick="this.select()" placeholder="SELECT BILL NO">
                  <datalist id="pur_bill2">
                    <?php
                    $sql = mysqli_query($con, "SELECT id,auto_id FROM pur_hd WHERE vch_id = 'RAW_PUR' and pur_acid = 'JPUR001' order by id");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['id'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                  <input type="hidden" name="pur_bill_id2" id="pur_bill_id2">
                </div>
                <div class="col-lg-2 mb-1" id="weft_bill">
                  <label for="bill_no3">Select Weft Bill No</label>
                  <input onkeypress="handleEnterKey(event, 'remarks')" type="text" list="pur_bill3" id="bill_no3" name="bill_no3" onclick="this.select()" placeholder="SELECT BILL NO">
                  <datalist id="pur_bill3">
                    <?php
                    $sql = mysqli_query($con, "SELECT id,auto_id FROM pur_det WHERE it_id = 'IT0008' order by id");
                    while ($row = $sql->fetch_assoc()) {
                      echo "<option class='text-uppercase' value='" . $row['id'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                    }
                    ?>
                  </datalist>
                  <input type="hidden" name="pur_bill_id3" id="pur_bill_id3">
                </div>
                <!-- <div class="col-lg-3 mb-1">
                  <label for="warp_page_date">Today Date</label>
                  <input onkeypress="handleEnterKey(event, 'remarks')" class="form-control" type="date" id="warp_page_date" name="warp_page_date">

                </div> -->
                <!-- <div class="col-lg-3 mb-1"> -->
                  <!-- <label for="warp_page_date">Time</label> -->
                  <input type="hidden" class="form-control shadow-none ms-2" id="currentTime" name="currentTime" readonly >
                <!-- </div> -->
                <div class="col-lg-12 mb-1">
                  <label for="remarks">Remarks</label>
                  <textarea onkeypress="handleEnterKey(event,'ply_type')" class="form-control" name="remarks" id="remarks" cols="60" rows="2"></textarea>
                </div>
                <div class="col-lg-3 mb-1">
                  <label for="">Purchase Weight</label>
                  <input type="number" class="form-control" onkeypress="handleEnterKey(event,'warp_wghts')" id="pur_tot_wght" name="pur_tot_wght">
                </div>
                <div class="col-lg-3 mb-1">
                  <label for="">Purchased From</label>
                  <input type="text" class="form-control" onkeypress="handleEnterKey(event,'warp_wghts')" id="pur_acname" name="pur_acname">
                <input type="hidden" id="sup_id" name="sup_id">
                </div>
                <div class="col-lg-3 mb-1">
                  <label for="">Purchased Date</label>
                  <input type="date" class="form-control" onkeypress="handleEnterKey(event,'warp_wghts')" id="pur_date" name="pur_date">
                </div>
              </div><!-- row div end -->



              <!--  -->

              <!-- 1 -->
              <div id="section1" class="content-section">
                <div class="container-fluid p-0" id="tbl_1">
                  <div class="row">



                    <div class="col-lg-9 col-md-9">
                    <!-- <div class="col-lg-12"> -->

                      <table id="warp_tbl">
                        <thead>
                          <tr class="">
                            <td colspan="4">
                              <select name="ply_type" id="ply_type" onkeypress="handleEnterKey(event,'no_of_warp')">
                                <option name="ply_type" value="0"> Select Ply Type</option>
                                <option name="ply_type" value="1"> 1</option>
                                <option name="ply_type" value="2"> 2</option>
                                <option name="ply_type" value="3"> 3</option>
                              </select>
                            </td>
                            <td colspan="4">
                              <input type="number" class="form-control" required onkeypress="handleEnterKey(event,'warp_wghts')" id="no_of_warp" name="no_of_warp" placeholder="ENTER NO OF WARP">

                            </td>
                          </tr>
                          <tr class="tbl_heading">
                            <td colspan="8">Warp</td>
                          </tr>
                          <tr>
                            <th>S.No</th>
                            <th>Warp Weight</th>
                            <th>Yard</th>
                            <th>No Of Saree</th>
                            <th>Mozham</th>
                            <th>Section</th>
                            <th>One Section</th>
                            <th>Count</th>
                            <th>Warp No</th>
                            
                            <!-- <th style="width: 10%;">Warp No</th>
                            <th style="width: 20%;">Warp Weight</th>
                            <th style="width: 10%;">Yard</th>
                            <th style="width: 10%;">No Of Saree</th>
                            <th style="width: 10%;">Mozham</th>
                            <th style="width: 20%;">Section</th>
                            <th style="width: 10%;">One Section</th>
                            <th style="width: 10%;">Count</th> -->
                          </tr>
                        </thead>
                        <tbody id="tbody_ds_warp">
                          <tr>

                            <td>
                              1
                            </td>
                            
                            <td>
                              <input type="number" oninput="calculateTotalSum()" onkeypress="handleEnterKeys(event,'yard')" class="form-control" id="warp_wghts" name="warp_wghts[]" class="form-control">
                            </td>
                            <td>
                              <input type="number" onkeypress="handleEnterKeys(event,'no_of_saree')" class="form-control" id="yard" name="yard[]" class="form-control">
                            </td>
                            <td>
                              <input type="number" onkeypress="handleEnterKeys(event,'mozham')" class="form-control" id="no_of_saree" name="no_of_saree[]" class="form-control">
                            </td>
                            <td>
                              <input type="number" onkeypress="handleEnterKeys(event,'section')" class="form-control" id="mozham" name="mozham[]" class="form-control">
                            </td>
                            <td>
                              <input type="number" oninput="calculateTotalSum2()" onkeypress="handleEnterKeys(event,'one_section')" class="form-control" id="section" name="section[]" class="form-control" oninput="multiply_section()">
                            </td>
                            <td>
                              <input type="number" onkeypress="handleEnterKeys(event,'count')" class="form-control" id="one_section" name="one_section[]" class="form-control" oninput="multiply_section()">
                            </td>
                            <td>
                              <input type="number" onkeypress="handleEnterKeys(event,'warp_wghts')" class="form-control" id="count" readonly name="count[]" class="form-control">
                            </td>
                            <td>
                            <input type="text"readonly name="warpsrl[]" id="warpsrl">
                            </td>
                            <!-- <td>1 </td> -->
                          </tr>

                        </tbody>
                        <tfoot>
                          <tr>
                            <td>
                              Total
                            </td>
                            <td>
                              <input readonly type="number" name="ttl_warp_wghts" id="ttl_warp_wghts">
                            </td>
                            <td colspan="3">
                              Total Section
                            </td>

                            <td>
                              <input readonly type="number" name="ttl_section" id="ttl_section">
                            </td>
                            <td>
                              Total Count
                            </td>
                            <td>
                              <input readonly type="number" name="ttl_count" id="ttl_count">
                            </td>
                            <!-- ..//.. -->

                          </tr>
                        </tfoot>
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
                <div class="container p-0">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="">Select item</label>
                      <input type="text" list="itemnamess" id="zarinames" name="zarinames" class="form-control" placeholder="Select" onchange="getitemname(this)">
                      <datalist id="itemnamess">
                        <?php
                        $sql = mysqli_query($con, "SELECT * FROM itm where itm_grp_id='SILK' or itm_grp_id='ZARI' order by itm_nam");
                        while ($row = $sql->fetch_assoc()) {
                          echo "<option class='text-uppercase' value='" . $row['itm_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                        }
                        ?>
                      </datalist>




                      <!-- <label for=""> NO of Reel</label>
                      <input type="number" class="form-control" value="0" name="zari_reel" class="form-control"> -->




                      <!-- <table>
                        <thead>
                          <tr class="tbl_heading">
                            <th>Zari</th>
                          </tr>

                        </thead>

                        <tbody id="t_one">
                          <tr class="t_class">
                            <td>
                              
                              <table>
                                <tbody id="sub">
                                  <tr class="tbl_heading">
                                    <td colspan="3">Mark (${i})</td>
                                  </tr>
                                  <tr>

                                    <th>Reel No</th>
                                    <th>Zari Weight</th>
                                  </tr>
                                  <tr class="zari_row">

                                    <td>
                                      <input type="number" class="form-control" value="0" name="zari_reel[]" class="form-control">
                                    </td>
                                    <td>
                                      <input type="number" class="form-control" value="0" name="zari_wghts[]" class="form-control">
                                    </td>

                                  </tr>
                                </tbody>
                              </table>

                              
                            </td>
                            <td style="display:none">
                            <td style="display:none">
                              <input type="hidden" name="hidden_ROW_id[]">
                            </td>
                            </td>
                          </tr>
                        </tbody>
                      </table> -->






                    </div>

                  </div>
                </div>
                <div class="container p-0">
                  <div class="row">
                    <div class="col-lg-2">
                      <label for="">Enter No of Marc </label>
                      <input type="number" id="no_of_marc" name="no_of_marc" class="" placeholder="ENTER NO OF MARC">
                    </div>
                    <div class="col-lg-2">

                      <label for="">Select No of Reel </label>
                      <select name="reel_no" id="reel_no">
                        <option value="select">select</option>
                        <option value="4">4</option>
                        <option value="8">8</option>
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <label for="">Grams</label> <!--Zari Weights -->
                      <input type="number" class="form-control" name="zari_wghts" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            <!--  -->
            
            <div class="mt-3 col-md-6">
                <button type="button" id="refresh" name="refresh" onclick="clearpage()" class="btn btn-primary float-end mx-3">Clear</button>
                <a href="admin.php" class="btn btn-success float-end">Home</a>
                <button type="button" id="save" name="save" class="btn btn-primary float-end mx-3" onclick="frmsave()">Save</button>

              </div>
            

            <!--  -->
            
              <!-- MAIN TAB-->

            </div><!-- container div -->



          </div>
          <!-- attach form container here ends -->

        </div>
        <div id="tag_reports" class="table-frame mt-4">
              <table id="warp_report_tbl">
                <thead>
                  <tr>
                    <td colspan="2" class="fw-bold">View Warp Bill No</td>
                     <td colspan="2">
                        <input onkeypress="handleEnterKey(event, 'remarks')" type="text" onclick="this.select()" list="pur_bill4" id="bill_no4" name="bill_no4" placeholder="SELECT BILL NO">
                          <datalist id="pur_bill4">
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM inward_hd WHERE tbl_type = 'section1' order by id");
                            while ($row = $sql->fetch_assoc()) {
                              echo "<option class='text-uppercase' value='" . $row['bill_no'] . "' data-acid='" . $row['id'] . "'></option>";
                            }
                            ?>
                           </datalist>
                          <input type="hidden" name="pur_bill_id4" id="pur_bill_id4">
                         </td>
         
                  </tr>
                  <tr>
                    <th>Warp No</th>
                    <th>Silk Weight</th>
                    <th>Yard</th>
                    <th>No of Saree</th>
                    <th>Muzham</th>
                    <th>Section</th>
                    <th>One Section</th>
                    <th>Count</th>
                 </tr>
                </thead>
                      <tbody>
                      </tbody>
              </table>

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
  <script src="js/warp_det_display.js?<?php echo filemtime('js/warp_det_display.js'); ?>"></script>
  <script src="js/date_time.js?<?php echo filemtime('js/date_time.js'); ?>"></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- attach form js code here  -->
</body>

</html>
