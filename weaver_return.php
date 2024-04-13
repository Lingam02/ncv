<?php
include "config.php";

 // Check if 'uname' session variable is not set or empty
 if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

if (isset($_POST['submit'])) {
  // echo "data submited";
  $id = $_POST['wevname'];
  $r_slkwght = $_POST['silk_wght'];
  $r_toid = $_POST['to'];
  $r_toname = $_POST['selectedloc'];
  $r_slkqty = $_POST['silk_qty'];
  $r_zariwght = $_POST['jari_wght'];
  $r_zariqty = $_POST['jari_qty'];
  $finished_product = $_POST['finished_product'];

  date_default_timezone_set("Asia/Kolkata"); // Set the timezone to Asia/Kolkata
  $finish_date = date("Y-m-d H:i:s"); // Generate the current date and time in the specified format


  //   date_default_timezone_set("Asia/Kolkata"); // Set the timezone to Asia/Kolkata
  // $finish_date = date("Y-m-d H:i:s"); // Generate the current date and time in the specified format

  $sql = "UPDATE `wev_usage` SET  `txn_typ` = 'RET', `work_progress`=0, `work_end`= '$finish_date', `ret_to_id`='$r_toid',`ret_to_name`='$r_toname',
  `r_slkwght`='$r_slkwght',`r_slkqty`='$r_slkqty',`r_zariwght`='$r_zariwght',`r_zariqty`='$r_zariqty',
  `finished`=' $finished_product' WHERE id='$id'";

  if ($con->query($sql) === TRUE) {
    // echo "Update record successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $con->$error;

    $con->close();
    header('Location: admin.php');
  }
}

if (isset($_POST['log-out'])) {
  session_destroy();
  header('Location: index.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/weave.css">
  <title>AcPro Software</title>
</head>

<body>
<?php
    include_once "main/nav.php";
    ?>
  <div class="container-main bgcolor">
    <h2>Loom Return</h2>

    <form action="" method="post" autocomplete="off">

      <div class="form-group">

        <label for="wevname">Name:</label>
        <select name="wevname" id="wevname" class="selectpicker" value="" data-show-subtext="true" data-live-search="true" onchange="funfetch()">
          <option value="" selected disabled required>Select Worker</option>
          <?php
          $sql = mysqli_query($con, "SELECT work_nam,id FROM wev_usage where work_progress=1 order by work_nam");
          while ($row = $sql->fetch_assoc()) {
            $ac_nam = $row['work_nam'];
            echo "<option value='" . $row['id'] . "'>" . $row['work_nam'] . " </option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="loom">From Loom:</label>
        <input type="text" name="loom" id="loom">
      </div>
      <div class="form-group">
        <label for="to">To:</label>
        <select required name="to" id="to" class="selectpicker" data-show-subtext="true" data-live-search="true">
          <option value="" selected disabled>Select From Where</option>
          <?php

          $sql = mysqli_query($con, "SELECT id, loc_nam FROM stock_stores ORDER BY loc_nam");
          while ($row = $sql->fetch_assoc()) {
            echo "<option class='text-uppercase' value='" . $row['id'] . "' data-subtext='" . $row['loc_nam'] . "'>" . $row['loc_nam'] . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-row">

        <div class="form-group">
          <label for="silk">Silk:</label>
          <input type="text" name="silk" id="silk">
        </div>

        <div class="form-group">
          <label for="color">Colour:</label>
          <input type="text" name="color" id="color">
        </div>



      </div>

      <div class="form-row">

        <div class="form-group">
          <label for="silk_wght">Weight:</label>
          <input type="Number" id="silk_wght" name="silk_wght" required>
        </div>

        <div class="form-group">
          <label for="silk_qty">Qty:</label>
          <input type="Number" id="silk_qty" name="silk_qty" required>
        </div>

      </div>

      <div class="form-group">
        <label for="particulars">Description:</label>
        <input type="text" id="particulars" name="particulars">
      </div>
      <br>
      <div class="line-container"></div>
      <br>
      <div class="form-row">
        <div class="form-group">
          <label for="jari_wght">Zari Weight:</label>
          <input type="Number" id="jari_wght" name="jari_wght" required>
        </div>
        <div class="form-group">
          <label for="jari_qty">Zari Qty:</label>
          <input type="Number" id="jari_qty" name="jari_qty" required>
        </div>
      </div>

      <div class="form-group">
        <label for="finished_product">Finished Products</label>
        <input type="number" name="finished_product" id="finished_product" placeholder="INCHES" required>
      </div>
      <div class="form-group buttons">
        <button type="submit" name="submit" id="submit">Save</button>
        <a href="admin.php"> <button type="button">Home</button></a>
      </div>

      <input type="hidden" id="selectedName" name="selectedName">
      <input type="hidden" id="selectedunit" name="selectedunit">
      <input type="hidden" id="selecteditem" name="selecteditem">
      <input type="hidden" id="selectedcolor" name="selectedcolor">
      <input type="hidden" id="selectedzari" name="selectedzari">
      <input type="hidden" id="selectedloc" name="selectedloc">

  </div>
  </form>

  <script src="js/weaver_return.js"></script>
</body>