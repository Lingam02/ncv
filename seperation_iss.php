 <!-- attach php code here -->
 <?php
    include "config.php";
    // Check if 'uname' session variable is not set or empty
    if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
        // Redirect to the login page
        header("Location: index.php");
        exit(); // Ensure that code stops executing after the redirect
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
     <style>
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
             <!-- navbar starts -->
             <?php
                include_once "main/navbar.php";
                ?>
             <!-- navbar ends -->
             <div class="container-fluid px-4">
                 <!-- attach form container here starts -->
                 <div class="body">
                     <form id="form" action="" method="post">
                         <div class="container_seperation">
                             <h4 id="heading" class="m-4">Transfer To Seperation</h4>
                             <!-- <div class="select_type">
                                 <div class="form-group">
                                     <label>Select Type</label>
                                     <select name="txn_type" id="txn_type" required>
                                         <option value="">Select</option>
                                         <option value="ISS">Issue</option>
                                         <option value="RET">Return</option>
                                     </select>

                                 </div>
                             </div> -->
                             <div id="issue_div">
                                 <div class="form-group">
                                     <label for="iss_date">Issue Date</label>
                                     <input type="date" name="iss_date" id="iss_date" class="form-control">

                                 </div>
                                 <div class="form-group">
                                     <label for="iss_fromloc">From:</label>
                                     <input list="iss_fromlocs" name="iss_fromloc" id="iss_fromloc" class="form-control" placeholder="Select Where" required>
                                     <datalist id="iss_fromlocs">
                                         <?php
                                            $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores  order by loc_nam");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option class='text-uppercase' value='" . $row['loc_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                            }
                                            ?>
                                     </datalist>
                                 </div>

                                 <div class="form-group">
                                     <label for="iss_unitname">To / Unit:</label>
                                     <input list="iss_unitnames" name="iss_unitname" id="iss_unitname" class="form-control" placeholder="Select Unit" required>
                                     <datalist id="iss_unitnames">
                                         <?php
                                            $sql = mysqli_query($con, "SELECT nam,auto_id,maj_nam FROM cnf where cls='WRK_UNIT' and val!='Loom'order by nam");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option value='" . trim($row['nam']) . " ( " . trim($row['maj_nam']) . " )' data-id='" . $row['auto_id'] . "'> </option>";
                                            }
                                            ?>
                                     </datalist>
                                 </div>
                                 <!-- <div class="form-group">
                                     <label for="iss_wght">Item Weight</label>
                                     <input type="number" name="iss_wght" id="iss_wght">
                                 </div> -->
                                 <div class="form-group" id="warp_focus">
                                     <label for="iss_warp">Warp</label>
                                     <input list="iss_warps" name="iss_warp" id="iss_warp" class="form-control" placeholder="Select Unit">
                                     <datalist id="iss_warps">
                                         <?php
                                            $sql = mysqli_query($con, "SELECT DISTINCT reff_id FROM inward where tbl_type='section1' order by reff_id");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo "<option class='text-uppercase' value='WP-" . $row['reff_id'] . "' data-id='" . $row['reff_id'] . "'></option>";
                                                // echo "<option value='WARPID" . trim($row['save_date']) . "   weight (" . trim($row['warp_wght']) . " )  " . trim($row['warp_ply']) . "ply' data-id='" . $row['reff_id'] . "'> </option>";
                                            }
                                            ?>
                                     </datalist>
                                     <input type="hidden" name="hidden_iss_warp" id="hidden_iss_warp">
                                 </div>

                                 <div class="form-group" id="weft_focus">
                                     <label for="iss_weft">Weft</label>
                                     <input list="iss_wefts" name="iss_weft" id="iss_weft" class="form-control" placeholder="Select Unit">
                                     <datalist id="iss_wefts">
                                         <?php
                                            $sql = mysqli_query($con, "SELECT * FROM inward where tbl_type='section2' order by weft_batch_no");
                                            while ($row = $sql->fetch_assoc()) {
                                                // echo "<option class='text-uppercase' value='" . $row['weft_batch_no'] . "' data-acid='" . $row['reff_id'] . "'></option>";
                                                echo "<option value='" . trim($row['weft_batch_no']) . " ( " . trim($row['weft_wght']) . " )' data-id='" . $row['reff_id'] . "'> </option>";
                                            }
                                            ?>
                                     </datalist>
                                     <input type="hidden" name="hidden_iss_weft" id="hidden_iss_weft">

                                 </div>
                                
                             </div>
                             <table id="modaltable">
                                 <thead>
                                     <tr>
                                         <th>Ply</th>
                                         <th>Warp Weight</th>
                                         <th>Section</th>
                                         <th>Count</th>
                                     </tr>
                                 </thead>
                                 <tbody id="tbody">
                                     <tr>
                                         <td><input class="form-control" type="text" name="ply[]" value="" readonly></td>
                                         <td><input class="form-control" type="text" name="warp_wghts[]" value="" readonly></td>
                                         <td><input class="form-control" type="text" name="sections[]" value="" readonly></td>
                                         <td><input class="form-control" type="text" name="count[]" value="" readonly></td>
                                     </tr>
                                 </tbody>
                             </table>

                             <div class="buttons">
                                 <button type="submit" onclick="save()">Save</button>
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
     <script>
         document.getElementById('iss_warp').addEventListener('focus', function dis_none_weft() {
             document.getElementById('weft_focus').style.display = 'none';

         })
         document.getElementById('iss_weft').addEventListener('focus', function dis_none_warp() {
             document.getElementById('warp_focus').style.display = 'none';

         })
         //============ script for date set default in input field visible starts===============
         window.onload = function() {
             var currentDate = new Date();
             var day = currentDate.getDate();
             var month = currentDate.getMonth() + 1; // Month is zero-based
             var year = currentDate.getFullYear();

             // Format the date as YYYY-MM-DD (ISO format)
             var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');

             // Set the value attribute of the input field
             document.getElementById('iss_date').value = formattedDate;
             //  document.getElementById('ret_date').value = formattedDate;

         };

         //  document.getElementById('return_div').style.display = 'none';

         //  document.getElementById('txn_type').addEventListener('change', function() {

         //      console.log(document.getElementById('txn_type').value);
         //      if (document.getElementById('txn_type').value == "ISS") {
         //          document.getElementById('heading').innerHTML = 'Issue to Seperation';
         //          document.getElementById('issue_div').style.display = 'block';
         //          document.getElementById('return_div').style.display = 'none';
         //      } else if (document.getElementById('txn_type').value == "RET") {
         //         document.getElementById('heading').innerHTML = 'Return From Seperation';

         //          document.getElementById('issue_div').style.display = 'none';
         //          document.getElementById('return_div').style.display = 'block';
         //      }

         //  })
         document.getElementById('home').addEventListener('click', function() {
             window.location = 'admin.php';
         })
         // function save() {
         //     document.getElementById('form').submit();

         // }         //=============== script for date ends ================= 
     </script>
     <!-- attach form js code here  -->
 </body>

 </html>