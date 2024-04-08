<?php
include "config.php";

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
  // Redirect to the login page
  header("Location: index.php");
  exit(); // Ensure that code stops executing after the redirect
}

$sql1  = "SELECT nam,auto_id FROM cnf where cls='COLOR' order by nam";
$result = $con->query($sql1);
if (isset($_POST['save']) && $_POST['save'] == "Save") {
  $colour_name = $_POST["colourname"];
  $auto_id = $_POST["colour_name2_id"];
  if ($colour_name !== "" && $auto_id == "") {
    $sql = "INSERT INTO cnf (nam, cls, id) VALUES ('$colour_name', 'COLOR', 'COLOR')";

    if ($con->query($sql) === TRUE) {
      // Redirect to the same page with a success parameter
      header('Location: colour_creation.php?success=1');
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $con->error;
    }
  }

  // $con->close();
}

//-----------------------------------------------------------------------------------------------------------------
if (isset($_POST['update_button']) && $_POST['update_button'] == "Update") {
  if ($colour_name !== "" && $auto_id !== "") {
  $colour_name2 = $_POST["colourname"];
  $auto_id = $_POST["colour_name2_id"];

  $query = "UPDATE cnf SET nam = '$colour_name2' WHERE cls = 'COLOR' and id = 'COLOR' and auto_id= $auto_id";

  // Execute query
  if ($con->query($query) === TRUE) {
    echo "Record updated successfully";
    header('Location: colour_creation.php?success=1');
  } else {
    echo "Error updating record: " . $con->error;
  }
}

} else {
  // echo "Invalid request";
}
  // Close connection
 
//-----------------------------------------------------------------------------------------------------------------

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
  <style>
    .modal {
      display: none;
      /* Hide modal by default */
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      height: 200px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 20px;
      z-index: 101;
      /* Ensure it's above overlay */
    }

    .modal-content {
      /* Add styles for modal content */
    }

    .overlay {
      display: none;
      /* Hide overlay by default */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      /* semi-transparent black */
      z-index: 100;
      /* Ensure it's below modal */
    }

    /* Style the close button */
    .close {
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
      font-size: 20px;
    }

    .close:hover {
      color: red;
    }

    .btn_tog {
      width: 200px;
      height: 40px;
      /* margin-left: 10px; */
      margin-bottom: 10px;
      background-color: rgb(26, 26, 110);
      color: #fff;
      border: 1px solid #fff;
      font-weight: bold;
      padding: 6px 10px;

    }

    .tbl_1 {
      max-height: 500px;
      overflow: auto;
    }

    thead {
      position: sticky;
      top: 0;
    }
  </style>
  <!-- attach form css link here-->
  <link rel="stylesheet" href="css/user.css">
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
        <button id="btn_toggle_report" class="btn_tog" type="button">View List</button>
        <button id="btn_toggle_form" class="btn_tog" type="button" onclick="location.reload()">View Creation</button>
        <div class="printonly" id="report">
          <a href="admin.php"><button id="print" class="non-print">Home</button></a>
          <button onclick="printTableContainer()" id="print" class="non-print">Print</button>
          <!-- attach form container here starts -->

          <div class="tbl_1">
            <table>
              <thead>
                <tr style="text-align:center;font-weight:600">
                  <td class="tbl_heading" colspan="4">List of Colours</td>
                </tr>
                <tr>
                  <th>S.No</th>
                  <!-- <th>Id</th> -->
                  <!-- <th>Colour Id</th> -->
                  <th>Colour Name</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  $serialNumber = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $serialNumber . "</td>";
                    // echo "<td>" . $row["id"] . "</td>";
                    // echo "<td>" . $row["auto_id"] . "</td>";
                    echo "<td>" . $row["nam"] . "</td>";
                    // Edit and Delete links added in the Action column
                    // echo "<td class='non-print'><a href='edit_bobin.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_bobin.php?id=" . $row['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                    $serialNumber++;
                  }
                } else {
                  echo "<tr><td colspan='4'>0 results</td></tr>";
                }
                ?>
              </tbody>
            </table>


          </div>

          <!-- attach form container here ends -->

        </div><!-- attach form container here starts -->


        <div class="body" id='create_bobin'>
          <div class="container-custom">
            <h2>Colour Creation</h2>
            <form id="colour_creationform" action="" method="post" autocomplete="off">

              <div class="form-group">
                <label for="colourname">Colour Name</label>
                <input class="text-uppercase" type="text" id="colourname" name="colourname" required>
              </div>

              <div class="form-group buttons">
                <!-- <button type="submit" name='save'>Create Colour</button> -->
                <input type="submit" class="btn btn-primary" name="save" id="save" value="Save">
                <input style="display:none;"  type="submit" class="btn btn-warning" name="update_button" id="update_button" value="Update">
                <button type="button" id="modal-trigger">Edit</button>

                <a href="admin.php"><button type="button">Home</button></a>
              </div>
              <!--  -->
              <div id="modal" class="modal">
                <div class="modal-content">
                  <span class="close">&times;</span>
                  <p>Select a color to Edit</p>
                  <input type="text" list="editcolor" id="colour_name3" name="colour_name3">
                  <datalist id="editcolor">
                    <?php
                    $sql = "SELECT * FROM cnf  where cls ='COLOR' AND id = 'COLOR'ORDER BY nam";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<option class='text-uppercase' value='" . $row['nam'] . "' data-acid='" . $row['auto_id'] . "'></option>";
                      }
                    }
                    ?>
                    <input type="hidden" name="colour_name2_id" id="colour_name2_id">
                  </datalist>
                  <!-- <button type="button" onclick="edit_color()">Ok</button> -->

                </div>
              </div>

              <div class="overlay"></div>
              <!--  -->
            </form>

          </div>
        </div>
        <!-- attach form container here ends -->

      </div>

      <!-- /#page-content-wrapper ends-->
    </div>

    <!-- footer starts -->
    <?php
    include_once "main/footer.php";
    ?>
    <!-- footer ends -->

    <!-- attach form js code here  -->
    <div id="snackbar"></div>
    <script>
    // window.onload = function() {
    //   const urlParams = new URLSearchParams(window.location.search);
    //   const success = urlParams.get('success');

    //   if (success === '1') {
    //     const snackbar = document.getElementById("snackbar");
    //     snackbar.textContent = "Colour Created Successfully";
    //     snackbar.className = "show";
    //     setTimeout(function() {
    //       snackbar.className = snackbar.className.replace("show", "");
    //     }, 3000);
    //   }
    // }

      function printTableContainer() {
        var content = document.querySelector('.printonly').innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title><link rel="stylesheet" href="css/opening_report1.css"></head><body>' + content + '</body></html>');
        printWindow.document.close();
        printWindow.print();
        // Close the print window/tab after printing
        printWindow.setTimeout(function() {
          printWindow.close();
        }, 1000); // Adjust the delay if needed (in milliseconds)
      }


      document.getElementById('report').style.display = 'none';
      document.getElementById('btn_toggle_form').style.display = 'none';
      document.getElementById('btn_toggle_report').addEventListener('click', function() {
        document.getElementById('report').style.display = 'block';
        document.getElementById('create_bobin').style.display = 'none';
        document.getElementById('btn_toggle_report').style.display = 'none';
        document.getElementById('create_bobin').style.display = 'none';
        document.getElementById('btn_toggle_form').style.display = 'block';


      })




      document.addEventListener('DOMContentLoaded', function() {
        var modalTrigger = document.getElementById('modal-trigger');
        var modal = document.getElementById('modal');
        var overlay = document.querySelector('.overlay');
        var closeButton = document.querySelector('.close');

        // Show modal when trigger button is clicked
        modalTrigger.addEventListener('click', function() {
          modal.style.display = 'block';
          overlay.style.display = 'block';
        });

        // Close modal when close button is clicked
        closeButton.addEventListener('click', function() {
          modal.style.display = 'none';
          overlay.style.display = 'none';
        });
      });
      // document.getElementById('update_button').style.display.none;
      function closemodal() {
        var modalTrigger = document.getElementById('modal-trigger');
        var modal = document.getElementById('modal');
        var update_button = document.getElementById('update_button');
        var save_btn = document.getElementById('save');
        var overlay = document.querySelector('.overlay');
          modal.style.display = 'none';
          overlay.style.display = 'none';
          save_btn.style.display = 'none';
          update_button.style.display = 'block';
        }


      const colour_name3 = document.getElementById('colour_name3');

      colour_name3.addEventListener('change', function(event) {
        const selectedOption = event.target.value;
        const datalistOptions = document.getElementById('editcolor');

        const options = datalistOptions.getElementsByTagName('option');
        for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;

          if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to 


            document.getElementById("colour_name2_id").value = selectedAcid;

            break;
          }
          
        }
        var id = document.getElementById("colour_name2_id").value;

        console.log("colour_name2_id id-->", selectedAcid);
        console.log("colour_name2 value-->", colour_name3.value);
        edit_color();
      });


      function edit_color() {
    var id = document.getElementById("colour_name2_id").value;
    console.log("id", id);

    $.ajax({
        url: 'edit_color.php',
        method: 'POST',
        data: {
            id: id
        },
        dataType: 'json',
        success: function(work) {
            console.log(work);
            if (work.success) {
                var myData = work.data;
                console.log(myData);
                document.getElementById("colourname").value = myData.nam;
                document.getElementById("colour_name2_id").value = myData.auto_id;
                closemodal();
            } else {
                console.log('Error:', work.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

    </script>
    <!-- attach form js code here  -->

</body>

</html>

<?php
 $con->close();
?>