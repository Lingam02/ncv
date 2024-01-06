 <!-- attach php code here -->
 <?php
    include "config.php";
    // Check if 'uname' session variable is not set or empty
    if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
        // Redirect to the login page
        header("Location: index.php");
        exit(); // Ensure that code stops executing after the redirect
    }

    function generateBarcode($number)
    {
        // Convert the number to a string and pad it with leading zeroes
        $paddedNumber = str_pad($number, 5, '0', STR_PAD_LEFT);

        // Convert the number to a string and add a prefix 'A'
        $barcode = 'A' . $paddedNumber;

        return $barcode;
    }

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $loom_id = $_POST['loom_id'];
        $loom = $_POST['loom'];
        $weaver_id = $_POST['wev_nam_id'];
        $weaver = $_POST['wev_nam'];
        $itm_id = $_POST['itm_id'];
        $itm_nam = $_POST['itm_nam'];
        $warpNo = $_POST['warp_no'];
        $description = $_POST['desc'];
        $weight = $_POST['wght'];
        $date = $_POST['date'];

        $sql = "INSERT INTO itm_det (itm_id, nam, desc1, pdat, sold, itm_grp, sup_nam, sup_id, wght, hsn, vch_typ, cmp_id, swev_id, swev_nam) 
        VALUES ('$itm_id', '$itm_nam', '$description', '$date', '0', 'Saree', '$weaver', '$weaver_id', '$weight', '50072010', 'WEV_TXN', '1', '$loom_id', '$loom')";

        if (mysqli_query($con, $sql)) {
            $lastInsertedId = mysqli_insert_id($con);
            $tagnum = generateBarcode($lastInsertedId);

            $sql1 = "UPDATE itm_det SET id='$lastInsertedId', tag_num='$tagnum', pinv='$tagnum' WHERE auto_id='$lastInsertedId' AND cmp_id='1'";
            if (mysqli_query($con, $sql1)) {
                echo "Record inserted successfully";
                header('location:saree_rec.php');
                exit(); // Ensure that code stops executing after the redirect
            } else {
                echo "Error updating record: " . mysqli_error($con);
            }
        } else {
            echo "Error inserting record: " . mysqli_error($con);
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
                 <form id="form" action="" method="post" autocomplete="off">

                     <h4 class="text-center">Saree Receipt</h4>

                     <div class="row">
                         <div class="col-lg-6">
                             <label>Loom</label>
                             <input list="looms_list" type="text" id="loom" name="loom">
                             <datalist id="looms_list">
                                 <?php
                                    $sql = mysqli_query($con, "SELECT nam, auto_id, maj_nam FROM cnf WHERE cls='WRK_UNIT' AND val='Loom' ORDER BY nam");
                                    while ($row = $sql->fetch_assoc()) {
                                        // Ensure proper concatenation of strings and variables
                                        echo "<option value='" . trim($row['nam']) . " ( " . trim($row['maj_nam']) . ")' data-acid='" . $row['auto_id'] . "'></option>";
                                    }
                                    ?>
                             </datalist>

                             <input type="hidden" name="loom_id" id="loom_id">
                             <label>Weaver</label>
                             <input list="looms_list2" type="text" id="wev_nam" name="wev_nam">
                             <datalist id="looms_list2">
                                 <?php
                                    $sql = mysqli_query($con, "SELECT id,ac_nam FROM acct where ac_grp_nam='WORKER' OR ac_grp_nam='WEAVER' order by ac_nam");
                                    while ($row = $sql->fetch_assoc()) {
                                        $ac_nam = $row['ac_nam'];
                                        echo "<option class='text-uppercase' value='" . $row['ac_nam'] . "' data-acid='" . $row['id'] . "'></option>";
                                    }
                                    ?>
                             </datalist>
                             <input type="hidden" name="wev_nam_id" id="wev_nam_id">

                             <label>Warp No</label>
                             <input type="text" name="warp_no" id="warp_no">

                             <label>Description</label>
                             <input type="text" name="desc" id="desc">

                             <label>Weight</label>
                             <input type="number" name="wght" id="wght">

                         </div>
                         <div class="col-lg-6">
                             <label>Item Name</label>
                             <input list="looms_list3" type="text" id="itm_nam" name="itm_nam">
                             <datalist id="looms_list3">
                                 <?php
                                    $sql = mysqli_query($con, "SELECT itm_id,itm_nam FROM itm where it_typ='FIN' order by itm_nam");
                                    while ($row = $sql->fetch_assoc()) {
                                        $itm_nam = $row['itm_nam'];
                                        echo "<option class='text-uppercase' value='" . $row['itm_nam'] . "' data-acid='" . $row['itm_id'] . "'></option>";
                                    }
                                    ?>
                             </datalist>
                             <input type="hidden" name="itm_id" id="itm_id">

                             <label for="date">Date</label>
                             <input class="form-control" type="date" name="date" id="date">

                             <button type="button" id="save" class="btn mt-3 btn-success">Save</button>
                             <button type="button" id="new" onclick="location.reload()" class="btn mt-3 btn-primary">New</button>
                             <button type="button" id="home" class="btn mt-3 btn-primary">Home</button>
                         </div>
                     </div>
                 </form>
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
         //============ script for date set default in input field visible starts===============
         window.onload = function() {
             var currentDate = new Date();
             var day = currentDate.getDate();
             var month = currentDate.getMonth() + 1; // Month is zero-based
             var year = currentDate.getFullYear();

             // Format the date as YYYY-MM-DD (ISO format)
             var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');

             // Set the value attribute of the input field

             document.getElementById('date').value = formattedDate;

         };
         document.getElementById('home').addEventListener('click', function() {
             console.log('ok');
             window.location.href = "admin.php";
         });

         document.addEventListener('keypress', function(event) {
             if (event.key === 'Enter') {
                 event.preventDefault();
             }
         });
         document.getElementById('save').addEventListener('click', function save() {
             if (document.getElementById('loom').value == "" || document.getElementById('wev_nam').value == "" ||
                 document.getElementById('warp_no').value == "" || document.getElementById('desc').value == "" || document.getElementById('wght').value == "") {
                 alert('Please fill all the fields')
             } else {
                 document.getElementById('form').submit();
             }
         })



         //=============== script for date ends ================= 
         const loom = document.getElementById('loom');

         loom.addEventListener('change', function(event) {
             const selectedOption = event.target.value;
             const datalistOptions = document.getElementById('looms_list');

             const options = datalistOptions.getElementsByTagName('option');
             for (let i = 0; i < options.length; i++) {
                 const option = options[i];
                 const optionValue = option.value;

                 if (optionValue === selectedOption) {
                     var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

                     document.getElementById("loom_id").value = selectedAcid;

                     break;
                 }
             }
             var id = document.getElementById("loom_id").value;

             console.log("loom id-->", selectedAcid);
             console.log("loom value-->", loom.value);
         });
         const wev_nam = document.getElementById('wev_nam');

         wev_nam.addEventListener('change', function(event) {
             const selectedOption = event.target.value;
             const datalistOptions = document.getElementById('looms_list2');

             const options = datalistOptions.getElementsByTagName('option');
             for (let i = 0; i < options.length; i++) {
                 const option = options[i];
                 const optionValue = option.value;

                 if (optionValue === selectedOption) {
                     var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

                     document.getElementById("wev_nam_id").value = selectedAcid;

                     break;
                 }
             }
             var id = document.getElementById("wev_nam_id").value;

             console.log("wev_nam id-->", selectedAcid);
             console.log("wev_nam value-->", wev_nam.value);
         });
         const itm = document.getElementById('itm_nam');

         itm.addEventListener('change', function(event) {
             const selectedOption = event.target.value;
             const datalistOptions = document.getElementById('looms_list3');

             const options = datalistOptions.getElementsByTagName('option');
             for (let i = 0; i < options.length; i++) {
                 const option = options[i];
                 const optionValue = option.value;

                 if (optionValue === selectedOption) {
                     var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

                     document.getElementById("itm_id").value = selectedAcid;

                     break;
                 }
             }
             var id = document.getElementById("itm_id").value;

             console.log("itm id-->", selectedAcid);
             console.log("itm value-->", itm.value);
         });
         //---------------------------------------------------------------------------------------
     </script>
     <!-- attach form js code here  -->
 </body>

 </html>