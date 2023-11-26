<?php

@ob_start();
session_start();

// Set session timeout to 30 minutes
$session_timeout = 60 * 60;

// Check if the session variable last activity is set
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Session has expired
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: " . $location_login);
}

// Update last activity time stamp
$_SESSION['last_activity'] = time();

if (isset($_SESSION['employeeId'])) {
    $employeeId = $_SESSION['employeeId'];
    $sql = "SELECT * FROM tbl_useraccounts WHERE employee_id= '$employeeId'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['role'] != "Employee") {
                if ($row['role'] == "Admin") {
                    header("location: " . $location_admin);
                } else {
                    ?>
                    <script>alert("Error: There is no such role!");</script>
                    <?php
                }
            }
        }
    } else {
        ?>
        <script>alert("An error has occurred: There is no registered employee ID.");</script>
        <?php
    }
} else {
    header("location: " . $location_login);
}

?>