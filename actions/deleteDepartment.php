<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['deleteDepartment'])) {
    // Only Update the Archive to Deleted
    $departmentId = strip_tags(mysqli_real_escape_string($database, $_POST['deptId']));
    $actionSet = strip_tags(mysqli_real_escape_string($database, $_POST['actionSet']));
    $departmentReassigned = strip_tags(mysqli_real_escape_string($database, $_POST['departmentReassigned']));
    $dateOfAction = $today;

    $archiveDepartmentQuery = "UPDATE tbl_departments SET archive = 'deleted' WHERE department_id = ?";
    $archiveDepartmentStatement = mysqli_prepare($database, $archiveDepartmentQuery);

    if ($archiveDepartmentStatement) {
        mysqli_stmt_bind_param($archiveDepartmentStatement, "i", $departmentId);
        mysqli_stmt_execute($archiveDepartmentStatement);
        if (mysqli_stmt_affected_rows($archiveDepartmentStatement) > 0) {
            $_SESSION['alert_message'] = "Department Successfully Moved to Trash";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Deleting Department: " . mysqli_stmt_error($archiveDepartmentStatement);
            $_SESSION['alert_type'] = $error_color;
        }
        mysqli_stmt_close($archiveDepartmentStatement);
    } else {
        $_SESSION['alert_message'] = "Error Deleting Department!";
        $_SESSION['alert_type'] = $error_color;
    }

    // Check if $actionSet is empty or if $actionSet is "Reassign" but $departmentReassigned is empty
    if (empty(trim($actionSet)) || ($actionSet == "Reassign" && empty(trim($departmentReassigned)))) {
        // Nothing to do
    } else if ($actionSet == "Reassign" && !empty(trim($departmentReassigned))) {
        // Reassign department
        $query = "UPDATE tbl_useraccounts 
              SET department = ? 
              WHERE department = ? 
              AND archive != 'deleted' 
              AND UPPER(status) != 'INACTIVE' AND UPPER(status) != 'BANNED'";
        $stmt = mysqli_prepare($database, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $departmentReassigned, $departmentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $_SESSION['alert_message'] = "Department Successfully Moved to Trash and Employee Successfully Reassigned";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "There is a Problem in Reassigning Employees: " . mysqli_error($database);
            $_SESSION['alert_type'] = $error_color;
        }
    } else if ($actionSet == "Terminate") {
        // Terminate user accounts
        $query = "UPDATE tbl_useraccounts 
              SET status = 'Inactive', archive = 'deleted', reasonForStatus = 'Terminated' 
              WHERE department = ? 
              AND archive != 'deleted' 
              AND UPPER(status) != 'INACTIVE' AND UPPER(status) != 'BANNED'";
        $stmt = mysqli_prepare($database, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $departmentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $_SESSION['alert_message'] = "Department and Employees Are Terminated and Moved to Trash";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "There is a Problem in Terminating Employees: " . mysqli_error($database);
            $_SESSION['alert_type'] = $error_color;
        }

        // Insert into tbl_leavedataform
        $labelStatus = "Break Monthly Record";
        $query = "INSERT INTO tbl_leavedataform 
              (employee_id, dateCreated, recordType, period, periodEnd, periodOne, periodTwo, periodThree, particular, dateOfAction) 
              VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($database, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $employeeId, $labelStatus, $today, $today, $today, $today, $today, $labelStatus, $dateOfAction);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['alert_message'] = "Account Has Been Terminated But Record Failed: " . mysqli_error($database);
            $_SESSION['alert_type'] = $warning_color;
        }
    }

    header("Location: " . $location_admin_departments);
    exit();
} else if (isset($_POST['absoluteDeleteDepartment'])) {
    $departmentId = strip_tags(mysqli_real_escape_string($database, $_POST['departmentId']));

    $query = "DELETE FROM tbl_departments WHERE department_id = ?";
    $stmt = mysqli_prepare($database, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $departmentId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "Department Successfully Deleted";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Deleting Department: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['alert_message'] = "Error preparing delete statement: " . mysqli_error($database);
        $_SESSION['alert_type'] = $error_color;
    }

    header("Location: " . $location_admin_datamanagement_archive_department);
    exit();
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    header("Location: " . $location_admin_departments);
}

?>
<!-- -->