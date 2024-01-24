<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['deleteLeaveAppForm'])) {
    // Only Update the Archive to Deleted
    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $recordId = isset($_POST['recordId']) ? sanitizeInput($_POST['recordId']) : null;

    $archiveLeaveFormQuery = "UPDATE tbl_leaveappform SET archive = 'deleted' WHERE leaveappform_id = ?";
    $archiveLeaveFormStatement = mysqli_prepare($database, $archiveLeaveFormQuery);

    if ($archiveLeaveFormStatement) {
        mysqli_stmt_bind_param($archiveLeaveFormStatement, "s", $recordId);
        mysqli_stmt_execute($archiveLeaveFormStatement);
        if (mysqli_stmt_affected_rows($archiveLeaveFormStatement) > 0) {
            $_SESSION['alert_message'] = "Leave Form Successfully Moved to Trash";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Deleting Leave Form: " . mysqli_stmt_error($archiveLeaveFormStatement);
            $_SESSION['alert_type'] = $error_color;
        }
        mysqli_stmt_close($archiveLeaveFormStatement);
    } else {
        $_SESSION['alert_message'] = "Error Deleting Leave Form!";
        $_SESSION['alert_type'] = $error_color;
    }

    if ($empId) {
        header("Location: " . $location_admin_departments_employee_leaveappform . '/' . $empId . '/');
    } else {
        header("Location: " . $location_admin_leaveapplist);
    }
    exit();
} else if (isset($_POST['absoluteDeleteLeaveAppForm'])) {
    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $recordId = isset($_POST['recordId']) ? sanitizeInput($_POST['recordId']) : null;

    $query = "DELETE FROM tbl_leaveappform WHERE leaveappform_id = ?";
    $stmt = mysqli_prepare($database, $query);

    mysqli_stmt_bind_param($stmt, "s", $recordId);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['alert_message'] = "Leave Application Form Successfully Deleted";
        $_SESSION['alert_type'] = $success_color;
    } else {
        $_SESSION['alert_message'] = "Error Deleting Leave Application Form: " . mysqli_stmt_error($stmt);
        $_SESSION['alert_type'] = $error_color;
    }

    mysqli_stmt_close($stmt);

    if ($empId) {
        header("Location: " . $location_admin_departments_employee_leaveappform . '/' . $empId . '/');
    } else {
        header("Location: " . $location_admin_leaveapplist);
    }
    exit();
} else {
    // $_SESSION['alert_message'] = "Not Yet Available!";
    // $_SESSION['alert_type'] = $warning_color;
    header("Location: " . $location_admin_leaveapplist);
    exit();
}
?>