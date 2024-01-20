<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['addEmployee'])) {
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
    $departmentlabel = strip_tags(mysqli_real_escape_string($database, $_POST['departmentlabel']));
    $role = strip_tags(mysqli_real_escape_string($database, $_POST["role"]));
    $email = strip_tags(mysqli_real_escape_string($database, $_POST["email"]));
    $password = strip_tags(mysqli_real_escape_string($database, $_POST['password']));
    $firstName = strip_tags(mysqli_real_escape_string($database, $_POST["firstName"]));
    $middleName = strip_tags(mysqli_real_escape_string($database, $_POST["middleName"]));
    $lastName = strip_tags(mysqli_real_escape_string($database, $_POST["lastName"]));
    $suffix = strip_tags(mysqli_real_escape_string($database, $_POST["suffix"]));
    $age = strip_tags(mysqli_real_escape_string($database, $_POST["age"]));
    $sex = strip_tags(mysqli_real_escape_string($database, $_POST["sex"]));
    $civilStatus = strip_tags(mysqli_real_escape_string($database, $_POST["civilStatus"]));
    $department = strip_tags(mysqli_real_escape_string($database, $_POST["department"]));
    $jobPosition = strip_tags(mysqli_real_escape_string($database, $_POST["jobPosition"]));
    $dateStarted = strip_tags(mysqli_real_escape_string($database, $_POST["dateStarted"]));
    $initialVacationCredit = strip_tags(mysqli_real_escape_string($database, $_POST["initialVacationCredit"]));
    $initialSickCredit = strip_tags(mysqli_real_escape_string($database, $_POST["initialSickCredit"]));

    // Variables that are required in conditioning of Automatic Initial Record
    $previousLeaveData = [];
    $today = date("Y-m-d");

    $proceedCreation = false;
    $hasPreviousRecord = false;

    $dataRecordType = "Initial Record";
    $initialDateStart = $dateStarted;
    $initialDateEnd = $today;
    $particularLabel = "";
    $vacationBalance = $initialVacationCredit;
    $vacationUnderWOPay = 0;
    $sickBalance = $initialSickCredit;
    $sickUnderWOPay = 0;
    $dateOfAction = $today;

    // if ($departmentlabel) {
    //     $_SESSION['departmentlabel'] = $departmentlabel;
    // }

    try {
        $query = "INSERT INTO tbl_useraccounts 
                  (employee_id, role, email, password, firstName, middleName, lastName, suffix, age, sex, civilStatus, department, jobPosition, dateStarted, dateCreated) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($database, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssisssss", $employeeId, $role, $email, $password, $firstName, $middleName, $lastName, $suffix, $age, $sex, $civilStatus, $department, $jobPosition, $dateStarted);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "New Employee Successfully Created";
            $_SESSION['alert_type'] = $success_color;

            // Create an Initial Record in Leave Data Form Based on Date Started

            $sqlFetchPreviousLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND (period <= ? OR periodEnd <= ?) AND recordType != ? ORDER BY period DESC, dateCreated DESC LIMIT 1";

            $stmtFetchPreviousLeaveData = $database->prepare($sqlFetchPreviousLeaveData);
            $stmtFetchPreviousLeaveData->bind_param("ssss", $employeeId, $initialDateStart, $initialDateEnd, $dataRecordType);
            $stmtFetchPreviousLeaveData->execute();

            $resultFetchPreviousLeaveData = $stmtFetchPreviousLeaveData->get_result();

            if ($resultFetchPreviousLeaveData->num_rows > 0) {
                $previousLeaveData = $resultFetchPreviousLeaveData->fetch_assoc();
                if ($previousLeaveData['period'] < $initialDateStart) {
                    $_SESSION['alert_message'] = "Employee Successfully Added But Initial Record Failed due to Date Started";
                    $_SESSION['alert_type'] = $warning_color;
                    $proceedCreation = false;
                }else if($previousLeaveData['period'] >= $initialDateStart && $previousLeaveData['periodEnd'] <= $initialDateEnd){
                    $initialDateEnd = $previousLeaveData['periodEnd'];
                    $hasPreviousRecord = true;
                    $proceedCreation = true;
                }
                // $hasPreviousRecord = true;
                // $_SESSION['alert_message'] = "Initialization is Set from ".$dateStarted." and Before: " . $previousLeaveData['period'];
                // $_SESSION['alert_type'] = $warning_color;
            }else{
                $proceedCreation = true;
            }

            if($proceedCreation) {
                // Check if an Initial Record already exists for the specified employee and year
                $checkQuery = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND recordType = ?";
                $checkStmt = mysqli_prepare($database, $checkQuery);
                mysqli_stmt_bind_param($checkStmt, "ss", $employeeId, $dataRecordType);
                mysqli_stmt_execute($checkStmt);
                mysqli_stmt_store_result($checkStmt);

                if (mysqli_stmt_num_rows($checkStmt) > 0) {
                    // Record already exists, perform an update
                    $updateQuery = "UPDATE tbl_leavedataform 
                        SET period = ?, periodEnd = ?, particularLabel = ?, 
                            vacationLeaveEarned = ?, vacationLeaveBalance = ?, vacationLeaveAbsUndWOP = ?,
                            sickLeaveEarned = ?, sickLeaveBalance = ?, sickLeaveAbsUndWOP = ?, dateOfAction = ? 
                        WHERE employee_id = ? AND recordType = 'Initial Record'";

                    $updateStmt = mysqli_prepare($database, $updateQuery);
                    mysqli_stmt_bind_param(
                        $updateStmt,
                        "ssddddddsss",
                        $initialDateStart,
                        $initialDateEnd,
                        $particularLabel,
                        $vacationBalance,
                        $vacationBalance,
                        $vacationUnderWOPay,
                        $sickBalance,
                        $sickBalance,
                        $sickUnderWOPay,
                        $dateOfAction,
                        $employeeId,
                    );

                    if (mysqli_stmt_execute($updateStmt)) {
                        // Update successful
                        $_SESSION['alert_message'] = "Employee and Initial Record Successfully Updated!";
                        $_SESSION['alert_type'] = $success_color;
                    } else {
                        // Update failed
                        // $_SESSION['alert_message'] = "Initialization Update Failed: " . mysqli_stmt_error($updateStmt);
                        $_SESSION['alert_message'] = "Employee Added Successfully but Initialization Update Failed!";
                        $_SESSION['alert_type'] = $warning_color;
                    }
                } else {
                    $query = "  INSERT INTO tbl_leavedataform 
                  (employee_id, dateCreated, recordType, period, periodEnd, particular, particularLabel,
                  vacationLeaveEarned, vacationLeaveBalance, vacationLeaveAbsUndWOP,
                  sickLeaveEarned, sickLeaveBalance, sickLeaveAbsUndWOP, dateOfAction) 
                VALUES (?, CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = mysqli_prepare($database, $query);
                    mysqli_stmt_bind_param(
                        $stmt,
                        "ssssssdddddds",
                        $employeeId,
                        $dataRecordType,
                        $initialDateStart,
                        $initialDateEnd,
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
                        $_SESSION['alert_message'] = "Employee and Initialization Successfully Created";
                        $_SESSION['alert_type'] = $success_color;
                    } else {
                        // $_SESSION['alert_message'] = "Initialization Successfully Failed: " . mysqli_stmt_error($stmt);
                        // $_SESSION['alert_type'] = $error_color;
                        $_SESSION['alert_message'] = "Employee Added Successfully but Initialization Failed!";
                        $_SESSION['alert_type'] = $warning_color;
                    }
                }
            }

            if ($departmentlabel) {
                header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
            } else {
                header("Location: " . $location_admin_departments_office);
            }
            exit();
        } else {
            $_SESSION['alert_message'] = "Error updating employee with ID $employeeId: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }
    } catch (Exception $e) {
        $_SESSION['alert_message'] = "An error occurred: " . $e->getMessage();
        $_SESSION['alert_type'] = $error_color;
        header("Location: " . $_SERVER['PHP_SELF']);
        if ($departmentlabel) {
            header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
        } else {
            header("Location: " . $location_admin_departments_office);
        }
        exit();
        // throw new Exception("Database query failed: " . mysqli_error($database));
    }
    if ($departmentlabel) {
        header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    if ($departmentlabel) {
        header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
    exit();
}

?>