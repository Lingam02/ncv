 <!-- attach php code here -->
 <?php
include "config.php";
// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: login.php");
  exit(); // Ensure that code stops executing after the redirect
}

$sql = "SELECT * FROM `acct` WHERE ac_grp_nam = 'WORKER' OR ac_grp_nam = 'WEAVER' OR ac_grp_nam = 'ADMIN' OR ac_grp_nam = 'DYER'"; // Default query to retrieve all users

$result = $con->query($sql);

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
<link rel="stylesheet" href="css/user_list.css">
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
      <div class="container">
<h4 class="text-center">User List</h4>
    <div class="input-div">
        <label for="searchName">Search by Name or Username:</label>
        <input type="text" id="searchName" name="searchName" oninput="searchUsers()">
    </div>

   <div class="flex">
   <div class="table-container">
        <table style="border: 1px solid #000; border-collapse: collapse;
    padding: 5px 10px;" id='userTable2'>
            <thead style="border: 1px solid #000; border-collapse: collapse;
    padding: 5px 10px;">
                <tr>
                    <th style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>S.No</th>
                    <th style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>Id</th>
                    <th style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>Name</th>
                    <th style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>Username</th>
                    <th style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'> <select name="usertype" id="usertype" onchange="filterUsersByType()">
                            <option value="select">Filter Usertype</option>
                            <option value="worker">Worker</option>
                            <option value="weaver">Weaver</option>
                            <option value="admin">Admin</option>
                        </select>
                    </th>
                    <th style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>Password</th>

                </tr>
            </thead>
            <tbody id='userTable1'>
                <?php
                if ($result->num_rows > 0) {
                    $serialNumber = 1; // Initialize the serial number counter
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>";
                        echo "<td style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>" . $serialNumber . "</td>"; // Serial number column
                        echo "<td style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>" . $row["ac_id"] . "</td>";
                        echo "<td style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>" . $row["ac_nam"] . "</td>";
                        echo "<td style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>" . $row["user_nam"] . "</td>";
                        echo "<td style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>" . $row["ac_grp_nam"] . "</td>";
                        echo "<td style='border: 1px solid #000; border-collapse: collapse;
                        padding: 5px 10px;'>" . $row["pwd"] . "</td>";
                        echo "</tr>";
                        $serialNumber++; // Increment serial number for the next row
                    }
                } else {
                    echo "<tr><td colspan='5'>0 results</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <button onclick="printTableContainer()" id="print">Print Table</button>

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
<script src="js/userlist.js"></script>
 
 <!-- attach form js code here  -->
</body>

</html>
<?php
$con->close();
?>