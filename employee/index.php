<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Employee Page">
    <?php
    include($constants_file_html_credits);
    ?>
    <link rel="icon" type="image/x-icon" href="../assets/images/indang-logo.ico">

    <link rel="stylesheet" href="../assets/bootstrap/dist/css/bootstrap.min.css">
    <script src="../assets/bootstrap/assets/js/vendor/jquery-slim.min.js"></script>
    <script src="../assets/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="../assets/bootstrap/dist/js/bootstrap.min.js"></script>

    <link rel='stylesheet' href='../assets/font-awesome/css/font-awesome.min.css'>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- <script src="../assets/js/tailwind.js"></script> -->
</head>

<body class="webpage-background-cover">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class="text-experiment">This is Employee Page</div>
        </div>
    </div>

    <!-- <div>
    <?php
    // include($components_file_footer)
    ?>
    </div> -->
</body>

</html>