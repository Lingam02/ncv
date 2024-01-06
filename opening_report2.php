 <!-- attach php code here -->
 <?php
    include "config.php";
    // Check if 'uname' session variable is not set or empty
    if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
        // Redirect to the login page
        header("Location: index.php");
        exit(); // Ensure that code stops executing after the redirect
    }

  

    $sql2 = "SELECT * FROM tbl_opening where itm_type = 'BS' and tbl_type = 'WEFTBS';"; // Default query to retrieve all users
    $result2 = $con->query($sql2);

    $sql3 = "SELECT * FROM tbl_opening where itm_type = 'BS' and tbl_type = 'ZARIBS';"; // Default query to retrieve all users
    $result3 = $con->query($sql3);

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
     <link rel="stylesheet" href="css/opening_report1.css">
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
               

                 <div class="printonly">
                 <a href="admin.php"><button id="print" class="non-print">Home</button></a>
                 <button onclick="printTableContainer()" id="print" class="non-print">Print</button>
                     <!-- attach form container here starts -->

                
                     <div class="tbl_2">
                         <table>
                             <thead>
                                 <tr>
                                     <td class="tbl_heading" colspan="6">Weft Opening Stock in grams</td>
                                 </tr>
                                 <tr>
                                     <th>S.NO</th>
                                     <th>Location</th>
                                     <th>Bobin Id</th>
                                     <th>Wept Colour</th>
                                     <th>Wept Weight</th>
                                     <th>Wept Qty</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($result2->num_rows > 0) {
                                        $serialNumber = 1; // Initialize the serial number counter
                                        while ($row = $result2->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $serialNumber . "</td>"; // Serial number column
                                            echo "<td>" . $row["loc_name"] . "</td>";
                                            echo "<td>" . $row["reff_nam"] . "</td>";
                                            echo "<td>" . $row["col_nam"] . "</td>";
                                            echo "<td>" . $row["wght"] . "</td>";
                                            echo "<td>" . $row["qty"] . "</td>";

                                            echo "</tr>";
                                            $serialNumber++; // Increment serial number for the next row
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>0 results</td></tr>";
                                    }
                                    ?>
                             </tbody>
                         </table>


                     </div>
                     <div class="tbl_3">
                         <table>
                             <thead>
                                 <tr>
                                     <td class="tbl_heading" colspan="6">Zari Opening Stock in grams</td>
                                 </tr>
                                 <tr>
                                     <th>S.NO</th>
                                     <th>Location</th>
                                     <th>Bobin Id</th>
                                     <th>Zari Name</th>
                                     <th>Zari Weight</th>
                                     <th>Wept Qty</th>

                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($result3->num_rows > 0) {
                                        $serialNumber = 1; // Initialize the serial number counter
                                        while ($row = $result3->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $serialNumber . "</td>"; // Serial number column
                                            echo "<td>" . $row["loc_name"] . "</td>";
                                            echo "<td>" . $row["reff_nam"] . "</td>";
                                            echo "<td>" . $row["itm_nam"] . "</td>";
                                            echo "<td>" . $row["wght"] . "</td>";
                                            echo "<td>" . $row["qty"] . "</td>";

                                            echo "</tr>";
                                            $serialNumber++; // Increment serial number for the next row
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>0 results</td></tr>";
                                    }
                                    ?>
                             </tbody>
                         </table>


                     </div>
                     <!-- attach form container here ends -->

                 </div>
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
         function printTableContainer() {
             var content = document.querySelector('.printonly').innerHTML;
             var printWindow = window.open('', '_blank');
             printWindow.document.open();
             printWindow.document.write('<html><head><title>Print</title><link rel="stylesheet" href="css/opening_report1.css"></head><body>' + content + '</body></html>');
             printWindow.document.close();
             printWindow.print();
              // Close the print window/tab after printing
    printWindow.setTimeout(function () {
        printWindow.close();
    }, 1000); // Adjust the delay if needed (in milliseconds)
         }
     </script>

     <!-- attach form js code here  -->
 </body>

 </html>

 <?php
    $con->close();
    ?>