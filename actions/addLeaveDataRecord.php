<?php
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

// Function to apply strip_tags and mysqli_real_escape_string
function sanitizeInput($input)
{
    global $database;
    return mysqli_real_escape_string($database, strip_tags($input));
}

if (isset($_POST['addLeaveDataRecord'])) {
    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $selectedYear = isset($_POST['selectedYear']) ? sanitizeInput($_POST['selectedYear']) : null;
    $period = isset($_POST['period']) ? sanitizeInput($_POST['period']) : null;
    $periodEnd = isset($_POST['periodEnd']) ? sanitizeInput($_POST['periodEnd']) : null;
    $particularType = isset($_POST['particularType']) ? sanitizeInput($_POST['particularType']) : null;
    $particularLabel = isset($_POST['particularLabel']) ? sanitizeInput($_POST['particularLabel']) : null;
    $days = isset($_POST['dayInput']) ? sanitizeInput($_POST['dayInput']) : null;
    $hours = isset($_POST['hourInput']) ? sanitizeInput($_POST['hourInput']) : null;
    $minutes = isset($_POST['minuteInput']) ? sanitizeInput($_POST['minuteInput']) : null;
    $dateOfAction = isset($_POST['dateOfAction']) ? sanitizeInput($_POST['dateOfAction']) : null;

    if ($selectedYear) {
        $_SESSION['post_dataformyear'] = $selectedYear;
    }

    $dataRecordType = "Deduction Type";

    // Prepare the SQL query
    $sql = "INSERT INTO tbl_leavedataform (employee_id, dateCreated, recordType, period, periodEnd, particular, particularLabel, days, hours, minutes, dateOfAction) 
            VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind the statement
    $stmt = $database->prepare($sql);
    $stmt->bind_param('ssssssiiis', $empId, $dataRecordType, $period, $periodEnd, $particularType, $particularLabel, $days, $hours, $minutes, $dateOfAction);

    $stmt->execute();

    if ($stmt->error) {
        $_SESSION['alert_message'] = "Adding New Leave Record Failed!: " . $stmt->error;
        $_SESSION['alert_type'] = $error_color;
    } else {
        $_SESSION['alert_message'] = "New Leave Record Successfully Added!";
        $_SESSION['alert_type'] = $success_color;
    }

    $stmt->close();

    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
    exit();
} else if (isset($_POST['createInitialRecord'])) {
    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $selectedYear = isset($_POST['selectedYear']) ? sanitizeInput($_POST['selectedYear']) : null;

    $period = isset($_POST['period']) ? sanitizeInput($_POST['period']) : null;
    $periodEnd = isset($_POST['periodEnd']) ? sanitizeInput($_POST['periodEnd']) : null;
    $particularLabel = isset($_POST['particularLabel']) ? sanitizeInput($_POST['particularLabel']) : null;

    $vacationBalance = isset($_POST['vacationBalance']) ? sanitizeInput($_POST['vacationBalance']) : null;
    $vacationUnderWOPay = isset($_POST['vacationUnderWOPay']) ? sanitizeInput($_POST['vacationUnderWOPay']) : null;
    $sickBalance = isset($_POST['sickBalance']) ? sanitizeInput($_POST['sickBalance']) : null;
    $sickUnderWOPay = isset($_POST['sickUnderWOPay']) ? sanitizeInput($_POST['sickUnderWOPay']) : null;

    $dateOfAction = isset($_POST['dateOfAction']) ? sanitizeInput($_POST['dateOfAction']) : null;

    $arrayLeaveDataRecord = [];

    if ($selectedYear) {
        $_SESSION['post_dataformyear'] = $selectedYear;
    }

    $dataRecordType = "Initial Record";

    $sqlFetchPreviousLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND period <= ? AND recordType != ? ORDER BY period DESC, dateCreated DESC LIMIT 1";

    $stmtFetchPreviousLeaveData = $database->prepare($sqlFetchPreviousLeaveData);
    $stmtFetchPreviousLeaveData->bind_param("sss", $empId, $period, $dataRecordType);
    $stmtFetchPreviousLeaveData->execute();

    $resultFetchPreviousLeaveData = $stmtFetchPreviousLeaveData->get_result();

    if ($resultFetchPreviousLeaveData->num_rows > 0) {
        $previousLeaveData = $resultFetchPreviousLeaveData->fetch_assoc();
        $_SESSION['alert_message'] = "Initialization Should Be Earlier Than " . $previousLeaveData['period'];
        $_SESSION['alert_type'] = $warning_color;
        header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
        exit();
    } else {
        // Check if an Initial Record already exists for the specified employee and year
        $checkQuery = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND recordType = ?";
        $checkStmt = mysqli_prepare($database, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "ss", $empId, $dataRecordType);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            // Record already exists, perform an update
            $updateQuery = "UPDATE tbl_leavedataform 
                        SET period = ?, periodEnd = ?, particularLabel = ?, 
                            vacationLeaveEarned = ?, vacationLeaveBalance = ?, vacationLeaveAbsUndWOP = ?,
                            sickLeaveEarned = ?, sickLeaveBalance = ?, sickLeaveAbsUndWOP = ?, dateOfAction = ? 
                        WHERE employee_id = ? AND recordType = 'Initial Record' AND selectedYear = ?";

            $updateStmt = mysqli_prepare($database, $updateQuery);
            mysqli_stmt_bind_param(
                $updateStmt,
                "ssddddddssss",
                $period,
                $periodEnd,
                $particularLabel,
                $vacationBalance,
                $vacationBalance,
                $vacationUnderWOPay,
                $sickBalance,
                $sickBalance,
                $sickUnderWOPay,
                $dateOfAction,
                $empId,
                $selectedYear
            );

            if (mysqli_stmt_execute($updateStmt)) {
                // Update successful
                $_SESSION['alert_message'] = "Initialization Successfully Updated";
                $_SESSION['alert_type'] = $success_color;
                header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
                exit();
            } else {
                // Update failed
                $_SESSION['alert_message'] = "Initialization Update Failed: " . mysqli_stmt_error($updateStmt);
                $_SESSION['alert_type'] = $error_color;
                header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
                exit();
            }
        } else {
            $query = "  INSERT INTO tbl_leavedataform 
                  (employee_id, dateCreated, recordType, period, periodEnd, particular, particularLabel,
                  vacationLeaveEarned, vacationLeaveBalance, vacationLeaveAbsUndWOP,
                  sickLeaveEarned, sickLeaveBalance, sickLeaveAbsUndWOP, dateOfAction) 
                VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($database, $query);

            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssdddddds",
                $empId,
                $dataRecordType,
                $period,
                $periodEnd,
                $dataRecordType,
                $particularLabel,
                $vacationBalance,
                $vacationBalance,
                $vacationUnderWOPay,
                $sickBalance,
                $sickBalance,
                $sickUnderWOPay,
                $dateOfAction
            );

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['alert_message'] = "Initialization Successfully Created";
                $_SESSION['alert_type'] = $success_color;
                // header("Location: " . $_SERVER['PHP_SELF']);
                header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
                exit();
            } else {
                $_SESSION['alert_message'] = "Initialization Successfully Failed: " . mysqli_stmt_error($stmt);
                $_SESSION['alert_type'] = $error_color;
                header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
                exit();
            }
        }
    }
} else {
    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
    exit();
}
?>