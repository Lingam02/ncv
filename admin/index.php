 <!-- attach php code here -->
 <?php
  include "config.php";
  // Check if 'uname' session variable is not set or empty
  if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    // Redirect to the login page
    header("Location: ../index.php");
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
         <div class="row">
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
           </div>
           <div class="col-lg-4">
             <div class="card shadow mb-3">
               <div class="card-body">
                 Location 1
               </div>
             </div>
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
   <script src="js/main.js"></script>

   <!-- attach form js code here  -->
 </body>

 </html>