<?php
// For Notification
$success_color = "#03ab00";
$warning_color = "#fca100";
$error_color = "#730000";

// I forgot what it does
// $start_year = 2019;

// For Leave Data Form
$monthReset = true;
$idGeneration = "12345678901234567890";
$vacationLeaveMonthlyCredit = 1.25;
$sickLeaveMonthlyCredit = 1.25;

// Function to Apply strip_tags and mysqli_real_escape_string
function sanitizeInput($input)
{
    global $database;
    return mysqli_real_escape_string($database, strip_tags($input));
}

// Function to get the Full Name With Middle Initial and Suffix and Has Ordering
function organizeFullName($firstName = "", $middleName = "", $lastName = "", $suffix = "", $order = 1)
{
    $fullName = "";

    // Check if firstName, middleName, and lastName have data
    $firstName = trim($firstName);
    $middleName = trim($middleName);
    $lastName = trim($lastName);

    if (empty($firstName) && empty($middleName) && empty($lastName)) {
        return $fullName; // No data to organize
    }

    if ($order == 2) { // Order 2 = Last Sr., First M.
        $fullName = ($lastName ? $lastName . ' ' : '') . (!empty($suffix) ? $suffix . ' ' : '') . ($firstName ? $firstName . ' ' : '') . ($middleName ? substr($middleName, 0, 1) . '. ' : '');
    } else if ($order == 3) { // Order 3 = First Middle Last Sr.
        $fullName = ($firstName ? $firstName . ' ' : '') . ($middleName ? $middleName . ' ' : '') . ($lastName ? $lastName . ' ' : '') . (!empty($suffix) ? $suffix . ' ' : '');
    } else if ($order == 4) { // Order 4 = Last Sr., First Middle
        $fullName = ($lastName ? $lastName . ' ' : '') . (!empty($suffix) ? $suffix . ' ' : '') . ($firstName ? $firstName . ' ' : '') . ($middleName ? $middleName . ' ' : '');
    } else { // Order 1 = First M. Last Sr.
        $fullName = ($firstName ? $firstName . ' ' : '') . ($middleName ? substr($middleName, 0, 1) . '. ' : '') . ($lastName ? $lastName . ' ' : '') . (!empty($suffix) ? $suffix . ' ' : '');
    }

    return trim($fullName);
}

function identifyEmployeeAge($birthdate) {

    if (empty($birthdate) || $birthdate == '0000-00-00') {
        return 'Not Specified';
    }

    // Append a default time to the birthdate
    $birthdate .= ' 00:00:00';
    $birthDateTime = new DateTime($birthdate);
    
    $currentDate = new DateTime();
    $ageInterval = $currentDate->diff($birthDateTime);
    return $ageInterval->y;
}

// Function to Get Employee Data with Department Name and Department Head
function getEmployeeData($employee_id)
{

    global $database;

    $employeeData = [];

    $fetchEmployeeQuery = "SELECT
                ua.*,
                d.departmentName,
                d.departmentHead
            FROM
                tbl_useraccounts ua
            LEFT JOIN
                tbl_departments d ON ua.department = d.department_id
            WHERE
                ua.employee_id = ? AND UPPER(ua.archive) != 'DELETED'";

    $fetchEmployeeStatement = $database->prepare($fetchEmployeeQuery);

    if ($fetchEmployeeStatement) {
        $fetchEmployeeStatement->bind_param("s", $employee_id);
        $fetchEmployeeStatement->execute();
        $fetchEmpResult = $fetchEmployeeStatement->get_result();

        if ($fetchEmpResult->num_rows > 0) {
            $employeeData = $fetchEmpResult->fetch_assoc();
        }

        $fetchEmployeeStatement->close();
    }

    return $employeeData;
}

function getAccountRole($employeeId) {
    global $database;

    $employeeId = mysqli_real_escape_string($database, strip_tags($employeeId));
    $query = "SELECT role FROM tbl_useraccounts WHERE employee_id = '$employeeId'";
    $result = mysqli_query($database, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        return "User not found";
    }
    
    return mysqli_fetch_assoc($result)['role'];
}

function getAllDepartments()
{
    global $database;

    $departments = [];

    $fetchAllDepartmentQuery = "SELECT * FROM tbl_departments WHERE UPPER(archive) != 'DELETED'";

    $fetchAllDepartmentResult = $database->query($fetchAllDepartmentQuery);

    if ($fetchAllDepartmentResult->num_rows > 0) {
        while ($departmentData = $fetchAllDepartmentResult->fetch_assoc()) {
            $departments[] = $departmentData;
        }
    }

    return $departments;
}

function getAllEmployeesNameAndID()
{
    global $database;

    $employeesNameAndId = [];

    $fetchAllEmployeeNameAndIdQuery = " SELECT firstName, lastName, middleName, suffix, employee_id 
                                        FROM tbl_useraccounts
                                        WHERE UPPER(archive) != 'DELETED'
                                        ORDER BY lastName";
    $fetchAllEmployeeNameAndIdResult = $database->query($fetchAllEmployeeNameAndIdQuery);

    if ($fetchAllEmployeeNameAndIdResult) {
        $employeesNameAndId = mysqli_fetch_all($fetchAllEmployeeNameAndIdResult, MYSQLI_ASSOC);
        mysqli_free_result($fetchAllEmployeeNameAndIdResult);
    }

    return $employeesNameAndId;
}

function getAllDesignations()
{
    global $database;

    $designations = [];

    $fetchAllDesignationsQuery = "SELECT * FROM tbl_designations WHERE UPPER(archive) != 'DELETED' ORDER BY designationName";

    $fetchAllDesignationsResult = $database->query($fetchAllDesignationsQuery);

    if ($fetchAllDesignationsResult->num_rows > 0) {
        while ($designationData = $fetchAllDesignationsResult->fetch_assoc()) {
            $designations[] = $designationData;
        }
    }

    return $designations;
}

function getAllSettingData()
{
    global $database;

    $settingData = [];

    $settingQuery = "SELECT * FROM tbl_systemsettings
                    LEFT JOIN tbl_useraccounts ON tbl_useraccounts.employee_id = tbl_systemsettings.settingKey";
    $settingResult = mysqli_query($database, $settingQuery);

    if ($settingResult) {
        $settingData = mysqli_fetch_all($settingResult, MYSQLI_ASSOC);
        mysqli_free_result($settingResult);
    }

    return $settingData;
}

// Function to Get the Authorized User Like HR Manager and Municipal Mayor
function getAuthorizedUser()
{

    global $database;

    $settingData = [];

    $settingQuery = "SELECT * FROM tbl_systemsettings
                 LEFT JOIN tbl_useraccounts ON tbl_useraccounts.employee_id = tbl_systemsettings.settingKey WHERE settingType = 'Authorized User'";
    $settingResult = mysqli_query($database, $settingQuery);

    if ($settingResult) {
        $settingData = mysqli_fetch_all($settingResult, MYSQLI_ASSOC);
        mysqli_free_result($settingResult);
    }

    return $settingData;
}

// Get Leave App Record of Certain Employee
function getLeaveAppFormRecord($employee_id)
{
    global $database;

    $leaveAppRecordList = [];

    $leaveAppFormRecordQuery = "SELECT * FROM tbl_leaveappform WHERE employee_id = ? AND UPPER(archive) != 'DELETED'";

    $leaveAppFormRecordStatement = $database->prepare($leaveAppFormRecordQuery);
    $leaveAppFormRecordStatement->bind_param("s", $employee_id);
    $leaveAppFormRecordStatement->execute();

    $leaveAppRecordList = $leaveAppFormRecordStatement->get_result();

    return $leaveAppRecordList;
}

function getLeaveAppFormRecordBasedYear($employee_id, $year)
{
    global $database;

    $leaveAppRecordList = [];

    $leaveAppFormRecordQuery = "SELECT * FROM tbl_leaveappform WHERE employee_id = ? AND UPPER(archive) != 'DELETED' AND (YEAR(inclusiveDateStart) = ? OR YEAR(inclusiveDateEnd) = ?)";

    $leaveAppFormRecordStatement = $database->prepare($leaveAppFormRecordQuery);
    $leaveAppFormRecordStatement->bind_param("sss", $employee_id, $year, $year);
    $leaveAppFormRecordStatement->execute();

    $leaveAppRecordList = $leaveAppFormRecordStatement->get_result();

    return $leaveAppRecordList;
}

// Getting Data of Certain Leave Application Form of the Employee
function getEmployeeLeaveAppFormData($employee_id, $leaveappform_id)
{
    global $database;

    $leaveAppFormData = [];

    $fetchLeaveAppFormDataQuery = " SELECT
                                        laf.*,
                                        ua.department AS userDepartment,
                                        d.departmentName AS deptName
                                    FROM
                                        tbl_leaveappform laf
                                    LEFT JOIN
                                        tbl_useraccounts ua ON laf.employee_id = ua.employee_id
                                    LEFT JOIN
                                        tbl_departments d ON ua.department = d.departmentName
                                    WHERE
                                        laf.employee_id = ? AND
                                        UPPER(laf.archive) != 'DELETED' AND
                                        laf.leaveappform_id = ?";

    $fetchLeaveAppFormDataStatement = $database->prepare($fetchLeaveAppFormDataQuery);
    $fetchLeaveAppFormDataStatement->bind_param("si", $employee_id, $leaveappform_id);
    $fetchLeaveAppFormDataStatement->execute();

    $fetchLeaveAppFormDataResult = $fetchLeaveAppFormDataStatement->get_result();

    if ($fetchLeaveAppFormDataResult->num_rows > 0) {
        $leaveAppFormData = $fetchLeaveAppFormDataResult->fetch_assoc();
    }

    return $leaveAppFormData;
}

// Function To Get And Recompute Leave Data Records
function getIncentiveLeaveComputation($employee_id)
{
    global $database;
    global $success_color;
    global $warning_color;
    global $error_color;
    global $monthReset;
    global $idGeneration;
    global $vacationLeaveMonthlyCredit;
    global $sickLeaveMonthlyCredit;

    $fetchLeaveData = [];
    $fetchLeaveDataWithMontly = [];

    // Get all the Records
    $sqlFetchAllLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND UPPER(archive) != 'DELETED' ORDER BY period ASC, dateCreated ASC";
    $stmtsqlFetchAllLeaveData = $database->prepare($sqlFetchAllLeaveData);

    if ($stmtsqlFetchAllLeaveData) {
        $stmtsqlFetchAllLeaveData->bind_param("s", $employee_id);
        $stmtsqlFetchAllLeaveData->execute();
        $resultAllLeaveData = $stmtsqlFetchAllLeaveData->get_result();

        while ($rowLeaveData = $resultAllLeaveData->fetch_assoc()) {
            $fetchLeaveData[] = $rowLeaveData;
        }

        // Itong parte ang siyang nag-aadd ng bawat month simula sa periodEnd ng Initial Record patungo sa kasalukuyan

        $holdMonth = "";

        for ($i = 0; $i < count($fetchLeaveData); $i++) {
            if ($i == 0 && $fetchLeaveData[$i]['recordType'] == "Initial Record") {
                $fetchLeaveDataWithMontly[] = $fetchLeaveData[$i];
                if ($holdMonth == "") {
                    $currentDate = $fetchLeaveData[$i]['periodEnd'];
                    $date = new DateTime($currentDate);
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');
                } else {
                    $date = new DateTime();
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');
                }

                // if ($holdMonth > $fetchLeaveData[$i]['periodEnd']) {
                //     $monthEarnedArray = [
                //         'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $idGeneration,
                //         'employee_id' => $fetchLeaveData[$i]['employee_id'],
                //         'dateCreated' => $fetchLeaveData[$i]['dateCreated'],
                //         'recordType' => "Monthly Credit",
                //         'period' => $holdMonth,
                //         'periodEnd' => $holdMonth,
                //         'particular' => "Monthly Credit",
                //         'particularLabel' => "",
                //         'days' => 0,
                //         'hours' => 0,
                //         'minutes' => 0,
                //         'vacationLeaveEarned' => 0,
                //         'vacationLeaveAbsUndWP' => 0,
                //         'vacationLeaveBalance' => 0,
                //         'vacationLeaveAbsUndWOP' => 0,
                //         'sickLeaveEarned' => 0,
                //         'sickLeaveAbsUndWP' => 0,
                //         'sickLeaveBalance' => 0,
                //         'sickLeaveAbsUndWOP' => 0,
                //         'dateOfAction' => $holdMonth,
                //         'dateLastModified' => $holdMonth,
                //     ];
                //     $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                // }
            } else {
                if ($holdMonth != "") {
                    $iterate = 0;

                    // Updates the Initial Hold Month For Condition
                    // $currentDate = $holdMonth;
                    // $date = new DateTime($currentDate);
                    // $date->modify('first day of next month');
                    // $holdMonth = $date->format('Y-m-d');

                    // Condition If First Month Reaches The Record To Update Credit
                    while ($holdMonth <= $fetchLeaveData[$i]['period']) {
                        $monthEarnedArray = [
                            'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $iterate . $idGeneration,
                            'employee_id' => $fetchLeaveData[$i]['employee_id'],
                            'dateCreated' => $fetchLeaveData[$i]['dateCreated'],
                            'recordType' => "Monthly Credit",
                            'period' => $holdMonth,
                            'periodEnd' => $holdMonth,
                            'particular' => "Monthly Credit",
                            'particularLabel' => "",
                            'days' => 0,
                            'hours' => 0,
                            'minutes' => 0,
                            'vacationLeaveEarned' => 0,
                            'vacationLeaveAbsUndWP' => 0,
                            'vacationLeaveBalance' => 0,
                            'vacationLeaveAbsUndWOP' => 0,
                            'sickLeaveEarned' => 0,
                            'sickLeaveAbsUndWP' => 0,
                            'sickLeaveBalance' => 0,
                            'sickLeaveAbsUndWOP' => 0,
                            'dateOfAction' => $holdMonth,
                            'dateLastModified' => $holdMonth,
                        ];
                        $iterate = $iterate + 1;
                        $currentDate = $holdMonth;
                        $date = new DateTime($currentDate);
                        $date->modify('first day of next month');
                        $holdMonth = $date->format('Y-m-d');
                        $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                    }

                    // Adds the Data
                    $fetchLeaveDataWithMontly[] = $fetchLeaveData[$i];
                }
            }

            //Checks If It The Last Array Then Creates An Array of Credit Months Up to Date
            if ($i >= count($fetchLeaveData) - 1) {
                $today = (new DateTime())->format('Y-m-d');
                $iterate = 0;
                while ($holdMonth <= $today) {
                    $monthEarnedArray = [
                        'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $idGeneration . $iterate,
                        'employee_id' => $fetchLeaveData[$i]['employee_id'],
                        'dateCreated' => $fetchLeaveData[$i]['dateCreated'],
                        'recordType' => "Monthly Credit",
                        'period' => $holdMonth,
                        'periodEnd' => $holdMonth,
                        'particular' => "Monthly Credit",
                        'particularLabel' => "",
                        'days' => 0,
                        'hours' => 0,
                        'minutes' => 0,
                        'vacationLeaveEarned' => 0,
                        'vacationLeaveAbsUndWP' => 0,
                        'vacationLeaveBalance' => 0,
                        'vacationLeaveAbsUndWOP' => 0,
                        'sickLeaveEarned' => 0,
                        'sickLeaveAbsUndWP' => 0,
                        'sickLeaveBalance' => 0,
                        'sickLeaveAbsUndWOP' => 0,
                        'dateOfAction' => $holdMonth,
                        'dateLastModified' => $holdMonth,
                    ];
                    $iterate = $iterate + 1;
                    $currentDate = $holdMonth;
                    $date = new DateTime($currentDate);
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');
                    $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                }
            }

        }

        // Itong parte at siyang nagcocompute ng bawat data
        for ($i = 0; $i < count($fetchLeaveDataWithMontly); $i++) {
            if ($i == 0) {
                // Do Nothing
            } else {
                $totalMinutes = 0;
                $totalMinutes = (($fetchLeaveDataWithMontly[$i]['days'] * 8) * 60) + ($fetchLeaveDataWithMontly[$i]['hours'] * 60) + $fetchLeaveDataWithMontly[$i]['minutes'];

                $totalVacationComputedValue = 0;
                $totalSickComputedValue = 0;

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Sick Leave") {
                    $totalSickComputedValue = 0.002 * $totalMinutes * 1.0416667;
                } else if ($fetchLeaveDataWithMontly[$i]['particular'] == "Vacation Leave" || $fetchLeaveDataWithMontly[$i]['particular'] == "Late" || $fetchLeaveDataWithMontly[$i]['particular'] == "Forced Leave") {
                    $totalVacationComputedValue = 0.002 * $totalMinutes * 1.0416667;
                }

                $tempVacationBalance = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'];
                $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $tempVacationBalance;

                $tempSickBalance = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'];
                $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $tempSickBalance;

                $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'];
                $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'];
                $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $tempVacationBalance;
                $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $tempSickBalance;

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Vacation Leave" || $fetchLeaveDataWithMontly[$i]['particular'] == "Late" || $fetchLeaveDataWithMontly[$i]['particular'] == "Forced Leave") {
                    if ($tempVacationBalance <= $totalVacationComputedValue) {
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWP'] = $tempVacationBalance;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = 0;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'] + ($totalVacationComputedValue - $tempVacationBalance);
                    } else {
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWP'] = $totalVacationComputedValue;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $tempVacationBalance - $totalVacationComputedValue;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'];
                    }
                }

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Sick Leave") {
                    if ($tempSickBalance <= $totalSickComputedValue) {
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = $tempSickBalance;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = 0;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] + ($totalSickComputedValue - $tempSickBalance);
                    } else {
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = $totalSickComputedValue;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $tempSickBalance - $totalSickComputedValue;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'];
                    }
                }

                if ($fetchLeaveDataWithMontly[$i]['recordType'] == "Monthly Credit") {
                    if ($monthReset) {
                        if ($fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $vacationLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $vacationLeaveMonthlyCredit;
                        }

                        if ($fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $sickLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $sickLeaveMonthlyCredit;
                        }

                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = 0;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = 0;

                    } else {
                        if ($fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = 0;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWP'] = 0;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = 0;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'] - $vacationLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                        }

                        if ($fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] - $sickLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
                        }
                    }
                }
            }
        }

    }

    return $fetchLeaveDataWithMontly;
}

function getIncentiveLeaveComputationToday($employee_id)
{
    global $database;
    global $success_color;
    global $warning_color;
    global $error_color;
    global $monthReset;
    global $idGeneration;
    global $vacationLeaveMonthlyCredit;
    global $sickLeaveMonthlyCredit;

    $fetchLeaveData = [];
    $fetchLeaveDataWithMontly = [];

    // Get all the Records
    // $sqlFetchAllLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND UPPER(archive) != 'DELETED' ORDER BY period ASC, dateCreated ASC";
    $sqlFetchAllLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND UPPER(archive) != 'DELETED' AND period <= CURDATE() ORDER BY period ASC, dateCreated ASC";
    $stmtsqlFetchAllLeaveData = $database->prepare($sqlFetchAllLeaveData);

    if ($stmtsqlFetchAllLeaveData) {
        $stmtsqlFetchAllLeaveData->bind_param("s", $employee_id);
        $stmtsqlFetchAllLeaveData->execute();
        $resultAllLeaveData = $stmtsqlFetchAllLeaveData->get_result();

        while ($rowLeaveData = $resultAllLeaveData->fetch_assoc()) {
            $fetchLeaveData[] = $rowLeaveData;
        }

        // Itong parte ang siyang nag-aadd ng bawat month simula sa periodEnd ng Initial Record patungo sa kasalukuyan

        $holdMonth = "";

        for ($i = 0; $i < count($fetchLeaveData); $i++) {
            if ($i == 0 && $fetchLeaveData[$i]['recordType'] == "Initial Record") {
                $fetchLeaveDataWithMontly[] = $fetchLeaveData[$i];
                if ($holdMonth == "") {
                    $currentDate = $fetchLeaveData[$i]['periodEnd'];
                    $date = new DateTime($currentDate);
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');
                } else {
                    $date = new DateTime();
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');
                }

                // if ($holdMonth > $fetchLeaveData[$i]['periodEnd']) {
                //     $monthEarnedArray = [
                //         'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $idGeneration,
                //         'employee_id' => $fetchLeaveData[$i]['employee_id'],
                //         'dateCreated' => $fetchLeaveData[$i]['dateCreated'],
                //         'recordType' => "Monthly Credit",
                //         'period' => $holdMonth,
                //         'periodEnd' => $holdMonth,
                //         'particular' => "Monthly Credit",
                //         'particularLabel' => "",
                //         'days' => 0,
                //         'hours' => 0,
                //         'minutes' => 0,
                //         'vacationLeaveEarned' => 0,
                //         'vacationLeaveAbsUndWP' => 0,
                //         'vacationLeaveBalance' => 0,
                //         'vacationLeaveAbsUndWOP' => 0,
                //         'sickLeaveEarned' => 0,
                //         'sickLeaveAbsUndWP' => 0,
                //         'sickLeaveBalance' => 0,
                //         'sickLeaveAbsUndWOP' => 0,
                //         'dateOfAction' => $holdMonth,
                //         'dateLastModified' => $holdMonth,
                //     ];
                //     $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                // }
            } else {
                if ($holdMonth != "") {
                    $iterate = 0;

                    // Updates the Initial Hold Month For Condition
                    // $currentDate = $holdMonth;
                    // $date = new DateTime($currentDate);
                    // $date->modify('first day of next month');
                    // $holdMonth = $date->format('Y-m-d');

                    // Condition If First Month Reaches The Record To Update Credit
                    while ($holdMonth <= $fetchLeaveData[$i]['period']) {
                        $monthEarnedArray = [
                            'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $iterate . $idGeneration,
                            'employee_id' => $fetchLeaveData[$i]['employee_id'],
                            'dateCreated' => $fetchLeaveData[$i]['dateCreated'],
                            'recordType' => "Monthly Credit",
                            'period' => $holdMonth,
                            'periodEnd' => $holdMonth,
                            'particular' => "Monthly Credit",
                            'particularLabel' => "",
                            'days' => 0,
                            'hours' => 0,
                            'minutes' => 0,
                            'vacationLeaveEarned' => 0,
                            'vacationLeaveAbsUndWP' => 0,
                            'vacationLeaveBalance' => 0,
                            'vacationLeaveAbsUndWOP' => 0,
                            'sickLeaveEarned' => 0,
                            'sickLeaveAbsUndWP' => 0,
                            'sickLeaveBalance' => 0,
                            'sickLeaveAbsUndWOP' => 0,
                            'dateOfAction' => $holdMonth,
                            'dateLastModified' => $holdMonth,
                        ];
                        $iterate = $iterate + 1;
                        $currentDate = $holdMonth;
                        $date = new DateTime($currentDate);
                        $date->modify('first day of next month');
                        $holdMonth = $date->format('Y-m-d');
                        $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                    }

                    // Adds the Data
                    $fetchLeaveDataWithMontly[] = $fetchLeaveData[$i];
                }
            }

            //Checks If It The Last Array Then Creates An Array of Credit Months Up to Date
            if ($i >= count($fetchLeaveData) - 1) {
                $today = (new DateTime())->format('Y-m-d');
                $iterate = 0;
                while ($holdMonth <= $today) {
                    $monthEarnedArray = [
                        'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $idGeneration . $iterate,
                        'employee_id' => $fetchLeaveData[$i]['employee_id'],
                        'dateCreated' => $fetchLeaveData[$i]['dateCreated'],
                        'recordType' => "Monthly Credit",
                        'period' => $holdMonth,
                        'periodEnd' => $holdMonth,
                        'particular' => "Monthly Credit",
                        'particularLabel' => "",
                        'days' => 0,
                        'hours' => 0,
                        'minutes' => 0,
                        'vacationLeaveEarned' => 0,
                        'vacationLeaveAbsUndWP' => 0,
                        'vacationLeaveBalance' => 0,
                        'vacationLeaveAbsUndWOP' => 0,
                        'sickLeaveEarned' => 0,
                        'sickLeaveAbsUndWP' => 0,
                        'sickLeaveBalance' => 0,
                        'sickLeaveAbsUndWOP' => 0,
                        'dateOfAction' => $holdMonth,
                        'dateLastModified' => $holdMonth,
                    ];
                    $iterate = $iterate + 1;
                    $currentDate = $holdMonth;
                    $date = new DateTime($currentDate);
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');
                    $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                }
            }

        }

        // Itong parte at siyang nagcocompute ng bawat data
        for ($i = 0; $i < count($fetchLeaveDataWithMontly); $i++) {
            if ($i == 0) {
                // Do Nothing
            } else {
                $totalMinutes = 0;
                $totalMinutes = (($fetchLeaveDataWithMontly[$i]['days'] * 8) * 60) + ($fetchLeaveDataWithMontly[$i]['hours'] * 60) + $fetchLeaveDataWithMontly[$i]['minutes'];

                $totalVacationComputedValue = 0;
                $totalSickComputedValue = 0;

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Sick Leave") {
                    $totalSickComputedValue = 0.002 * $totalMinutes * 1.0416667;
                } else if ($fetchLeaveDataWithMontly[$i]['particular'] == "Vacation Leave" || $fetchLeaveDataWithMontly[$i]['particular'] == "Late" || $fetchLeaveDataWithMontly[$i]['particular'] == "Forced Leave") {
                    $totalVacationComputedValue = 0.002 * $totalMinutes * 1.0416667;
                }

                $tempVacationBalance = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'];
                $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $tempVacationBalance;

                $tempSickBalance = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'];
                $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $tempSickBalance;

                $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'];
                $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'];
                $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $tempVacationBalance;
                $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $tempSickBalance;

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Vacation Leave" || $fetchLeaveDataWithMontly[$i]['particular'] == "Late" || $fetchLeaveDataWithMontly[$i]['particular'] == "Forced Leave") {
                    if ($tempVacationBalance <= $totalVacationComputedValue) {
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWP'] = $tempVacationBalance;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = 0;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'] + ($totalVacationComputedValue - $tempVacationBalance);
                    } else {
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWP'] = $totalVacationComputedValue;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $tempVacationBalance - $totalVacationComputedValue;
                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'];
                    }
                }

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Sick Leave") {
                    if ($tempSickBalance <= $totalSickComputedValue) {
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = $tempSickBalance;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = 0;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] + ($totalSickComputedValue - $tempSickBalance);
                    } else {
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = $totalSickComputedValue;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $tempSickBalance - $totalSickComputedValue;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'];
                    }
                }

                if ($fetchLeaveDataWithMontly[$i]['recordType'] == "Monthly Credit") {
                    if ($monthReset) {
                        if ($fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $vacationLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $vacationLeaveMonthlyCredit;
                        }

                        if ($fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $sickLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $sickLeaveMonthlyCredit;
                        }

                        $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = 0;
                        $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = 0;

                    } else {
                        if ($fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = 0;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWP'] = 0;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = 0;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveAbsUndWOP'] - $vacationLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                        }

                        if ($fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] - $sickLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'];
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
                        }
                    }
                }
            }
        }

    }

    return $fetchLeaveDataWithMontly;
}

function computeExactTime($valuePoints) {
    // Define the number of minutes in a workday
    $minutesInWorkday = 8 * 60; // 8 hours * 60 minutes

    // Calculate total minutes
    $totalMinutes = $valuePoints * $minutesInWorkday;

    // Calculate days
    $days = floor($totalMinutes / $minutesInWorkday);

    // Calculate remaining minutes after full days
    $remainingMinutes = $totalMinutes % $minutesInWorkday;

    // Convert remaining minutes to hours and minutes
    $remainingHours = floor($remainingMinutes / 60);
    $remainingMinutes %= 60;

    // $result = [
    //     'days' => $days,
    //     'hours' => $remainingHours,
    //     'minutes' => $remainingMinutes
    // ];

    $result = "";

    if ($days > 0) {
        $result .= $days . " day";
        if ($days > 1) {
            $result .= "s";
        }
        $result .= " ";
    }

    if ($remainingHours > 0) {
        if ($result !== "") {
            $result .= " ";
        }
        $result .= $remainingHours . " hour";
        if ($remainingHours > 1) {
            $result .= "s";
        }
    }

    if ($remainingMinutes > 0) {
        if ($result !== "") {
            $result .= " ";
        }
        $result .= $remainingMinutes . " minute";
        if ($remainingMinutes > 1) {
            $result .= "s";
        }
    }

    return $result;
}

function formatExactTime($day, $hour, $minutes) {
    $formattedTime = '';

    if ($day > 0) {
        $formattedTime .= $day . ' day';
        if ($day > 1) {
            $formattedTime .= 's';
        }
        $formattedTime .= ' ';
    }

    if ($hour > 0) {
        $formattedTime .= $hour . ' hour';
        if ($hour > 1) {
            $formattedTime .= 's';
        }
        $formattedTime .= ' ';
    }

    if ($minutes > 0) {
        $formattedTime .= $minutes . ' minute';
        if ($minutes > 1) {
            $formattedTime .= 's';
        }
    }

    $formattedTime = trim($formattedTime);

    return $formattedTime;
}

?>
<!-- -->