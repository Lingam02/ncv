 <!-- attach php code here -->
 <?php
    include "config.php";
    // Check if 'uname' session variable is not set or empty
    if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
        // Redirect to the login page
        header("Location: index.php");
        exit(); // Ensure that code stops executing after the redirect
    }




// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    date_default_timezone_set('Asia/Kolkata'); // Set the time zone to India Standard Time
    $save_time = $_POST['page_time']; // Get the current time in 24-hour format (e.g., 14:30:00)
    $save_date = $_POST['page_date'];
    // $save_time = date("H:i:s"); // Assuming you want to save the current time
    $tbl_type = "WPSEPISS";
   

    $loom_nam = $_POST['loom_nam'];
    $loom_id = $_POST['loom_id']; 

    $loc_nam = $_POST['iss_location'];
    $loc_id = $_POST['loc_id']; 

    $loc_nam2 = $_POST['iss_location2'];
    $loc_id2 = $_POST['loc_id2']; 

    $warp_no = $_POST['iss_warp']; 
    $border_nam = $_POST['border_nam']; 
    $ply = $_POST['ply']; 
    $section = $_POST['section']; 
    $wght = $_POST['wght']; 
   $no = 'NO';
   $available = '1';
 
    
      
  
        if (!empty($border_nam)) {
          // Loop through the submitted data and insert each row into the database
            if ($border_nam != "") {
                $sql = "INSERT INTO sep (date, time, tnx_type,warp_no, loc_id,typ, loc_nam, loom_id, loom_nam, ply,section,wght,loc_id2,loc_nam2,position) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "sssssssssssdiss", $save_date, $save_time, $tbl_type,$warp_no ,$loc_id,$border_nam, $loc_nam,$loom_id, $loom_nam, $ply,$section,$wght,$loc_id2,$loc_nam2,$no);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $last_id1 = mysqli_insert_id($con);
            }
          
            $sql = "UPDATE warp_details SET available = ? WHERE warp_no = ? ";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $available, $warp_no);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
          header("location: seperation_iss.php");
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
             background-color: #007bff;
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
                             <h4 id="heading" class="m-4">Transfer To Seperation</h4>
                          
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
                                     <input  onkeypress="handleEnterKey(event, 'iss_warp')" list="iss_location2s" name="iss_location2" id="iss_location2" class="form-control" placeholder="Select Where" required>
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
                             <div id="entry_table_div">
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
                                                            $sql = mysqli_query($con, "SELECT * FROM warp_details where tbl_type='section1' and available = 0 order by warp_no");
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
                            </div>

                        </div>
                        <div id="entry_table_div2">
                                 <table id="entry_table2">
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
                                        <tbody id="sep_iss_body2">
                                            <tr class="trow2">
                                                
                                                <td>
                                                 <input onkeypress='handleEnterKey(event, "border_nam2")' type="text" name="warp_no2[]" id="warp_no2">
                                                </td>
                                                <td>
                                                    <input onkeypress='handleEnterKey(event, "ply2")' list="borders_nam2" type="text" name="border_nam2[]" id="border_nam2">
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
                                                <td>
                                                <input onkeypress='handleEnterKey(event, "section2")' type="text" name="ply2[]" id="ply2">
                                                </td>
                                                <td>
                                                <input onkeypress='handleEnterKey(event, "wght2")' type="text" name="section2[]" id="section2">
                                                </td>
                                                <td>
                                                <input onkeypress='handleEnterKey(event, "row_ok")' type="number" name="wght2[]" id="wght2">
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
     <script src="js/separation_iss.js"></script>
     <script src="js/date_time.js"></script>
    
     <!-- attach form js code here  -->
 </body>

 </html>