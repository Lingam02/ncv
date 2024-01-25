  <!-- attach php code here -->
  <?php
  include "config.php";


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ac_name = $_POST["blockname"];

    $sql = "INSERT INTO cnf (nam, id, cls) VALUES ('$ac_name', 'BLOCK', 'BLOCK')";

    if ($con->query($sql) === TRUE) {
      // Redirect to createblock.php with a success message
      header('Location: createblock.php?success=1');
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
      snackbar.textContent = "Block Created successfully";
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
          <div class="body">
            <div class="container-custom">
              <h2>Block Creation</h2>
              <form id="userCreationForm" action="" method="post" autocomplete="off">


                <div id="modal" class="modal">
                  <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <!-- Add your modal content here -->
                    <div class="form-group">
                      <label for="block_edit">Select Block Name</label>
                      <input type="text" list="blockoptions" id="block_edit" name="block_edit"  placeholder="Type to select category...">
                      <datalist id="blockoptions">

                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="blockname">Block Name</label>
                  <input  type="text" id="blockname" name="blockname" required>
                </div>

                <div class="form-group buttons">
                  <button type="submit">Create Block</button>
                  <a href="admin.php"><button type="button">Home</button></a>
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

    <script>
      function openModal() {
        var modal = document.getElementById('modal');
        modal.style.display = "block";
      }

      function closeModal() {
        var modal = document.getElementById('modal');
        modal.style.display = "none";
      }

      // Close the modal if the user clicks outside of it
      window.onclick = function(event) {
        var modal = document.getElementById('modal');
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    </script>
    <!-- attach form js code here  -->
  </body>

  </html>