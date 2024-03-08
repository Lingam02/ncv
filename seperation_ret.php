<!-- attach php code here -->
<?php
include "config.php";
// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit(); // Ensure that code stops executing after the redirect
}
include_once("utils/utils.php");

$result = $con->query("SELECT * from setup limit 1");
if ($result->num_rows > 0) {
    // Fetch the first row from the result set
    $row = $result->fetch_assoc();

    // Initialize an array to store the metadata
    $meta = array();

    // Process each key-value pair in the fetched row
    foreach ($row as $key => $value) {
        // Store the key-value pair in the $meta array
        $meta[$key] = $value;
    }

    // Assuming tagcals is a function defined in utils.php, process booking_id
    if (isset($meta['warp_no2'])) {
        $warp_dyetag = tagcals($meta['warp_no2']);
    } else {
        // Handle the case where 'warp_no2' is not set in the metadata
        $warp_dyetag = null; // or assign a default value
    }
} else {
    // Handle the case where no rows are returned from the query
    // For example, display an error message or set default values for $meta and $booking_id
}


// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    date_default_timezone_set('Asia/Kolkata'); // Set the time zone to India Standard Time
    $save_time = $_POST['page_time']; // Get the current time in 24-hour format (e.g., 14:30:00)
    $save_date = $_POST['page_date'];
    // $save_time = date("H:i:s"); // Assuming you want to save the current time
    $tbl_type = "WPSEPRET";
   
    // Retrieve other form data
    $loom_nam = $_POST['loom_nam'];
    $loom_id = $_POST['loom_id']; 

    $loc_nam = $_POST['iss_location'];
    $loc_id = $_POST['loc_id']; 

    $loc_nam2 = $_POST['iss_location2'];
    $loc_id2 = $_POST['loc_id2']; 

    $dyer_nam = $_POST['dyer_nam']; 
    $dyer_id = $_POST['dyer_id']; 

    $warp_no = $_POST['warp_no2']; 
    $border_nam = $_POST['border_nam2']; 
    $ply = $_POST['ply2']; 
    $section2 = $_POST['section2']; 
    $wght2 = $_POST['wght2']; 
    $section3 = $_POST['section3']; 
    $wght3 = $_POST['wght3']; 
    $section4 = $_POST['section4']; 
    $wght4 = $_POST['wght4']; 
    $position = 'FRM-RET';


    $yard = $_POST['yard2']; 
    $no_saree = $_POST['no_saree2']; 
    $muzham = $_POST['muzham2']; 
    $one_section = $_POST['one_section2']; 
    $s_count = $_POST['s_count2']; 
   
// tag no genrating

$con->begin_transaction();

$warp_dyetag = $_POST['booking_id']; // Define $booking_id here

$query = "SELECT * from setup ";
$stmt = mysqli_prepare($con, $query);

if ($stmt === false) {
    die("Preparation failed: " . mysqli_error($con));
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo "booking id Config Error?";
    return;
}

$setup = mysqli_fetch_array($result);

if ($setup === false) {
    die("Error fetching data: " . mysqli_error($con));
}

$book_id = tagcal($setup["warp_no2"]);

if ($book_id === null) {
    die("Error in tagcal function.");
}

$sql = "UPDATE setup SET warp_no2 = ? ";
$stmt = mysqli_prepare($con, $sql);

if ($stmt === false) {
    die("Preparation failed: " . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, "s", $book_id); // Make sure $book_id holds the correct value
if (mysqli_stmt_execute($stmt)) {
    echo "Update successful!";
} else {
    echo "Update failed: " . mysqli_error($con);
}

mysqli_stmt_close($stmt);
$con->commit();
// tag no genrating

    if (!empty($border_nam)) {  
        //--------------------------------  DELETE OLD VALUES -------------
        $sql = "DELETE FROM sep WHERE loom_id = ? AND date = ?";
        $stmt = mysqli_prepare($con, $sql);
        
        // Check for preparation errors
        if ($stmt === false) {
            die("Preparation failed: " . mysqli_error($con));
        }
        
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ss", $loom_id, $save_date);
        if (mysqli_stmt_execute($stmt)) {
            echo "Delete successful!";
        } else {
            // Display more informative error message
            die("Delete failed: " . mysqli_stmt_error($stmt));
        }
        
        // Close the prepared statement
        mysqli_stmt_close($stmt);
        //-----------------------------------------------------------------
        $tnx_id = 'sep_ret';
        // Loop through the submitted data and insert each row into the database
        for ($key = 0; $key < count($border_nam); $key++) {
            if ($border_nam != "") {
                $sql = "INSERT INTO sep (tnx_id,yard,no_saree,muzham,one_section,s_count, date, time, tnx_type, warp_no, loc_id, typ, loc_nam, loom_id, loom_nam, ply, section, wght, loc_id2, loc_nam2, position) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                // $new_warp_no = $warp_no[$key].'/'.($key+1);
                mysqli_stmt_bind_param($stmt, "sssssdsssssssssssdiss", $tnx_id,$yard[$key],$no_saree[$key],$muzham[$key],$one_section[$key],$s_count[$key], $save_date, $save_time, $tbl_type, $warp_no[$key], $loc_id, $border_nam[$key], $loc_nam, $loom_id, $loom_nam, $ply[$key], $section4[$key], $wght4[$key], $loc_id2, $loc_nam2, $position);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                // $last_id1 = mysqli_insert_id($con);
            }
        }
      
        // $sql = "UPDATE sep SET position = ? WHERE warp_no = ? ";
        // $stmt = mysqli_prepare($con, $sql);
        // mysqli_stmt_bind_param($stmt, "ss", $available, $warp_no);
        // mysqli_stmt_execute($stmt);
        // mysqli_stmt_close($stmt);

        // header("location: seperation_ret.php");
        $tnx_id = "sep_ret";
        $inw = "inw";
        if (!empty($wght4)) {
            // Loop through the submitted data and insert each row into the database
            for ($keys = 0; $keys < count($wght4); $keys++) {
                if ($wght4[$keys] > 0.00) {

                    $section1 = -1 * ($section4[$keys]);
                    $wght1 = -1 * ($wght4[$keys]);
                    $sql = "INSERT INTO warp_stock (tnx_id, reff_id, doc_id, date, time, inw, section, wght, section1, wght1) /*10*/
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, "sssssssdsd", $tnx_id, $warp_no[$keys], $warp_no[$keys], $save_date, $save_time, $inw, $section4[$keys], $wght4[$keys], $section1, $wght1);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
            }
          
            header("location: seperation_ret.php");
        }
    }

    if (!empty($wght3)) {
        // Loop through the submitted data and insert each row into the database
        for ($keys = 0; $keys < count($wght3); $keys++) {
            if ($wght3[$keys] > 0.00) {

                $section1 = -1 * ($section3[$keys]);
                $wght1 = -1 * ($wght3[$keys]);
                $sql = "INSERT INTO warp_stock (tnx_id, reff_id, doc_id, date, time, inw, section, wght, section1, wght1) /*10*/
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "sssssssdsd", $tnx_id, $warp_no[$keys], $warp_no[$keys], $save_date, $save_time, $inw, $section3[$keys], $wght3[$keys], $section1, $wght1);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
      
        header("location: seperation_ret.php");
    }
// }

// First table INSERT
$query1 = "INSERT INTO sep_ret (tnx_id,yard,no_saree,muzham,one_section,s_count, date, time,new_warp_no, tnx_type, warp_no, loc_id, typ, loc_nam, loom_id, ply, section, wght, loc_id2, loc_nam2, position, iss_section, iss_wght, bal_section, bal_wght) 
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt1 = mysqli_prepare($con, $query1);
if ($stmt1) {
    for ($key = 0; $key < count($border_nam); $key++) {
        if ($border_nam[$key] !== "") {
            $new_warp_no = $warp_no[$key] . '/S' . ($key + 1);

            mysqli_stmt_bind_param($stmt1, "sssssdsssssssssssdssssdsd", $tnx_id,$yard[$key],$no_saree[$key],$muzham[$key],$one_section[$key],$s_count[$key], $save_date, $save_time,$warp_dyetag, $tbl_type, $new_warp_no, $loc_id, $border_nam[$key], $loc_nam, $loom_id, $ply[$key], $section3[$key], $wght3[$key], $loc_id2, $loc_nam2, $position, $section2[$key], $wght2[$key], $section4[$key], $wght4[$key]);
            mysqli_stmt_execute($stmt1);
        }
    }
    echo "Details Saved successfully";
    header("location: seperation_ret.php");
} else {
    echo "Statement preparation failed: " . mysqli_error($con);
}
   
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
<link rel="stylesheet" href="css/table_sep.css">
     <!-- attach form css link here-->
     <style>
        /* #saree_table th{
        background-color: #fff !important;            
        } */
         label {
             display: flex;
             width: 150px;
         }

         .form-group {
             display: flex;
         }

         h4 {
             text-align: center;
             background-color: #ff7bcf;
             margin: 10px 0;
             color: #fff;
             padding: 10px;
         }

         #issue_div {
             border: 1px solid lightblue;
             padding: 20px;
             margin-bottom: 10px;
             /* background:#FFF; */
         }

         #return_div {
             border: 1px solid lightblue;
             padding: 20px;
             margin-bottom: 10px;
             /* background: lightblue; */
         }

         .select_type {
             border: 1px solid lightblue;
             padding: 20px;
             margin-bottom: 10px;
             /* background: #fff; */
         }

         .container_seperation {
             background-color: #fff;
             padding: 20px;
             border-radius: 8px;

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
             <form id="form" action="" method="post" autocomplete="off"> 
             <!-- navbar starts -->
             <?php
                include_once "main/navbar.php";
                ?>
             <!-- navbar ends -->
             <div class="container-fluid px-4">
                 <!-- attach form container here starts -->
                 <div class="body">
                         <div class="container_seperation">
                             <h4 id="heading" class="m-4">Return From Seperation</h4>
                          
                             <div id="issue_div">
                        
                                 <div class="form-group">
                                     <label for="iss_fromloc">Loom:</label>
       
                                     <input onkeypress="handleEnterKey(event, 'iss_location')" list="loom_nams" name="loom_nam" id="loom_nam" class="form-control" placeholder="Select Loom" required>
                                     <datalist id="loom_nams">
                                         <?php
                                            $sql = mysqli_query($con, "SELECT nam,auto_id,maj_nam FROM cnf where cls='WRK_UNIT' and val='Loom' order by nam");                                            while ($row = $sql->fetch_assoc()) {
                                            echo "<option class='text-uppercase' value='" . $row['nam'] . " ( " . trim($row['maj_nam']) . " )" .  "' data-acid='" . $row['auto_id'] . "'></option>";
                                            }
                                            ?>
                                     </datalist>
                                     <input type="hidden" name="loom_id" id="loom_id">
                                 </div>
                                 <div class="form-group">                            
                                     <label for="iss_location">From:</label>
                                        <input  onkeypress="handleEnterKey(event, 'iss_location2')" list="iss_locations" name="iss_location" id="iss_location" class="form-control" placeholder="Select Location" required>
                                        <datalist id="iss_locations">
                                            <?php
                        
                                                $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                                while ($row = $sql->fetch_assoc()) {
                                                    echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                                }
                                                ?>
                                        </datalist>
                                     <input type="hidden" name="loc_id" id="loc_id">

                                 </div>
                                 <div class="form-group">
                                     <label for="iss_location2">To:</label>
                                     <input  onkeypress="handleEnterKey(event, 'section3')" list="iss_location2s" name="iss_location2" id="iss_location2" class="form-control" placeholder="Select Where" required>
                                     <datalist id="iss_location2s">
                                         <?php
                                            $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                            }
                                            ?>
                                     </datalist>
                                     <input type="hidden" name="loc_id2" id="loc_id2">

                                 </div>
                                 <!-- <div class="form-group">
                                    <label for="dyer_nam">Dyer Name</label>
                                    
                                        <input type="text" list="twisterlist" class="form-control" id="dyer_nam" name="dyer_nam" placeholder="" onkeydown="handleEnterKey(event, 'iss_itm_nam')">
                                        <datalist id="twisterlist">

                                            <?php
                                            // $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                            // while ($row = $sql->fetch_assoc()) {
                                            //     echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                            // }
                                            ?>
                                        </datalist>

                                        <input type="hidden" class="form-control" id="dyer_id" name="dyer_id">
                                
                                </div> -->
                                 <!-- <div class="form-group" id="weft_focus">
                                     <label for="iss_weft">Weft</label>
                                     <input list="iss_wefts" name="iss_weft" id="iss_weft" class="form-control" placeholder="Select Unit">
                                     <datalist id="iss_wefts">
                                         <?php
                                            // $sql = mysqli_query($con, "SELECT * FROM inward where tbl_type='section2' order by weft_batch_no");
                                            // while ($row = $sql->fetch_assoc()) {
                                            //     // echo "<option class='text-uppercase' value='" . $row['weft_batch_no'] . "' data-acid='" . $row['reff_id'] . "'></option>";
                                            //     echo "<option value='" . trim($row['weft_batch_no']) . " ( " . trim($row['weft_wght']) . " )' data-id='" . $row['reff_id'] . "'> </option>";
                                            // }
                                            ?>
                                     </datalist>
                                     <input type="hidden" name="hidden_iss_weft" id="hidden_iss_weft">

                                 </div> -->
                             <!-- <div id="entry_table_div">
                                 <table id="entry_table">
                                        <thead>
                                           <tr>
                                                <th>Warp No</th>
                                                <th>Type</th>
                                                <th>Ply</th>
                                                <th>Section</th>
                                                <th>Weight</th>
                                                <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody id="sep_iss_body">
                                            <tr class="trow">
                                                
                                                <td>
                                                    <input  onkeypress='handleEnterKey(event, "border_nam")' list="iss_warps" name="iss_warp" id="iss_warp" class="form-control" placeholder="Select Unit">
                                                    <datalist id="iss_warps">
                                                        <?php
                                                            $sql = mysqli_query($con, "SELECT * FROM sep where position = 'NO' order by warp_no");
                                                            while ($row = $sql->fetch_assoc()) {
                                                                echo "<option class='text-uppercase' value='" . $row['warp_no'] . "' data-acid ='" . $row['warp_no'] . "'></option>";
                                                                // echo "<option value='WARPID" . trim($row['save_date']) . "   weight (" . trim($row['warp_wght']) . " )  " . trim($row['warp_ply']) . "ply' data-id='" . $row['reff_id'] . "'> </option>";
                                                            }
                                                            ?>
                                                    </datalist>
                                                    <input type="hidden" name="hidden_iss_warp" id="hidden_iss_warp">
                                                </td>
                                                <td>
                                                    <input onkeypress='handleEnterKey(event, "ply")' list="borders_nam" class="form-control" type="text" name="border_nam" id="border_nam">
                                                    <datalist id="borders_nam">
                                                        <?php
                                                            $sql = mysqli_query($con, "SELECT * FROM saree_union order by id");
                                                            while ($row = $sql->fetch_assoc()) {
                                                                // echo "<option class='text-uppercase' value='" . $row['weft_batch_no'] . "' data-acid='" . $row['reff_id'] . "'></option>";
                                                                echo "<option value='" . trim($row['saree_parts']) . "' data-id='" . $row['id'] . "'> </option>";
                                                            }
                                                            ?>
                                                    </datalist>
                                                    <input type="hidden" name="saree_union" id="saree_union">
                                                </td>
                                                <td>
                                                <input onkeypress='handleEnterKey(event, "section")' class="form-control" type="text" name="ply" id="ply">
                                                </td>
                                                <td>
                                                <input onkeypress='handleEnterKey(event, "wght")' class="form-control" type="text" name="section" id="section">
                                                </td>
                                                <td>
                                                <input onkeypress='handleEnterKey(event, "row_ok")' class="form-control" type="number" name="wght" id="wght">
                                                </td>
                                                <td>
                                                  <button  id="row_ok" class="btn btn-primary" type="submit">Save</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                 </table>                                                                    
                            </div> -->

                        </div>
                        <div id="entry_table_div2">
                                 <table id="entry_table2">
                                        <thead>
                                           <tr>
                                                <th colspan="2" style="background:none;">                                    
                                                     <input type="text" class="form-control fw-bold text-success shadow-none" readonly value="<?php echo $warp_dyetag; ?>" name="booking_id" id="booking_id" required onkeydown="handleEnterKey(event, 'check_in_date')">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Warp No</th>
                                                <th>Type</th>
                                                <!--  -->
                                                <th>Yard</th>
                                                <th>No of Saree</th>
                                                <th>Mozham</th>
                                                <th>One Section</th>
                                                <th>Count</th>
                                                <!--  -->
                                                <th>Ply</th>
                                                <th>Iss Section</th>
                                                <th>Separate Sec</th>
                                                <th>Ret Section</th>
                                                <th>Iss Weight</th>
                                                <th>Separate wght</th>
                                                <th>Ret Weight</th>
                                                <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody id="sep_iss_body2">
                                            <tr class="trow2">
                                                
                                                <td>
                                                 <input readonly onkeypress='handleEnterKey(event, "border_nam2")' type="text" name="warp_no2[]" id="warp_no2">
                                                </td>
                                                <td>
                                                    <input readonly onkeypress='handleEnterKey(event, "ply2")' list="borders_nam2" type="text" name="border_nam2[]" id="border_nam2">
                                                    <datalist id="borders_nam2">
                                                        <?php
                                                            $sql = mysqli_query($con, "SELECT * FROM saree_union order by id");
                                                            while ($row = $sql->fetch_assoc()) {
                                                                // echo "<option class='text-uppercase' value='" . $row['weft_batch_no'] . "' data-acid='" . $row['reff_id'] . "'></option>";
                                                                echo "<option value='" . trim($row['saree_parts']) . "' data-id='" . $row['id'] . "'> </option>";
                                                            }
                                                            ?>
                                                    </datalist>
                                                    <input type="hidden" name="saree_union2[]" id="saree_union2">
                                                </td>
                                                               <!--  -->
                                                               <td>
                                                <input class="form-control" type="text" name="yard2[]" id="yard2">
                                                </td>
                                                <td>
                                                <input class="form-control" type="text" name="no_saree2[]" id="no_saree2">
                                                </td>
                                                <td>
                                                <input class="form-control" type="text" name="muzham2[]" id="muzham2">
                                                </td>
                                                <td>
                                                <input class="form-control" type="text" name="one_section2[]" id="one_section2">
                                                </td>
                                                <td>
                                                <input class="form-control" type="text" name="s_count2[]" id="s_count2">
                                                </td>
                                                <!--  -->
                                                <td>
                                                <input readonly onkeypress='handleEnterKey(event, "section2")' type="text" name="ply2[]" id="ply2">
                                                </td>
                                                <td>
                                                <input readonly onkeypress='handleEnterKey(event, "wght2")' type="text" class="section2" name="section2[]" id="section2">
                                                </td>
                                                <td>
                                                <input class="form-control text-primary fw-bold section3"required oninput="minus_inputs1()"  onkeypress='handleEnterKey(event, "wght3")' type="text" name="section3[]" id="section3">
                                                </td>
                                                <td>
                                                <input readonly onkeypress='handleEnterKey(event, "wght2")' type="text" class="section4" name="section4[]" id="section4">
                                                </td>
                                                <td>
                                                <input readonly onkeypress='handleEnterKey(event, "row_ok")' type="number" class="wght2" name="wght2[]" id="wght2">
                                                </td>
                                                <td>
                                                <input class="form-control text-primary fw-bold wght3"required oninput="minus_inputs2()" onkeypress='handleEnterKey(event, "save")' type="number" name="wght3[]" id="wght3">
                                                </td>
                                                <td>
                                                <input readonly onkeypress='handleEnterKey(event, "row_ok")' type="number" class="wght4" name="wght4[]" id="wght4">
                                                </td>
                                                <td>
                                                  <button id="row_delete" class="btn btn-danger" type="button">x</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                 </table>                                                                    
                            </div>
                                 
                                         
                                      <div class="buttonss mt-3">
                                    <!-- <button type="button" >Save</button> -->
                                    <button  id="save" class="btn btn-primary"type="submit">Save</button>
                                    <button type="button" onclick="location.reload()">New</button>
                                    <button type="button" id="home">Home</button>
                                 </div>
                                </div>
                         
                     </form>
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
     <script src="js/separation_ret.js"></script>
     <script src="js/date_time.js"></script>
    
     <!-- attach form js code here  -->
 </body>

 </html>