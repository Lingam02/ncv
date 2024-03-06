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
    $saree_parts = strtoupper($_POST['saree_parts']);



            if ($saree_parts != "") {
                $sql = "INSERT INTO saree_union (date, time, saree_parts) 
                VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $save_date, $save_time, $saree_parts);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                // $last_id1 = mysqli_insert_id($con);
            }
          
            // $sql = "UPDATE warp_details SET available = ? WHERE warp_no = ? ";
            // $stmt = mysqli_prepare($con, $sql);
            // mysqli_stmt_bind_param($stmt, "ss", $available, $warp_no);
            // mysqli_stmt_execute($stmt);
            // mysqli_stmt_close($stmt);
          header("location: saree_union.php");
        
       
   
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
  
    // Close the database connection
    // mysqli_close($con);
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
<link rel="stylesheet" href="../css/table.css">
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
                             <h4 id="heading" class="m-4">Create Types</h4>
                    
                
                                 <div class="form-group">
                                     <label for="iss_fromloc">Types</label>
       
                                     <input name="saree_parts" id="saree_parts" class="form-control text-uppercase" required>
                                   
                                 </div>
                                
                                <button type="submit" class="btn btn-primary ms-auto">Save</button>
                             <div id="entry_table_div">
                                <?php 
                              $sql = "SELECT `id`, `saree_parts`, `date`, `time` FROM `saree_union`";

                              // Execute the query
                              $result = mysqli_query($con, $sql);
                              
                              // Check if the query executed successfully
                              if ($result) {
                                  // Start generating the table
                                  echo "<table id='entry_table' class='mt-3'>
                                          <thead>
                                              <tr>
                                                  <th>S.No</th>
                                                  <th>Type</th>
                                                  <th>Date</th>
                                                  <th>Time</th>
                                              </tr>
                                          </thead>
                                          <tbody id='sep_iss_body'>";
                              
                                  // Counter for serial number
                                  $serial = 1;
                              
                                  // Loop through the result set and generate table rows
                                  while ($row = mysqli_fetch_assoc($result)) {
                                      echo "<tr>
                                              <td>$serial</td>
                                              <td>{$row['saree_parts']}</td>
                                              <td>{$row['date']}</td>
                                              <td>{$row['time']}</td>
                                            </tr>";
                                      $serial++;
                                  }
                              
                                  // Close the table
                                  echo "</tbody>
                                       </table>";
                              } else {
                                  // If the query fails, display an error message
                                  echo "Error: " . mysqli_error($con);
                              }
                              
                              // Close the database connection
                              mysqli_close($con);
                            ?>                                   
                            

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
<script>
//     function handleEnterKey(event, nextElementId) {
//     if (event.key === 'Enter') {
//       event.preventDefault();
//       const nextElement = document.getElementById(nextElementId);
//       nextElement.focus();
//       nextElement.select();
//     }
//   }
    </script>
     <!-- attach form js code here  -->
 </body>

 </html>