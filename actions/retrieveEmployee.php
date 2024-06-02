<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['retrieveEmployee']) && isset($_POST['employeeNum'])) {
    $employeeNum = strip_tags(mysqli_real_escape_string($database, $_POST['employeeNum']));

    $archiveEmployeeQuery = "UPDATE tbl_useraccounts SET archive = '', reasonForStatus = '', status = 'Active' WHERE employee_id = ?";
    $archiveEmployeeStatement = mysqli_prepare($database, $archiveEmployeeQuery);

    if ($archiveEmployeeStatement) {
        mysqli_stmt_bind_param($archiveEmployeeStatement, "s", $employeeNum);
        mysqli_stmt_execute($archiveEmployeeStatement);
        if (mysqli_stmt_affected_rows($archiveEmployeeStatement) > 0) {
            $_SESSION['alert_message'] = "Employee Successfully Restored!";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Restoring Employee: " . mysqli_stmt_error($archiveEmployeeStatement);
            $_SESSION['alert_type'] = $error_color;
        }
        mysqli_stmt_close($archiveEmployeeStatement);
    } else {
        $_SESSION['alert_message'] = "Error Restoring Employee!";
        $_SESSION['alert_type'] = $error_color;
    }

    $sqlBreak = "   SELECT * FROM tbl_leavedataform 
                    WHERE employee_id = ? AND recordType = 'Break Monthly Record'
                    ORDER BY periodEnd DESC LIMIT 1";
    $stmt = $database->prepare($sqlBreak);
    $stmt->bind_param("s", $employeeNum);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any records
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['periodEnd'] == $row['period']) {
            // Delete the record
            $deleteSql = "DELETE FROM tbl_leavedataform WHERE id = ?";
            $deleteStmt = $database->prepare($deleteSql);
            $deleteStmt->bind_param("s", $row['id']);
            $deleteStmt->execute();
        } else {
            // Update the periodEnd to current date
            $updateSql = "UPDATE tbl_leavedataform SET periodEnd = ? WHERE id = ?";
            $updateStmt = $database->prepare($updateSql);
            $updateStmt->bind_param("ss", $currentDate, $row['leavedataform_id']);
            $updateStmt->execute();
        }
    }
    $stmt->close();

    header("Location: " . $location_admin_datamanagement_archive_employee);
    exit();

} else if (isset($_POST['retrieveMultipleEmployee']) && isset($_POST['selectedEmployee'])) {
    $selectedEmployees = $_POST['selectedEmployee'];
    $errorMessages = [];

    foreach ($selectedEmployees as $employeeId) {
        $employeeId = strip_tags(mysqli_real_escape_string($database, $employeeId));

        $query = "UPDATE tbl_useraccounts SET archive = '' WHERE employee_id = ?";
        $stmt = mysqli_prepare($database, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $employeeId);

            if (mysqli_stmt_execute($stmt)) {
                // Deletion successful
            } else {
                // Capture error message for later display
                $errorMessages[] = "Error restoring Employee with ID $employeeId: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            // Capture error message for later display
            $errorMessages[] = "Error preparing restore statement: " . mysqli_error($database);
        }
    }

    if (empty($errorMessages)) {
        $_SESSION['alert_message'] = "Selected Employees Successfully Restored!";
        $_SESSION['alert_type'] = $success_color;
    } else {
        $_SESSION['alert_message'] = "Some errors occurred during restoration. Please check the details below.";
        $_SESSION['alert_type'] = $error_color;
        // Store the error messages for display
        $_SESSION['error_messages'] = $errorMessages;
    }

    header("Location: " . $location_admin_datamanagement_archive_employee);
    exit();

} else {
    header("Location: " . $location_admin_datamanagement_archive_employee);
    exit();
}

?>