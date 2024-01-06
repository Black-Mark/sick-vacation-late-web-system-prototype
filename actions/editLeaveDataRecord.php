<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

// Function to apply strip_tags and mysqli_real_escape_string

if (isset($_POST['editLeaveDataRecord'])) {
    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $leaveDataFormId = isset($_POST['leavedataformId']) ? sanitizeInput($_POST['leavedataformId']) : null;
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

    $initial = "Initial Record";
    $initialRecordData = [];

    $getInitialRecordQuery = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND recordType = ? LIMIT 1";
    $stmtForInitialRecord = $database->prepare($getInitialRecordQuery);

    if ($stmtForInitialRecord) {
        $stmtForInitialRecord->bind_param("ss", $empId, $initial);
        $stmtForInitialRecord->execute();
        $resultInitialRecord = $stmtForInitialRecord->get_result();

        if ($resultInitialRecord->num_rows > 0) {
            $initialRecordData = $resultInitialRecord->fetch_assoc();

            if ($period >= $initialRecordData['periodEnd'] && $periodEnd >= $initialRecordData['periodEnd']) {
                // Prepare the SQL query for update
                $sql = "UPDATE tbl_leavedataform 
                        SET period = ?, periodEnd = ?, particular = ?, particularLabel = ?, days = ?, hours = ?, minutes = ?, dateOfAction = ? 
                        WHERE leavedataform_id = ? AND employee_id = ?";

                // Prepare and bind the statement
                $stmt = $database->prepare($sql);
                $stmt->bind_param('ssssiiisis', $period, $periodEnd, $particularType, $particularLabel, $days, $hours, $minutes, $dateOfAction, $leaveDataFormId, $empId);

                $stmt->execute();

                if ($stmt->error) {
                    $_SESSION['alert_message'] = "Update Failed: " . $stmt->error;
                    $_SESSION['alert_type'] = $error_color;
                } else {
                    $_SESSION['alert_message'] = "Successfully Updated!";
                    $_SESSION['alert_type'] = $success_color;
                }

                $stmt->close();
            } else {
                $_SESSION['alert_message'] = "The Period and the Period End Should Be Greater Than " . $initialRecordData['periodEnd'];
                $_SESSION['alert_type'] = $warning_color;
            }
        }
    } else {
        // Something
    }

    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
    exit();
} else {
    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
    exit();
}
?>