<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['deleteLeaveData']) && isset($_POST['leavedataformId'])) {
    // Only Update the Archive to Deleted
    $leaveDataFormId = strip_tags(mysqli_real_escape_string($database, $_POST['leavedataformId']));
    $empId = strip_tags(mysqli_real_escape_string($database, $_POST['empId']));
    $selectedYear = strip_tags(mysqli_real_escape_string($database, $_POST['selectedYear']));

    if ($selectedYear) {
        $_SESSION['post_dataformyear'] = $selectedYear;
    }

    $archiveLeaveDataQuery = "UPDATE tbl_leavedataform SET archive = 'deleted' WHERE leavedataform_id = ?";
    $archiveLeaveDataStatement = mysqli_prepare($database, $archiveLeaveDataQuery);

    if ($archiveLeaveDataStatement) {
        mysqli_stmt_bind_param($archiveLeaveDataStatement, "i", $leaveDataFormId);
        mysqli_stmt_execute($archiveLeaveDataStatement);
        if (mysqli_stmt_affected_rows($archiveLeaveDataStatement) > 0) {
            $_SESSION['alert_message'] = "Leave Data Successfully Moved to Trash";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Deleting Leave Data: " . mysqli_stmt_error($archiveLeaveDataStatement);
            $_SESSION['alert_type'] = $error_color;
        }
        mysqli_stmt_close($archiveLeaveDataStatement);
    } else {
        $_SESSION['alert_message'] = "Error Deleting Leave Data!";
        $_SESSION['alert_type'] = $error_color;
    }

    if ($empId) {
        header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
        exit();
    }
} else if (isset($_POST['absoluteDeleteLeaveData']) && isset($_POST['leavedataformId'])) {
    $leaveDataFormId = strip_tags(mysqli_real_escape_string($database, $_POST['leavedataformId']));
    $empId = strip_tags(mysqli_real_escape_string($database, $_POST['empId']));
    $selectedYear = strip_tags(mysqli_real_escape_string($database, $_POST['selectedYear']));

    if ($selectedYear) {
        $_SESSION['post_dataformyear'] = $selectedYear;
    }

    $query = "DELETE FROM tbl_leavedataform WHERE leavedataform_id = ?";
    $stmt = mysqli_prepare($database, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $leaveDataFormId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "Leave Record Successfully Deleted";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Deleting Leave Record: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['alert_message'] = "Error preparing delete statement: " . mysqli_error($database);
        $_SESSION['alert_type'] = $error_color;
    }

    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
    exit();
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
}

?>