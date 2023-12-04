<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);
include($constants_variables);

if (isset($_POST['submitLeaveAppForm']) && isset($_SESSION['employeeId'])) {
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_SESSION['employeeId']));
    $departmentName = strip_tags(mysqli_real_escape_string($database, $_POST['departmentName']));
    $lastName = strip_tags(mysqli_real_escape_string($database, $_POST['lastName']));
    $firstName = strip_tags(mysqli_real_escape_string($database, $_POST['firstName']));
    $middleName = strip_tags(mysqli_real_escape_string($database, $_POST['middleName']));
    $dateFiling = strip_tags(mysqli_real_escape_string($database, $_POST['dateFiling']));
    $position = strip_tags(mysqli_real_escape_string($database, $_POST['position']));
    $salary = strip_tags(mysqli_real_escape_string($database, $_POST['salary']));
    $typeOfLeave = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfLeave']));
    $typeOfSpecifiedOtherLeave = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfSpecifiedOtherLeave']));
    $typeOfVacationLeave = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfVacationLeave']));
    $typeOfVacationLeaveWithin = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfVacationLeaveWithin']));
    $typeOfVacationLeaveAbroad = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfVacationLeaveAbroad']));
    $typeOfSickLeave = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfSickLeave']));
    $typeOfSickLeaveInHospital = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfSickLeaveInHospital']));
    $typeOfSickLeaveOutPatient = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfSickLeaveOutPatient']));
    $typeOfSpecialLeaveForWomen = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfSpecialLeaveForWomen']));
    $typeOfStudyLeave = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfStudyLeave']));
    $typeOfOtherLeave = strip_tags(mysqli_real_escape_string($database, $_POST['typeOfOtherLeave']));
    $workingDays = strip_tags(mysqli_real_escape_string($database, $_POST['workingDays']));
    $inclusiveDates = strip_tags(mysqli_real_escape_string($database, $_POST['inclusiveDates']));
    $commutation = strip_tags(mysqli_real_escape_string($database, $_POST['commutation']));
    $asOfDate = strip_tags(mysqli_real_escape_string($database, $_POST['asOfDate']));
    $vacationLeaveTotalEarned = strip_tags(mysqli_real_escape_string($database, $_POST['vacationLeaveTotalEarned']));
    $sickLeaveTotalEarned = strip_tags(mysqli_real_escape_string($database, $_POST['sickLeaveTotalEarned']));
    $vacationLeaveLess = strip_tags(mysqli_real_escape_string($database, $_POST['vacationLeaveLess']));
    $sickLeaveLess = strip_tags(mysqli_real_escape_string($database, $_POST['sickLeaveLess']));
    $vacationLeaveBalance = strip_tags(mysqli_real_escape_string($database, $_POST['vacationLeaveBalance']));
    $sickLeaveBalance = strip_tags(mysqli_real_escape_string($database, $_POST['sickLeaveBalance']));
    $recommendation = strip_tags(mysqli_real_escape_string($database, $_POST['recommendation']));
    $recommendMessage = strip_tags(mysqli_real_escape_string($database, $_POST['recommendMessage']));
    $dayWithPay = strip_tags(mysqli_real_escape_string($database, $_POST['dayWithPay']));
    $dayWithoutPay = strip_tags(mysqli_real_escape_string($database, $_POST['dayWithoutPay']));
    $otherDayPay = strip_tags(mysqli_real_escape_string($database, $_POST['otherDayPay']));
    $otherDaySpecify = strip_tags(mysqli_real_escape_string($database, $_POST['otherDaySpecify']));
    $disapprovedMessage = strip_tags(mysqli_real_escape_string($database, $_POST['disapprovedMessage']));
    $status = 'Submitted';

    try {
        $query = "INSERT INTO tbl_leaveappform
          (employee_id, departmentName, lastName, firstName, middleName, dateFiling, position, salary,
          typeOfLeave, typeOfSpecifiedOtherLeave, typeOfVacationLeave, typeOfVacationLeaveWithin, typeOfVacationLeaveAbroad,
          typeOfSickLeave, typeOfSickLeaveInHospital, typeOfSickLeaveOutPatient, typeOfSpecialLeaveForWomen, typeOfStudyLeave,
          typeOfOtherLeave, workingDays, inclusiveDates, commutation,
          asOfDate, vacationLeaveTotalEarned, sickLeaveTotalEarned, vacationLeaveLess, sickLeaveLess,
          vacationLeaveBalance, sickLeaveBalance, recommendation, recommendMessage,
          dayWithPay, dayWithoutPay, otherDayPay, otherDaySpecify, disapprovedMessage, status)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($database, $query);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssssssssisssddddddssiiisss",
            $employeeId,
            $departmentName,
            $lastName,
            $firstName,
            $middleName,
            $dateFiling,
            $position,
            $salary,
            $typeOfLeave,
            $typeOfSpecifiedOtherLeave,
            $typeOfVacationLeave,
            $typeOfVacationLeaveWithin,
            $typeOfVacationLeaveAbroad,
            $typeOfSickLeave,
            $typeOfSickLeaveInHospital,
            $typeOfSickLeaveOutPatient,
            $typeOfSpecialLeaveForWomen,
            $typeOfStudyLeave,
            $typeOfOtherLeave,
            $workingDays,
            $inclusiveDates,
            $commutation,
            $asOfDate,
            $vacationLeaveTotalEarned,
            $sickLeaveTotalEarned,
            $vacationLeaveLess,
            $sickLeaveLess,
            $vacationLeaveBalance,
            $sickLeaveBalance,
            $recommendation,
            $recommendMessage,
            $dayWithPay,
            $dayWithoutPay,
            $otherDayPay,
            $otherDaySpecify,
            $disapprovedMessage,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "Leave Application Form Successfully Created";
            $_SESSION['alert_type'] = $success_color;

            $notifEmpIdFrom = $_SESSION['employeeId'];
            $notifEmpIdTo = '@Admin';
            $notifSubject = $_SESSION['role'] . ' Submission of Leave Form';

            $notifMessage = $_SESSION['username'] . ' is Applying For ' . $typeOfLeave;
            $notifLink = $location_admin_leaveapplist;
            $notifSeen = 'unread';

            $queryNotif = "INSERT INTO tbl_notifications (dateCreated, empIdFrom, empIdTo, subject, message, link, seen) VALUES (CURRENT_TIMESTAMP(), ?, ?, ?, ?, ?, ?)";
            $stmtNotif = mysqli_prepare($database, $queryNotif);

            // Bind parameters
            mysqli_stmt_bind_param($stmtNotif, "ssssss", $notifEmpIdFrom, $notifEmpIdTo, $notifSubject, $notifMessage, $notifLink, $notifSeen);

            // Execute the statement
            mysqli_stmt_execute($stmtNotif);

            header("Location: " . $_SERVER['PHP_SELF']);
            header("Location: " . $location_employee_leave_form);
            exit();
        } else {
            $_SESSION['alert_message'] = "Error submitting Leave Application Form: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }
    } catch (Exception $e) {
        $_SESSION['alert_message'] = "An error occurred: " . $e->getMessage();
        $_SESSION['alert_type'] = $error_color;
        header("Location: " . $_SERVER['PHP_SELF']);
        header("Location: " . $location_employee_leave_form);
        exit();
        // throw new Exception("Database query failed: " . mysqli_error($database));
    }
} else {
    echo '<script type="text/javascript">window.history.back();</script>';
    header("Location: " . $location_employee_leave_form);
    exit();
}
?>