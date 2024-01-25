  <!-- attach php code here -->
  <?php
  include "config.php";
  // Check if 'uname' session variable is not set or empty
  if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit(); // Ensure that code stops executing after the redirect
}

  
  

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $loc_id = $_POST['loc_id'];
    $loc_nam = $_POST['loc_nam'];
    $sql = "INSERT INTO stock_stores (loc_nam)  VALUES ('$loc_nam')";

    if ($con->query($sql) === TRUE) {
      // Redirect to createblock.php with a success message
      header('Location: stores.php?success=1');
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $con->$error;
    }
  }
  $con->close();
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
      .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
      }

      .modal-content {
        width: 400px;
        margin: 10% auto;
        background: #fff;
        position: relative;
        text-align: center;
        padding: 20px;
      }

      .close {
        font-size: 22px;
        position: absolute;
        top: 3px;
        right: 3px;
        cursor: pointer;
      }
    </style>
    <!-- attach form css link here ends-->

    <script>
  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    if (success === '1') {
      const snackbar = document.getElementById("snackbar");
      snackbar.textContent = "Store Created successfully";
      snackbar.className = "show";
      setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
        // Remove the 'success' query parameter from the URL
        const url = new URL(window.location.href);
        url.searchParams.delete('success');
        window.history.replaceState({}, document.title, url);
      }, 3000);
    }
  }
</script>

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
          <div class="container mt-4">
    <h2>Create Stock Stores</h2>
    <form action="" method="POST">
      
    
        <input type="hidden" class="form-control" id="loc_id" name="loc_id" required>

      <div class="form-group">
        <label for="loc_nam">Location Name:</label>
        <input type="text" class="form-control" id="loc_nam" name="loc_nam" required>
      </div>
      
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
          <!-- attach form container here ends -->

        </div>
      </div>

      <!-- /#page-content-wrapper ends-->
    </div>
    <div id="snackbar"></div>
    <!-- footer starts -->
    <?php
    include_once "main/footer.php";
    ?>
    <!-- footer ends -->

    <!-- attach form js code here  -->

    <!-- attach form js code here  -->
  </body>

  </html>