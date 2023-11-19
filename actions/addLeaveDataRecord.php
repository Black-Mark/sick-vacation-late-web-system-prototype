<?php
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['addLeaveDataRecord'])) {
    $newLeaveData = [];
    // Function to apply strip_tags and mysqli_real_escape_string
    function sanitizeInput($input)
    {
        global $database;
        return mysqli_real_escape_string($database, strip_tags($input));
    }

    $empId = isset($_POST['empId']) ? sanitizeInput($_POST['empId']) : null;
    $period = isset($_POST['period']) ? sanitizeInput($_POST['period']) : null;
    $particularType = isset($_POST['particularType']) ? sanitizeInput($_POST['particularType']) : null;
    $particularLabel = isset($_POST['particularLabel']) ? sanitizeInput($_POST['particularLabel']) : null;
    $days = isset($_POST['dayInput']) ? sanitizeInput($_POST['dayInput']) : null;
    $hours = isset($_POST['hourInput']) ? sanitizeInput($_POST['hourInput']) : null;
    $minutes = isset($_POST['minuteInput']) ? sanitizeInput($_POST['minuteInput']) : null;
    $inputType = isset($_POST['inputType']) ? sanitizeInput($_POST['inputType']) : null;
    $dateOfAction = isset($_POST['dateOfAction']) ? sanitizeInput($_POST['dateOfAction']) : null;
    
    $totalMinutes = (($days * 24) * 60) + ($hours * 60) + $minutes;

    $totalComputedValue = 0.002 * $totalMinutes * 1.0416667;

    // Fetch the latest result of earned Vacation or Sick Leave based on ParticularType
    $sqlFetchLatestLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND particular = ? ORDER BY period DESC LIMIT 1";
    $stmtFetchLatestLeaveData = $database->prepare($sqlFetchLatestLeaveData);

    if ($stmtFetchLatestLeaveData) {
        $stmtFetchLatestLeaveData->bind_param("ss", $empId, $particularType);
        $stmtFetchLatestLeaveData->execute();
        $resultFetchLatestLeaveData = $stmtFetchLatestLeaveData->get_result();

        if ($resultFetchLatestLeaveData->num_rows > 0) {
            $LatestLeaveDataData = $resultFetchLatestLeaveData->fetch_assoc();
            echo $LatestLeaveDataData['vacationLeaveEarned'];
            
        } else {
            // No previous earned data found for the particular type
        }

        $stmtFetchLatestLeaveData->close();
    } else {
        // Something went wrong with the statement preparation
    }
}
?>