<?php
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['editLeaveDataRecord'])) {
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

    $_SESSION['alert_message'] = "Not Yet Available!";
    $_SESSION['alert_type'] = $warning_color;

    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
} else {
    $_SESSION['alert_message'] = "Not Yet Available!";
    $_SESSION['alert_type'] = $warning_color;
    header("Location: " . $location_admin_departments_employee_leavedataform . '/' . $empId . '/');
}
?>