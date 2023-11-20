<?php
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['addLeaveDataRecord'])) {
    // Empty Variables
    $initialValue = 1.25;
    $newVacationLeaveEarned = 0.00;
    $newVacationLeaveAbsUndWP = 0.00;
    $newVacationLeaveBalance = 0.00;
    $newVacationLeaveAbsUndWOP = 0.00;
    $newSickLeaveEarned = 0.00;
    $newSickLeaveAbsUndWP = 0.00;
    $newSickLeaveBalance = 0.00;
    $newSickLeaveAbsUndWOP = 0.00;

    // Function to apply strip_tags and mysqli_real_escape_string
    function sanitizeInput($input)
    {
        global $database;
        return mysqli_real_escape_string($database, strip_tags($input));
    }

    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $selectedYear = isset($_POST['selectedYear']) ? sanitizeInput($_POST['selectedYear']) : null;
    $period = isset($_POST['period']) ? sanitizeInput($_POST['period']) : null;
    $periodEnd = isset($_POST['periodEnd']) ? sanitizeInput($_POST['periodEnd']) : null;
    $particularType = isset($_POST['particularType']) ? sanitizeInput($_POST['particularType']) : null;
    $particularLabel = isset($_POST['particularLabel']) ? sanitizeInput($_POST['particularLabel']) : null;
    $days = isset($_POST['dayInput']) ? sanitizeInput($_POST['dayInput']) : null;
    $hours = isset($_POST['hourInput']) ? sanitizeInput($_POST['hourInput']) : null;
    $minutes = isset($_POST['minuteInput']) ? sanitizeInput($_POST['minuteInput']) : null;
    $inputType = isset($_POST['inputType']) ? sanitizeInput($_POST['inputType']) : null;
    $dateOfAction = isset($_POST['dateOfAction']) ? sanitizeInput($_POST['dateOfAction']) : null;

    if ($selectedYear) {
        $_SESSION['post_dataformyear'] = $selectedYear;
    }

    $totalMinutes = (($days * 8) * 60) + ($hours * 60) + $minutes;

    $totalComputedValue = 0.002 * $totalMinutes * 1.0416667;

    $sqlFetchLatestLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? ORDER BY period DESC LIMIT 1";

    $stmtFetchLatestLeaveData = $database->prepare($sqlFetchLatestLeaveData);

    if ($stmtFetchLatestLeaveData) {

        $stmtFetchLatestLeaveData->bind_param("s", $empId);

        $stmtFetchLatestLeaveData->execute();
        $resultFetchLatestLeaveData = $stmtFetchLatestLeaveData->get_result();

        if ($resultFetchLatestLeaveData->num_rows > 0) {
            $LatestLeaveData = $resultFetchLatestLeaveData->fetch_assoc();

            $newVacationLeaveEarned = $LatestLeaveData['vacationLeaveEarned'];
            $newVacationLeaveAbsUndWP = $LatestLeaveData['vacationLeaveAbsUndWP'];
            $newVacationLeaveBalance = $LatestLeaveData['vacationLeaveBalance'];
            $newVacationLeaveAbsUndWOP = $LatestLeaveData['vacationLeaveAbsUndWOP'];

            $newSickLeaveEarned = $LatestLeaveData['sickLeaveEarned'];
            $newSickLeaveAbsUndWP = $LatestLeaveData['sickLeaveAbsUndWP'];
            $newSickLeaveBalance = $LatestLeaveData['sickLeaveBalance'];
            $newSickLeaveAbsUndWOP = $LatestLeaveData['sickLeaveAbsUndWOP'];

            if ($particularType == "Vacation Leave" || $particularType == "Late") {
                $newVacationLeaveEarned = $LatestLeaveData['vacationLeaveBalance'];
                if ($LatestLeaveData['vacationLeaveBalance'] <= $totalComputedValue) {
                    $newVacationLeaveAbsUndWP = $LatestLeaveData['vacationLeaveBalance'];
                    $newVacationLeaveBalance = 0;
                    $newVacationLeaveAbsUndWOP = $LatestLeaveData['vacationLeaveAbsUndWOP'] + ($totalComputedValue - $LatestLeaveData['vacationLeaveBalance']);
                } else {
                    $newVacationLeaveAbsUndWP = $totalComputedValue;
                    $newVacationLeaveBalance = $LatestLeaveData['vacationLeaveBalance'] - $totalComputedValue;
                    $newVacationLeaveAbsUndWOP = $LatestLeaveData['vacationLeaveAbsUndWOP'];
                }
            }

            if ($particularType == "Sick Leave") {
                $newSickLeaveEarned = $LatestLeaveData['sickLeaveBalance'];
                if ($LatestLeaveData['sickLeaveBalance'] <= $totalComputedValue) {
                    $newSickLeaveAbsUndWP = $LatestLeaveData['sickLeaveBalance'];
                    $newSickLeaveBalance = 0;
                    $newSickLeaveAbsUndWOP = $LatestLeaveData['sickLeaveAbsUndWOP'] + ($totalComputedValue - $LatestLeaveData['sickLeaveBalance']);
                } else {
                    $newSickLeaveAbsUndWP = $totalComputedValue;
                    $newSickLeaveBalance = $LatestLeaveData['sickLeaveBalance'] - $totalComputedValue;
                    $newSickLeaveAbsUndWOP = $LatestLeaveData['sickLeaveAbsUndWOP'];
                }
            }

            $insertLeaveDataQuery = "INSERT INTO tbl_leavedataform 
    (employee_id, dateCreated, period, periodEnd, particular, particularLabel, days, hours, minutes, vacationLeaveEarned, 
    vacationLeaveAbsUndWP, vacationLeaveBalance, vacationLeaveAbsUndWOP, sickLeaveEarned, sickLeaveAbsUndWP, 
    sickLeaveBalance, sickLeaveAbsUndWOP, dateOfAction, dateLastModified)
    VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())";

            $stmtInsertLeaveData = $database->prepare($insertLeaveDataQuery);

            if ($stmtInsertLeaveData) {
                $stmtInsertLeaveData->bind_param(
                    "sssssiiidddddddds",
                    $empId,
                    $period,
                    $periodEnd,
                    $particularType,
                    $particularLabel,
                    $days,
                    $hours,
                    $minutes,
                    $newVacationLeaveEarned,
                    $newVacationLeaveAbsUndWP,
                    $newVacationLeaveBalance,
                    $newVacationLeaveAbsUndWOP,
                    $newSickLeaveEarned,
                    $newSickLeaveAbsUndWP,
                    $newSickLeaveBalance,
                    $newSickLeaveAbsUndWOP,
                    $dateOfAction
                );

                $stmtInsertLeaveData->execute();
                $stmtInsertLeaveData->close();
            }

        } else {
            $newVacationLeaveEarned = $initialValue;
            $newVacationLeaveBalance = $initialValue;

            $newSickLeaveEarned = $initialValue;
            $newSickLeaveBalance = $initialValue;

            if ($particularType == "Vacation Leave" || $particularType == "Late") {
                $newVacationLeaveEarned = $initialValue;
                if ($initialValue <= $totalComputedValue) {
                    $newVacationLeaveAbsUndWP = $initialValue;
                    $newVacationLeaveBalance = 0;
                    $newVacationLeaveAbsUndWOP = 0 + ($totalComputedValue - $initialValue);
                } else {
                    $newVacationLeaveAbsUndWP = $totalComputedValue;
                    $newVacationLeaveBalance = $initialValue - $totalComputedValue;
                    $newVacationLeaveAbsUndWOP = 0;
                }
            }

            if ($particularType == "Sick Leave") {
                $newSickLeaveEarned = $initialValue;
                if ($initialValue <= $totalComputedValue) {
                    $newSickLeaveAbsUndWP = $initialValue;
                    $newSickLeaveBalance = 0;
                    $newSickLeaveAbsUndWOP = 0 + ($totalComputedValue - $initialValue);
                } else {
                    $newSickLeaveAbsUndWP = $totalComputedValue;
                    $newSickLeaveBalance = $initialValue - $totalComputedValue;
                    $newSickLeaveAbsUndWOP = 0;
                }
            }

            $insertLeaveDataQuery = "INSERT INTO tbl_leavedataform 
    (employee_id, dateCreated, period, periodEnd, particular, particularLabel, days, hours, minutes, vacationLeaveEarned, 
    vacationLeaveAbsUndWP, vacationLeaveBalance, vacationLeaveAbsUndWOP, sickLeaveEarned, sickLeaveAbsUndWP, 
    sickLeaveBalance, sickLeaveAbsUndWOP, dateOfAction, dateLastModified)
    VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())";

            $stmtInsertLeaveData = $database->prepare($insertLeaveDataQuery);

            if ($stmtInsertLeaveData) {
                $stmtInsertLeaveData->bind_param(
                    "sssssiiidddddddds",
                    $empId,
                    $period,
                    $periodEnd,
                    $particularType,
                    $particularLabel,
                    $days,
                    $hours,
                    $minutes,
                    $newVacationLeaveEarned,
                    $newVacationLeaveAbsUndWP,
                    $newVacationLeaveBalance,
                    $newVacationLeaveAbsUndWOP,
                    $newSickLeaveEarned,
                    $newSickLeaveAbsUndWP,
                    $newSickLeaveBalance,
                    $newSickLeaveAbsUndWOP,
                    $dateOfAction
                );

                $stmtInsertLeaveData->execute();
                $stmtInsertLeaveData->close();
            }

        }
        $stmtFetchLatestLeaveData->close();
    } else {
        // Something went wrong with the statement preparation
    }

    header("Location: " . $location_admin_employeelist_leavedataform . '/' . $empId . '/');
} else {
    header("Location: " . $location_admin_employeelist_leavedataform . '/' . $empId . '/');
}
?>