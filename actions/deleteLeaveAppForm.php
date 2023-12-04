<?php
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['deleteLeaveAppForm'])) {
    // Function to apply strip_tags and mysqli_real_escape_string
    function sanitizeInput($input)
    {
        global $database;
        return mysqli_real_escape_string($database, strip_tags($input));
    }

    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $recordId = isset($_POST['recordId']) ? sanitizeInput($_POST['recordId']) : null;

    $query = "DELETE FROM tbl_leaveappform WHERE leaveappform_id = ?";
    $stmt = mysqli_prepare($database, $query);

    mysqli_stmt_bind_param($stmt, "s", $recordId);

    if (mysqli_stmt_execute($stmt)) {
        // Deletion successful
        $_SESSION['alert_message'] = "Leave Application Form Successfully Deleted";
        $_SESSION['alert_type'] = $success_color;
    } else {
        // Capture error message for later display
        $_SESSION['alert_message'] = "Error Deleting Leave Application Form: " . mysqli_stmt_error($stmt);
        $_SESSION['alert_type'] = $error_color;
    }

    mysqli_stmt_close($stmt);

    if ($empId) {
        header("Location: " . $location_admin_departments_employee_leaveappform . '/' . $empId . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
    exit();
} else {
    // $_SESSION['alert_message'] = "Not Yet Available!";
    // $_SESSION['alert_type'] = $warning_color;
    header("Location: " . $location_admin_departments_office);
    exit();
}
?>