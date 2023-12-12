<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['deleteLeaveAppRecord'])) {
    // Function to apply strip_tags and mysqli_real_escape_string
    function sanitizeInput($input)
    {
        global $database;
        return mysqli_real_escape_string($database, strip_tags($input));
    }

    $_SESSION['alert_message'] = "Not Yet Available!";
    $_SESSION['alert_type'] = $warning_color;

    header("Location: " . $location_admin_departments_employee_leaveappform);
} else {
    $_SESSION['alert_message'] = "Not Yet Available!";
    $_SESSION['alert_type'] = $warning_color;
    header("Location: " . $location_admin_departments_employee_leaveappform);
}
?>