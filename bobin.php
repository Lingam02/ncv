  <!-- attach php code here -->
  <?php
  include "config.php";


  $sql1 = "SELECT id,bobin_id,empty_wt FROM bobin"; // Default query to retrieve all users
  $result = $con->query($sql1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bobin_id = $_POST["bobin_id"];
    $empty_wt = $_POST["empty_wt"];
    $bobin_id_edi = $_POST["bobin_id_edi"];

    if (!empty($bobin_id_edi)) {
        // If $bobin_id_edi is provided, update the existing record
        $sql = "UPDATE bobin SET bobin_id = '$bobin_id', empty_wt = '$empty_wt' WHERE id = $bobin_id_edi";
    } else {
        // If $bobin_id_edi is empty, perform an insert for a new record
        $sql = "INSERT INTO bobin (bobin_id, empty_wt) VALUES ('$bobin_id', '$empty_wt')";
    }

    if ($con->query($sql) === TRUE) {
        echo "Operation performed successfully";
        header('Location: bobin.php?success=1'); // Redirect before closing the connection
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
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
    <link rel="stylesheet" href="css/opening_report1.css">
    <style>
      /* The Modal */
      .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Positioning fixed to keep it in view */
        z-index: 1;
        /* Make sure it appears above everything else */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* Enable scrolling if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black background with opacity */
      }

      /* Modal Content */
      .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* Adjust this value to center the modal vertically */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Set a width for the modal */
        max-width: 400px;
      }

      /* Close button */
      .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
      }

      .close:hover,
      .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
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
    <!-- attach form css link here ends-->
    <script>
      window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');

        if (success === '1') {
          const snackbar = document.getElementById("snackbar");
          snackbar.textContent = "Bobin Id / No Created successfully";
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
          <button id="btn_toggle_report" class="btn_tog" type="button">View List</button>
          <button id="btn_toggle_form" class="btn_tog" type="button" onclick="location.reload()">View Creation</button>
          <div class="printonly" id="report">
            <a href="admin.php"><button id="print" class="non-print">Home</button></a>
            <button onclick="printTableContainer()" id="print" class="non-print">Print</button>
            <!-- attach form container here starts -->

            <div class="tbl_1">
              <table>
                <thead>
                  <tr text-align:center;font-weight:600>
                    <td class="tbl_heading" colspan="4">Empty Bobins</td>
                  </tr>
                  <tr>
                    <th>S.No</th>
                    <!-- <th>Id</th> -->
                    <th>Bobin No</th>
                    <th>Empty Weight</th>
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
                      echo "<td>" . $row["bobin_id"] . "</td>";
                      echo "<td>" . $row["empty_wt"] . "</td>";
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
              <h2>Bobin setup Creation</h2>
              <form id="userCreationForm" action="" method="post" autocomplete="off">


                <div class="form-group">
                  <label for="bobin_id">Bobin Id / No</label>
                  <input type="text" id="bobin_id" name="bobin_id" pattern="\d{4}" title="Please enter a four-digit number." required>
                  <input type="hidden" id="bobin_id_edi" name="bobin_id_edi" required>
                </div>
                <div class="form-group">
                  <label for="empty_wt">Bobin Empty Weight</label>
                  <input type="number" id="empty_wt" name="empty_wt" pattern="\d{3}" title="Please enter a Three-digit number." required>
                </div>

                <div class="form-group buttons">
                  <button type="submit">Create </button>
                  <!-- <button type="button" id="myBtn">Edit</button>  -->
                  <a href="admin.php"><button type="button">Home</button></a>
                </div>
                <div id="snackbar"></div>

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
    <!-- The Modal -->
    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <input type="text" list="iss_col_list" class="form-control" id="bobin_no_edit" name="bobin_no_edit" placeholder="" onclick="this.select()">
        <datalist id="iss_col_list">

          <?php
          $sqlb = mysqli_query($con, "SELECT bobin_id, id FROM bobin order by bobin_id");
          while ($row = $sqlb->fetch_assoc()) {
            echo "<option class='text-uppercase' value='" . $row['bobin_id'] . "' data-acid='" . $row['id'] . "'></option>";
          }
          ?>
        </datalist>
        <input type="hidden" class="form-control" id="bobi_id" name="bobi_id" placeholder="">
        <button type="button" onclick="fill_edittable()">Proceed</button>
      </div>

    </div>

    <!-- Button to trigger the modal -->
    

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


      });


      // Get the modal
      var modal = document.getElementById("myModal");

      // Get the button that opens the modal
      var btn = document.getElementById("myBtn");

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks the button, open the modal
      btn.onclick = function() {
        modal.style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }

      //dyer id get 
      const bobin_no_edit = document.getElementById('bobin_no_edit');

      bobin_no_edit.addEventListener('change', function(event) {
        const selectedOption = event.target.value;
        const datalistOptions = document.getElementById('iss_col_list');

        const options = datalistOptions.getElementsByTagName('option');
        for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;

          if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
            //console.log('ok',selectedAcid);

            document.getElementById("bobi_id").value = selectedAcid;

            break;
          }
        }
        var id = document.getElementById("bobi_id").value;

        console.log("bobin auto id-->", selectedAcid);
        console.log("bobinno value-->", bobin_no_edit.value);
      });


      
function fill_edittable() {
  var id = document.getElementById("bobi_id").value;
  //console.log(id);

  $.ajax({
    url: 'fetch_bobin_create.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (bobin) {
     console.log(bobin);
       document.getElementById('bobin_id').value = bobin.bobin_id;
       document.getElementById('empty_wt').value = bobin.empty_wt;
       document.getElementById("bobi_id_edi").value = bobin.id;
    }
      });
       modal.style.display = "none";
    }

    </script>

    <!-- attach form js code here  -->
  </body>

  </html>
  <?php
 $con->close();
  ?>
