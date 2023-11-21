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

    $arrayLeaveDataRecord = [];

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
    $dateOfAction = isset($_POST['dateOfAction']) ? sanitizeInput($_POST['dateOfAction']) : null;

    if ($selectedYear) {
        $_SESSION['post_dataformyear'] = $selectedYear;
    }

    $totalMinutes = (($days * 8) * 60) + ($hours * 60) + $minutes;

    $totalVacationComputedValue = 0;
    $totalSickComputedValue = 0;

    if ($particularType == "Sick Leave") {
        $totalSickComputedValue = 0.002 * $totalMinutes * 1.0416667;
    } else if ($particularType == "Vacation Leave" || $particularType == "Late") {
        $totalVacationComputedValue = 0.002 * $totalMinutes * 1.0416667;
    }

    $sqlFetchLatestLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND period <= ? ORDER BY period DESC, dateCreated DESC LIMIT 1";

    $stmtFetchLatestLeaveData = $database->prepare($sqlFetchLatestLeaveData);

    if ($stmtFetchLatestLeaveData) {

        $stmtFetchLatestLeaveData->bind_param("ss", $empId, $period);

        $stmtFetchLatestLeaveData->execute();
        $resultFetchLatestLeaveData = $stmtFetchLatestLeaveData->get_result();

        if ($resultFetchLatestLeaveData->num_rows > 0) {
            $LatestLeaveData = $resultFetchLatestLeaveData->fetch_assoc();
            $newVacationLeaveEarned = $LatestLeaveData['vacationLeaveBalance'];
            $newSickLeaveEarned = $LatestLeaveData['sickLeaveBalance'];
            $newVacationLeaveBalance = $LatestLeaveData['vacationLeaveBalance'];
            $newSickLeaveBalance = $LatestLeaveData['sickLeaveBalance'];
            $newVacationLeaveAbsUndWOP = $LatestLeaveData['vacationLeaveAbsUndWOP'];
            $newSickLeaveAbsUndWOP = $LatestLeaveData['sickLeaveAbsUndWOP'];

            if ($particularType == "Vacation Leave" || $particularType == "Late") {
                if ($LatestLeaveData['vacationLeaveBalance'] <= $totalVacationComputedValue) {
                    $newVacationLeaveAbsUndWP = $LatestLeaveData['vacationLeaveBalance'];
                    $newVacationLeaveBalance = 0;
                    $newVacationLeaveAbsUndWOP = $LatestLeaveData['vacationLeaveAbsUndWOP'] + ($totalVacationComputedValue - $LatestLeaveData['vacationLeaveBalance']);
                } else {
                    $newVacationLeaveAbsUndWP = $totalVacationComputedValue;
                    $newVacationLeaveBalance = $LatestLeaveData['vacationLeaveBalance'] - $totalVacationComputedValue;
                    $newVacationLeaveAbsUndWOP = $LatestLeaveData['vacationLeaveAbsUndWOP'];
                }
            }

            if ($particularType == "Sick Leave") {
                if ($LatestLeaveData['sickLeaveBalance'] <= $totalSickComputedValue) {
                    $newSickLeaveAbsUndWP = $LatestLeaveData['sickLeaveBalance'];
                    $newSickLeaveBalance = 0;
                    $newSickLeaveAbsUndWOP = $LatestLeaveData['sickLeaveAbsUndWOP'] + ($totalSickComputedValue - $LatestLeaveData['sickLeaveBalance']);
                } else {
                    $newSickLeaveAbsUndWP = $totalSickComputedValue;
                    $newSickLeaveBalance = $LatestLeaveData['sickLeaveBalance'] - $totalSickComputedValue;
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

                if (mysqli_stmt_execute($stmtInsertLeaveData)) {
                    $_SESSION['alert_message'] = "Leave Data Record Successfully Added!";
                    $_SESSION['alert_type'] = $success_color;
                } else {
                    $_SESSION['alert_message'] = "Error updating employee with ID $employeeId: " . mysqli_stmt_error($stmtInsertLeaveData);
                    $_SESSION['alert_type'] = $error_color;
                }

                // $stmtInsertLeaveData->close();
            }

        } else {
            $newVacationLeaveEarned = $initialValue;
            $newVacationLeaveBalance = $initialValue;

            $newSickLeaveEarned = $initialValue;
            $newSickLeaveBalance = $initialValue;

            if ($particularType == "Vacation Leave" || $particularType == "Late") {
                $newVacationLeaveEarned = $initialValue;
                if ($initialValue <= $totalVacationComputedValue) {
                    $newVacationLeaveAbsUndWP = $initialValue;
                    $newVacationLeaveBalance = 0;
                    $newVacationLeaveAbsUndWOP = 0 + ($totalVacationComputedValue - $initialValue);
                } else {
                    $newVacationLeaveAbsUndWP = $totalVacationComputedValue;
                    $newVacationLeaveBalance = $initialValue - $totalVacationComputedValue;
                    $newVacationLeaveAbsUndWOP = 0;
                }
            }

            if ($particularType == "Sick Leave") {
                $newSickLeaveEarned = $initialValue;
                if ($initialValue <= $totalSickComputedValue) {
                    $newSickLeaveAbsUndWP = $initialValue;
                    $newSickLeaveBalance = 0;
                    $newSickLeaveAbsUndWOP = 0 + ($totalSickComputedValue - $initialValue);
                } else {
                    $newSickLeaveAbsUndWP = $totalSickComputedValue;
                    $newSickLeaveBalance = $initialValue - $totalSickComputedValue;
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

                if (mysqli_stmt_execute($stmtInsertLeaveData)) {
                    $_SESSION['alert_message'] = "Leave Data Record Successfully Added!";
                    $_SESSION['alert_type'] = $success_color;
                } else {
                    $_SESSION['alert_message'] = "Error updating employee with ID $employeeId: " . mysqli_stmt_error($stmtInsertLeaveData);
                    $_SESSION['alert_type'] = $error_color;
                }

                // $stmtInsertLeaveData->close();
            }

        }
        // $stmtFetchLatestLeaveData->close();
    } else {
        // Something went wrong with the statement preparation
    }

    // Now, retrieve all rows next to the added data
    $sqlGetNextData = " SELECT * FROM tbl_leavedataform 
                        WHERE employee_id = ? 
                        AND period >= ? 
                        ORDER BY period ASC, dateCreated ASC"; // Assuming dateCreated is the timestamp indicating the order

    $stmtNext = $database->prepare($sqlGetNextData);

    if ($stmtNext) {
        $stmtNext->bind_param("ss", $empId, $period);
        $stmtNext->execute();

        $resultNext = $stmtNext->get_result();

        while ($rowNext = $resultNext->fetch_assoc()) {
            $arrayLeaveDataRecord[] = $rowNext;
        }

        for ($i = 0; $i < count($arrayLeaveDataRecord); $i++) {
            // echo $arrayLeaveDataRecord[$i]['particular'];
            // echo '<br>';
            if ($i == 0) {
                //Does not do Something
            } else {
                $totalMinutes = 0;
                $totalMinutes = (($arrayLeaveDataRecord[$i]['days'] * 8) * 60) + ($arrayLeaveDataRecord[$i]['hours'] * 60) + $arrayLeaveDataRecord[$i]['minutes'];

                $totalVacationComputedValue = 0;
                $totalSickComputedValue = 0;

                if ($arrayLeaveDataRecord[$i]['particular'] == "Sick Leave") {
                    $totalSickComputedValue = 0.002 * $totalMinutes * 1.0416667;
                } else if ($arrayLeaveDataRecord[$i]['particular'] == "Vacation Leave" || $arrayLeaveDataRecord[$i]['particular'] == "Late") {
                    $totalVacationComputedValue = 0.002 * $totalMinutes * 1.0416667;
                }

                $tempVacationBalance = $arrayLeaveDataRecord[$i - 1]['vacationLeaveBalance'];
                $arrayLeaveDataRecord[$i]['vacationLeaveEarned'] = $tempVacationBalance;
                $tempSickBalance = $arrayLeaveDataRecord[$i - 1]['sickLeaveBalance'];
                $arrayLeaveDataRecord[$i]['sickLeaveEarned'] = $tempSickBalance;
                $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWOP'] = $arrayLeaveDataRecord[$i - 1]['vacationLeaveAbsUndWOP'];
                $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWOP'] = $arrayLeaveDataRecord[$i - 1]['sickLeaveAbsUndWOP'];
                $arrayLeaveDataRecord[$i]['vacationLeaveBalance'] = $tempVacationBalance;
                $arrayLeaveDataRecord[$i]['sickLeaveBalance'] = $tempSickBalance;

                if ($arrayLeaveDataRecord[$i]['particular'] == "Vacation Leave" || $arrayLeaveDataRecord[$i]['particular'] == "Late") {
                    if ($tempVacationBalance <= $totalVacationComputedValue) {
                        $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWP'] = $tempVacationBalance;
                        $arrayLeaveDataRecord[$i]['vacationLeaveBalance'] = 0;
                        $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWOP'] = $arrayLeaveDataRecord[$i - 1]['vacationLeaveAbsUndWOP'] + ($totalVacationComputedValue - $tempVacationBalance);
                    } else {
                        $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWP'] = $totalVacationComputedValue;
                        $arrayLeaveDataRecord[$i]['vacationLeaveBalance'] = $tempVacationBalance - $totalVacationComputedValue;
                        $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWOP'] = $arrayLeaveDataRecord[$i - 1]['vacationLeaveAbsUndWOP'];
                    }
                }

                if ($arrayLeaveDataRecord[$i]['particular'] == "Sick Leave") {
                    if ($tempSickBalance <= $totalSickComputedValue) {
                        $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWP'] = $tempSickBalance;
                        $arrayLeaveDataRecord[$i]['sickLeaveBalance'] = 0;
                        $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWOP'] = $arrayLeaveDataRecord[$i - 1]['sickLeaveAbsUndWOP'] + ($totalSickComputedValue - $tempSickBalance);
                    } else {
                        $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWP'] = $totalSickComputedValue;
                        $arrayLeaveDataRecord[$i]['sickLeaveBalance'] = $tempSickBalance - $totalSickComputedValue;
                        $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWOP'] = $arrayLeaveDataRecord[$i - 1]['sickLeaveAbsUndWOP'];
                    }
                }
            }

                $sqlUpdateData = "  UPDATE tbl_leavedataform 
                                    SET vacationLeaveEarned = ?, 
                                        vacationLeaveAbsUndWP = ?, 
                                        vacationLeaveBalance = ?, 
                                        vacationLeaveAbsUndWOP = ?, 
                                        sickLeaveEarned = ?, 
                                        sickLeaveAbsUndWP = ?, 
                                        sickLeaveBalance = ?, 
                                        sickLeaveAbsUndWOP = ?
                                    WHERE leavedataform_id = ? AND employee_id = ?";

                $stmtUpdate = $database->prepare($sqlUpdateData);

                if ($stmtUpdate) {
                    $stmtUpdate->bind_param(
                        "ddddddddss",
                        $arrayLeaveDataRecord[$i]['vacationLeaveEarned'],
                        $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWP'],
                        $arrayLeaveDataRecord[$i]['vacationLeaveBalance'],
                        $arrayLeaveDataRecord[$i]['vacationLeaveAbsUndWOP'],
                        $arrayLeaveDataRecord[$i]['sickLeaveEarned'],
                        $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWP'],
                        $arrayLeaveDataRecord[$i]['sickLeaveBalance'],
                        $arrayLeaveDataRecord[$i]['sickLeaveAbsUndWOP'],
                        $arrayLeaveDataRecord[$i]['leavedataform_id'],
                        $empId
                    );

                    $stmtUpdate->execute();
                }
        }

        // $stmtUpdate->close();

        // $stmtNext->close();
    } else {
        // Something Error
        // echo "Error!";
    }

    header("Location: " . $location_admin_employeelist_leavedataform . '/' . $empId . '/');
} else {
    header("Location: " . $location_admin_employeelist_leavedataform . '/' . $empId . '/');
}
?>