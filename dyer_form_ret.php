<?php
include "config.php";
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
    $tnx_id = "DYE-RET";
    $tnx_type = "WPRET";
    $itm_type = "WARP";

    $dyer_nam = $_POST['dyer_nam'];
    $dyer_id = $_POST['dyer_id'];

    $loc_nam = $_POST['fromloc'];
    $loc_id = $_POST['fromloc_id'];

    $itm_nam = $_POST['iss_itm_nam'];
    $itm_id = $_POST['iss_itm_id'];

    $tag_no =  $_POST['warp_tag_no'];
    $loom_id =  $_POST['hidden_loom_id'];

    $descript = $_POST['iss_desc'];
    $wght = $_POST['iss_wght'];
// ------------------------------------------
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
//-------------------------------------------
    $col_names = $_POST['col_names'];

    $waste_wght = $_POST['waste_wght'];

    if (!empty($wght)) {  
         //--------------------------------  DELETE OLD VALUES -------------
      
         // Loop through the submitted data and insert each row into the database
       
            if ($wght != "") {
                $sql = "INSERT INTO dyer_hd (tnx_id, tnx_type, itm_type, dyer_nam, dyer_id,loc_nam, loc_id,date, time, tag_no, descript, wght, itm_nam,loom_id,waste_wght) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                // $new_warp_no = $warp_no[$key].'/'.($key+1);
                mysqli_stmt_bind_param($stmt, "sssssssssssdssd", $tnx_id,$tnx_type,$itm_type,$dyer_nam, $dyer_id,$loc_nam, $loc_id, $save_date, $save_time, $tag_no,$descript,$wght,$itm_nam,$loom_id,$waste_wght);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                // $last_id1 = mysqli_insert_id($con);
            }
        }
      
      
        $inw = "inw";
        if (!empty($wght)) {
            // Loop through the submitted data and insert each row into the database
         
                if ($wght> 0.00) {
                    $wght1 = -1 * ($wght);
        
                    $sql = "INSERT INTO warp_stock (tnx_id, reff_id, doc_id, date, time, inw, wght, wght1) /*10*/
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, "ssssssdd", $tnx_id, $tag_no,$loom_id, $save_date, $save_time, $inw,$wght,$wght1);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
            }
            if (!empty($col_names)) {
                // Loop through the submitted data and insert each row into the database
                for ($keys = 0; $keys < count($col_names); $keys++) {
                    if ($col_names[$keys] != "") {
                        $sql = "INSERT INTO det_cnf (tnx_id, tnx_type, tag_no, color, date, time) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, "ssssss", $tnx_id, $tnx_type, $tag_no, $col_names[$keys], $save_date, $save_time);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                    }
                }
            }
            
// First table INSERT
$query1 = "INSERT INTO sep_ret (tnx_id, yard, no_saree, muzham, one_section, s_count, date, time, new_warp_no, tnx_type, warp_no, loc_id, typ, loc_nam, loom_id, ply, section, wght,position, iss_section, iss_wght, bal_section, bal_wght) 
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt1 = mysqli_prepare($con, $query1);
if ($stmt1) {
    for ($key = 0; $key < count($border_nam); $key++) {
        if ($border_nam[$key] !== "") {
            if (!empty($warp_no[$key])) { // Check if $warp_no[$key] is not empty
                $new_warp_no = $warp_no[$key] . '/D' . ($key + 1);
            } else {
                // Handle the case when $warp_no[$key] is empty or null
                // For example, you could set $new_warp_no to a default value or skip this iteration
                continue; // Skip this iteration of the loop
            }

            mysqli_stmt_bind_param($stmt1, "sssssdsssssssssdssssdsd", $tnx_id, $yard[$key], $no_saree[$key], $muzham[$key], $one_section[$key], $s_count[$key], $save_date, $save_time, $new_warp_no, $tnx_type, $warp_no[$key], $loc_id, $border_nam[$key], $loc_nam, $loom_id, $ply[$key], $section3[$key], $wght3[$key],$position, $section2[$key], $wght2[$key], $section4[$key], $wght4[$key]);
            mysqli_stmt_execute($stmt1);
        }
    }
    // echo "Details dyer det Saved successfully";
    header("location: dyer_form_ret.php");
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

    <!-- attach form css link here-->
    <link rel="stylesheet" href="css/dyer_form.css">
    <link rel="stylesheet" href="css/table_sep.css">
    <!-- <link rel="stylesheet" href="css/input.css"> -->
    <style>
table input{
    color:blue;
    font-weight:600;
}
#entry_table_div2{
    overflow:auto;
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
        <form id="form_1" action="" method="post" autocomplete="off">
            <!-- navbar starts -->
            <?php
            include_once "main/navbar.php";
            ?>
            <!-- navbar ends -->

            <div class="container-fluid">

                <!-- attach form container here starts -->
                <div class="container">
                        <h4 class="topic">Transfer to Dyeing Section</h4>
                        <div class="row">                               
                                <div class="col-sm-6">
                                    <label for="fromloc">From</label>
                                    <input list="fromlocs" name="fromloc" id="fromloc" class="form-control" placeholder="Select Where">
                                    <datalist id="fromlocs">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" name="fromloc_id" id="fromloc_id">
                                </div>
                                <div class="col-sm-6">
                                    <label for="to_loc">To</label>
                                    <input list="to_locs" name="to_loc" id="to_loc" class="form-control" placeholder="Select Where">
                                    <datalist id="to_locs">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" name="to_loc_id" id="to_loc_id">
                                </div>
                                <div class="col-sm-6">
                                    <label for="dyer_nam">Dyer Name</label>
                                  
                                        <input type="text" list="twisterlist" class="form-control" id="dyer_nam" name="dyer_nam" placeholder="" onkeydown="handleEnterKey(event, 'iss_itm_nam')">
                                        <datalist id="twisterlist">

                                            <?php
                                            $sql = mysqli_query($con, "SELECT ac_nam, ac_id FROM `acct`where ac_grp_nam ='DYER' ORDER BY `ac_nam`");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . $row['ac_nam'] . "' data-grpid='" . $row['ac_id'] . "'>";
                                            }
                                            ?>
                                        </datalist>

                                        <input type="hidden" class="form-control" id="dyer_id" name="dyer_id" placeholder="">
                                    
                                </div>
                                <input type="hidden" id="hidden_saree_no" name="hidden_saree_no">
                                <input type="hidden" id="hidden_loom_id" name="hidden_loom_id">
                                <div class="col-sm-6">
                                    <label for="iss_itm_nam">Issue Item Name</label>
                                   
                                        <input type="text" list="item_list" class="form-control" id="iss_itm_nam" name="iss_itm_nam" placeholder="" onchange="checkForSubstring2()" onkeydown="handleEnterKey(event, 'iss_desc')" onclick="this.select()">
                                        <datalist id="item_list">
                                            <option value="Kora Warp">Kora Warp</option>
                                            <option value="Kora Weft">Kora Weft</option>
                                            <?php
                                            // $sql = mysqli_query($con, "SELECT * FROM `itm` WHERE itm_sl='D/T' ORDER BY `itm_nam`");
                                            // while ($row = $sql->fetch_assoc()) {
                                            //     echo "<option value='" . $row['itm_nam'] . "' data-grpid='" . $row['itm_id'] . "'>";
                                            // }
                                            ?>
                                        </datalist> <input type="hidden" class="form-control" id="iss_itm_id" name="iss_itm_id" placeholder="">
                                    
                                    

                                </div>
                               
                               <div class="col-sm-6">
                                    <label for="warp_tag_no">Warp No</label>
                                  
                                        <input type="text" list="warp_tagids" class="form-control" id="warp_tag_no" name="warp_tag_no"  onkeydown="handleEnterKey(event, 'iss_desc')" onclick="this.select()">
                                        <datalist id="warp_tagids">
                                           
                                            <?php
                                           $sql = mysqli_query($con, "SELECT DISTINCT new_warp_no,new_warp_no FROM `sep_ret` WHERE tnx_type = 'WPSEPRET' ORDER BY `new_warp_no`");
                                           while ($row = mysqli_fetch_assoc($sql)) {
                                               echo "<option value='" . $row['new_warp_no'] . "' data-acid='" . $row['new_warp_no'] . "'>";
                                           }
                                           
                                            ?>
                                        </datalist> <input type="hidden" id="warp_tagid" name="warp_tagid">
                                    
                                </div>
                              
                            
                                 <div class="col-sm-6">
                                    <label for="iss_desc">Description</label>
                                    <input type="text" class="form-control" id="iss_desc" name="iss_desc" placeholder="" onkeydown="handleEnterKey(event, 'iss_wght')">                                   
                                </div>
                                <div class="col-sm-6">
                                    <label for="iss_wght">Weight</label>                                 
                                        <input type="number" class="form-control" id="iss_wght" name="iss_wght" placeholder="">                                
                                </div>    
                                <div class="col-sm-6">
                                <input type="checkbox" name="col_divopen" id="col_divopen" onchange="toggleDiv()"> 
                                    <div id="col_div" style="display:none;">                                  
                                  <table>
                                      <thead>
                                       <tr>
                                           <th>Select Colour</th>                                   
                                       </tr>
                                     </thead>
                                      <tbody id="tbl_body_col">
                                        <tr>
                                          <td>
                                                <input type="text" list="col_namess" class=".color-inpu" class="form-control" id="col_names" name="col_names[]" placeholder="SELECT COLOUR" onclick="this.select()">
                                                <datalist id="col_namess">

                                                    <?php
                                                    $sql = mysqli_query($con, "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam");
                                                    while ($row = $sql->fetch_assoc()) {
                                                        echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                                                    }
                                                    ?>
                                                </datalist>
                                                <input type="hidden" class="form-control" id="col_names_id" name="col_names_id">
                                                
                                           </td>                                   
                                       </tr>
                                     </tbody>
                                  </table>
                               </div>                           
                                </div>    
                            </div>
                        </div>

                        <div class="col-lg-12">
    <div id="entry_table_div2" class="mt-3">
                                 <table id="entry_table2">
                                        <thead>
                                          
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
                                                <th style="display:none">Iss Section</th>
                                                <th>Separate Sec</th>
                                                <th style="display:none">Ret Section</th>
                                                <th style="display:none">Iss Weight</th>
                                                <th>Separate wght</th>
                                                <th style="display:none">Ret Weight</th>
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
                                                <td style="display:none">
                                                <input readonly onkeypress='handleEnterKey(event, "wght2")' type="text" class="section2" name="section2[]" id="section2">
                                                </td>
                                                <td>
                                                <input class="form-control text-primary fw-bold section3" oninput="minus_inputs1()"  onkeypress='handleEnterKey(event, "wght3")' type="text" name="section3[]" id="section3">
                                                </td>
                                                <td style="display:none">
                                                <input readonly onkeypress='handleEnterKey(event, "wght2")' type="text" class="section4" name="section4[]" id="section4">
                                                </td>
                                                <td style="display:none">
                                                <input readonly onkeypress='handleEnterKey(event, "row_ok")' type="number" class="wght2" name="wght2[]" id="wght2">
                                                </td>
                                                <td>
                                                <input class="form-control text-primary fw-bold wght3" oninput="minus_inputs2()" onkeypress='handleEnterKey(event, "save")' type="number" name="wght3[]" id="wght3">
                                                </td>
                                                <td style="display:none">
                                                <input readonly onkeypress='handleEnterKey(event, "row_ok")' type="number" class="wght4" name="wght4[]" id="wght4">
                                                </td>
                                                <td>
                                                  <button id="row_delete" class="btn btn-danger" type="button">x</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                 </table>                                                                    
                            </div>
</div>
                        <!-- Submit button -->
                        <div class="row">
                            <div class="col-md-12">

                                <div class="right-side">
                                    <div class="buttons">
                                        <button type="submit" id='save'>Save</button>
                                        <button type="submit" id='update'>Update</button>
                                        <button type="button" onclick="window.location.reload();">New</button>
                                        <a href="admin.php"> <button type="button">Home</button></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Items From Dyers</h2>
                                <div class="input-div">
                                    <label for="dyer_nam_modal">Select Issued </label>

                                    <input list="twisterlists" type="text" name="dyer_nam_modal" id="dyer_nam_modal" placeholder="Type to search...">
                                    <datalist id="twisterlists">

                                        <?php
                                        $sql = mysqli_query($con, "SELECT  `id`, `iss_date`, `iss_time`, `dyer_id`, `dyer_nam`, 
                                            `iss_itm_id`, `iss_itm_nam`, `iss_desc`, `iss_wght` from `tbl_dyer` where tbl_status='ISS' order by id");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . $row['iss_date'] . $row['dyer_nam'] . "' data-grpid='" . $row['id'] . "'>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" id="hidden_dyer_id2" name="hidden_dyer_id2">
                                    <div class="btn btn-primary" onclick="fetch_dyer()">Proceed</div>
                                </div>


                            </div>
                        </div>

                        <div id="modaledit" class="modal">
                            <div class="modal-content">
                                <span class="close" id="close2">&times;</span>
                                <h2>Items From Dyer</h2>
                                <div class="input-div">
                                    <label for="dyer_nam_modal3">Select </label>

                                    <input list="twisterlists3" type="text" name="dyer_nam_modal3" id="dyer_nam_modal3" placeholder="Type to search...">
                                    <datalist id="twisterlists3">

                                        <?php

                                        $sql = mysqli_query($con, "SELECT  `id`, `iss_date`, `iss_time`, `dyer_id`, `dyer_nam`, 
                                        `iss_itm_id`, `iss_itm_nam`, `iss_desc`, `iss_wght` from `tbl_dyer` order by id desc");
                                        while ($row = $sql->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . $row['iss_date'] . $row['dyer_nam'] . $row['iss_wght'] . "' data-grpid='" . $row['id'] . "'>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" id="hidden_dyer_id3" name="hidden_dyer_id3">
                                    <div class="btn btn-primary" onclick="fetch_dyer_edit()">Proceed</div>

                                </div>


                            </div>
                        </div>
                      
                        <input type="hidden" id="dyerissid" name="dyerissid">

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

    <script src="js/dyer_form.js"></script>
    <!-- attach form js code here  -->
</body>

</html>