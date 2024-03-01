<?php
include "config.php";

// Check if 'uname' session variable is not set or empty
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit(); // Ensure that code stops executing after the redirect
}

?>

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
                    <?php
                    // SQL query to retrieve location names from the stock_stores table
                    $sql = "SELECT loc_nam FROM stock_stores";

                    // Execute query
                    $result = mysqli_query($con, $sql);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        // Counter for closing and opening rows
                        $counter = 0;
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Open new row after every three cards
                            if ($counter % 3 == 0) {
                                echo '<div class="row">';
                            }
                            echo '
                            <div class="col-lg-4">
                                <div class="card shadow mb-3">
                                    <div class="card-body">' . $row['loc_nam'] . '</div>
                                </div>
                            </div>';
                            // Close row after every three cards
                            if ($counter % 3 == 2) {
                                echo '</div>';
                            }
                            $counter++;
                        }
                        // Close row if the number of cards is not a multiple of three
                        if ($counter % 3 != 0) {
                            echo '</div>';
                        }
                    } else {
                        echo "0 results";
                    }

                    // Close connection
                    mysqli_close($con);
                    ?>
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
