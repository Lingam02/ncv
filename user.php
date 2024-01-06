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
  $user_type = $_POST["user_type"];
  $user_name = $_POST["userName"];
  $password = $_POST["password"];





  $sql = "INSERT INTO acct (ac_nam, user_nam, pwd,ac_grp_nam) VALUES (' $ac_name', '$user_name', '$password','$user_type')";

  if ($con->query($sql) === TRUE) {


    $last_id = mysqli_insert_id($con);

    $sql = "update acct set ac_id='$last_id' where id='$last_id'";
    $con->query($sql);


    //echo "New record created successfully";
    header('Location:user.php?success=1'); // Redirect before closing the connection
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $con->$error;
  }
}
include "main/headlinks.php";
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

  <!-- attach form css link here ends-->

  <script>
  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    if (success === '1') {
      const snackbar = document.getElementById("snackbar");
      snackbar.textContent = "User Created Successfully";
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
            <h2>User Creation</h2>
            <form id="userCreationForm" action="" method="post" autocomplete="off">
              <div class="form-group">
                <label for="user_type">User Type</label>
                <div class="d-flex ">
                <input type="radio" id="WORKER" value="WORKER" name="user_type">
                <label for="WORKER" class="me-3">WORKER</label>
                <input type="radio" id="WEAVER" value="WEAVER" name="user_type">
                <label for="WEAVER" class="me-3">WEAVER</label>

                <input type="radio" id="ADMIN" value="ADMIN" name="user_type">
                <label for="ADMIN" class="me-3">ADMIN</label>
                <input type="radio" id="DYER" value="DYER" name="user_type">
                <label for="DYER">DYER</label>
                </div>

                
              </div>
              <div class="form-group">
                <label for="workerName">Name</label>
                <input type="text" id="workerName" name="workerName" onkeydown="handleEnterKey(event, 'userName')">
                <span class="error" id="workerNameError">Worker Name Is Required</span>
                <span class="error" id="workerDuplicateError">Worker Name Is Duplicate</span>
              </div>
              <div class="form-group">
                <label for="userName">User Id</label>
                <input type="text" id="userName" name="userName" onkeydown="handleEnterKey(event, 'password')">
                <span class="error" id="userNameError">User Name Is Required</span>
                <span class="error" id="userDuplicateError">UserName Already Exist!</span>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" onkeydown="handleEnterKey(event, 'save')">
                <span class="error" id="passwordError">Password Is Required</span>
              </div>
              <div class="form-group buttons">
                <button type="submit" id="save">Create User</button>
                <a href="admin.php"><button type="button" class="me-0">Home</button></a>
              </div>
            </form>
          </div>

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

  <script src="js/user.js"></script>

  <!-- attach form js code here  -->
</body>

</html>