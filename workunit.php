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

  $ac_name = $_POST["workerName"];
  $n_val = $_POST["blockid"];
  $maj_nam = $_POST["category"];
  $ifloom = $_POST["loomval"];
  if ($ac_name !== "") {
    $sql = "INSERT INTO cnf (nam, id, cls,n_val,maj_nam,val) VALUES ('$ac_name', 'WRK_UNIT', 'WRK_UNIT', '$n_val','$maj_nam','$ifloom')";

    if ($con->query($sql) === TRUE) {
      echo "New record created successfully";
      header('Location:workunit.php?success=1'); // Redirect before closing the connection
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $con->$error;
    }
  }

  $con->close();
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
  <link rel="stylesheet" href="css/user.css">
  <!-- attach form css link here ends-->

  <script>
  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    if (success === '1') {
      const snackbar = document.getElementById("snackbar");
      snackbar.textContent = "Unit Created Successfully";
      snackbar.className = "show";
      setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
        // Remove the 'success' query parameter from the URL
        const url = new URL(window.location.href);
        url.searchParams.delete('success');
        window.history.replaceState({}, document.title, url);
      }, 2000);
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
       <div class="body">
       <div class="container-custom">
          <h2>Unit Creation</h2>
          <form id="userCreationForm" action="" method="post" autocomplete="off">
            <div class="form-group">
              <label for="Unit Type">Unit Type</label>
              <div class="d-flex">
                <div class="d-flex me-4">
                  <input class="me-1" type="radio" name="unittype" value="Loom" id="Looms">
                  <label for="Looms">Looms</label>
                </div>
                <div class="d-flex me-4">
                  <input class="me-1" type="radio" name="unittype" value="Bobin" id="Bobin">
                  <label for="Bobin">Bobin</label>
                </div>
                
                <div class="d-flex me-4">
                  <input class="me-1" type="radio" name="unittype" value="Pirn" id="Pirn">
                  <label for="Pirn">Pirn</label>
                </div>
                <div class="d-flex me-4">
                  <input class="me-1" type="radio" name="unittype" value="Others" id="Others">
                  <label for="Others">Others</label>
                </div>
               
              </div>

            </div>
            <div class="form-group">

              <label for="category">Block Name</label>
              <input type="text" list="cat_options" id="category" name="category" class='text-uppercase' placeholder="Type to select category...">
              <datalist id="cat_options">
                <?php

                $sql = "SELECT distinct auto_id, nam FROM cnf where cls='BLOCK' ORDER BY nam";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                  }
                }
                ?>
              </datalist>
             
            </div>

            <div class="form-group">
              <label for="workerName">Unit Name</label>
              <input class="text-uppercase" type="text" id="workerName" name="workerName" required>
            </div>
            <div id="snackbar"></div>
            <div class="form-group buttons">
              <button type="submit">Create Unit</button>
              <a href="admin.php"><button type="button">Home</button></a>
            </div>
            <input type="hidden" id="blockid" name="blockid">
            <input type="hidden" id="loomval" name="loomval">
          </form>

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

  <script src="js/workunit.js"></script>
  <!-- attach form js code here  -->
</body>

</html>