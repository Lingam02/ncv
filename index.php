<?php
include "config.php";

if (isset($_POST['but_submit'])) {
    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);

    if ($uname != "" && $password != "") {
        $sql_query = "SELECT * FROM acct WHERE user_nam = '" . $uname . "' AND pwd = '" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        if ($result->num_rows > 0) {
            session_start();
            $_SESSION['uname'] = $uname;
            $_SESSION['uid'] = $row['ac_id'];
            $_SESSION['ADMIN'] = $row['ac_grp_nam'];

            // Check ac_grp_nam for different roles
            $ac_grp_nam = trim(strtoupper($row['ac_grp_nam']));
            if ($ac_grp_nam === "ADMIN") {
                header('Location: admin.php');
                exit();
            } elseif ($ac_grp_nam === "WORKER") {
                header('Location: admin.php');
                exit();
            } elseif ($ac_grp_nam === "WEAVER") { // New condition for "weaver"
                header('Location: admin.php');
                exit();
            }
        } else {
            $error_message = "Invalid username and password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acpro - Accounting & Inventry Software</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <div class="body">
        <div class="container-custom">
            <form method="post" action="" autocomplete="off">
                <div id="div_login">
                    <h1>Login</h1><br>
                    <div>
                        <label for="txt_uname">Username</label>
                        <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" onkeydown="handleEnterKey(event, 'txt_pwd')" required />
                    </div>
                    <div>
                        <label for="txt_pwd">Password</label>
                        <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password" onkeydown="handleEnterKey(event, 'but_submit')" required />
                    </div>
                    <div>
                        <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="snackbar" class="snackbar"></div>

    <!-- JavaScript to show the Snackbar -->
    <script>
        <?php
        if (isset($error_message)) {
            echo "var errorMessage = '" . $error_message . "';\n";
            echo "var snackbar = document.getElementById('snackbar');\n";
            echo "snackbar.textContent = errorMessage;\n";
            echo "snackbar.className = 'snackbar show';\n";
            echo "setTimeout(function(){ snackbar.className = snackbar.className.replace('show', ''); }, 3000);";
        }
        ?>
    </script>
    <script src="js/main.js"></script>
</body>

</html>