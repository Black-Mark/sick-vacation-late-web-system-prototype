<?php
include("../../../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$empId = isset($_GET['empid']) ? filter_var($_GET['empid'], FILTER_SANITIZE_STRING) : null;
$employeeData = [];
$fetchLeaveData = [];
$monthReset = true;
$fetchLeaveDataWithMontly = [];
$leaveData = [];
$idGeneration = "12345678901234567890";
$vacationLeaveMonthlyCredit = 1.25;
$sickLeaveMonthlyCredit = 1.25;

if ($empId === 'index.php' || $empId === 'index.html' || $empId === null) {
    $empId = null;
    if (isset($_SESSION['post_empId'])) {
        unset($_SESSION['post_empId']);
    }
} else {
    $_SESSION['post_empId'] = $empId;

    $sql = "SELECT
                ua.*,
                d.departmentName
            FROM
                tbl_useraccounts ua
            LEFT JOIN
                tbl_departments d ON ua.department = d.department_id
            WHERE
                ua.employee_id = ?";

    $stmt = $database->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $empId);
        $stmt->execute();
        $empResult = $stmt->get_result();

        // if ($empResult->num_rows > 0) {
        //     while ($employee = $empResult->fetch_assoc()) {
        //         $employeeData[] = $employee;
        //     }
        //     echo $employeeData[0]['employee_id'];
        // }

        if ($empResult->num_rows > 0) {
            $employeeData = $empResult->fetch_assoc();
            // echo $employeeData['employee_id'];
        }

        $stmt->close();
    } else {
        // Something
    }

    // Get all the Records
    $sqlFetchAllLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? ORDER BY period ASC, dateCreated ASC";
    $stmtsqlFetchAllLeaveData = $database->prepare($sqlFetchAllLeaveData);

    if ($stmtsqlFetchAllLeaveData) {
        $stmtsqlFetchAllLeaveData->bind_param("s", $empId);
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

                if ($holdMonth > $fetchLeaveData[$i]['periodEnd']) {
                    $monthEarnedArray = [
                        'leavedataform_id' => $fetchLeaveData[$i]['leavedataform_id'] . $idGeneration,
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
                    $fetchLeaveDataWithMontly[] = $monthEarnedArray;
                }
            } else {
                if ($holdMonth != "") {
                    $iterate = 0;

                    // Updates the Initial Hold Month For Condition
                    $currentDate = $holdMonth;
                    $date = new DateTime($currentDate);
                    $date->modify('first day of next month');
                    $holdMonth = $date->format('Y-m-d');

                    // Condition If First Month Reaches The Record To Update Credit
                    while ($holdMonth < $fetchLeaveData[$i]['period']) {
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
                while ($holdMonth < $today) {
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
                } else if ($fetchLeaveDataWithMontly[$i]['particular'] == "Vacation Leave" || $fetchLeaveDataWithMontly[$i]['particular'] == "Late") {
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

                if ($fetchLeaveDataWithMontly[$i]['particular'] == "Vacation Leave" || $fetchLeaveDataWithMontly[$i]['particular'] == "Late") {
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
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $vacationLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $vacationLeaveMonthlyCredit;
                        }

                        if ($fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
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
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['vacationLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['vacationLeaveBalance'] + $vacationLeaveMonthlyCredit;
                        }

                        if ($fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] > 0) {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWP'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = 0;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveAbsUndWOP'] - $sickLeaveMonthlyCredit;
                        } else {
                            $fetchLeaveDataWithMontly[$i]['sickLeaveEarned'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
                            $fetchLeaveDataWithMontly[$i]['sickLeaveBalance'] = $fetchLeaveDataWithMontly[$i - 1]['sickLeaveBalance'] + $sickLeaveMonthlyCredit;
                        }
                    }
                }
            }
        }

    } else {
        // Something Error
    }
}

$selectedYear = date("Y");
if (isset($_POST['leaveFormYear']) && $empId) {
    $selectedYear = $_POST['year'];
    if (isset($_SESSION['post_dataformyear'])) {
        unset($_SESSION['post_dataformyear']);
    }
} else if (isset($_SESSION['post_dataformyear'])) {
    $selectedYear = $_SESSION['post_dataformyear'];
} else {
    $selectedYear = date("Y");
}

if ($selectedYear) {
    foreach ($fetchLeaveDataWithMontly as $leaveRecord) {

        $periodYear = date('Y', strtotime($leaveRecord['period']));
        $periodEndYear = date('Y', strtotime($leaveRecord['periodEnd']));
        if ($periodYear <= $selectedYear && $periodEndYear >= $selectedYear) {
            $leaveData[] = $leaveRecord;
        }
    }
}

$hasInitialRecord = false;
$hasYearRecord = false;

if (!empty($fetchLeaveDataWithMontly)) {
    foreach ($fetchLeaveDataWithMontly as $fdata) {
        if ($fdata['recordType'] == "Initial Record" && $fdata['particular'] == "Initial Record") {
            // If at least one Initial Record is found, set the flag to true
            $hasInitialRecord = true;
            break; // No need to continue checking, we found one Initial Record
        }
    }
}

if (!empty($leaveData)) {
    $hasYearRecord = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Admin Page">
    <?php
    include($constants_file_html_credits);
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $assets_logo_icon; ?>">

    <link rel="stylesheet" href="<?php echo $assets_bootstrap_vcss; ?>">
    <script src="<?php echo $assets_bootstrap_vjs; ?>"></script>
    <link rel="stylesheet" href="<?php echo $assets_bootstrap_css; ?>">
    <script src="<?php echo $assets_jquery; ?>"></script>
    <script src="<?php echo $assets_popper; ?>"></script>
    <script src='<?php echo $assets_bootstrap_js; ?>'></script>

    <link rel='stylesheet' href="<?php echo $assets_fontawesome; ?>">

    <link rel="stylesheet" href="<?php echo $assets_toastify_css; ?>">
    <script src="<?php echo $assets_toastify_js; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_datatable_css; ?>">
    <script src="<?php echo $assets_datatable_js; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_datatable_css_select; ?>">
    <script src="<?php echo $assets_datatable_js_select; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_datatable_bootstrap; ?>">

    <link rel="stylesheet" href="<?php echo $assets_css_styles; ?>">

    <script src="<?php echo $assets_file_leavedataform; ?>"></script>

    <!-- <script src="<?php
    // echo $assets_tailwind; 
    ?>"></script> -->
</head>

<body class="webpage-background-cover-admin">
    <div class="component-container">
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div class="component-container">
                <?php include($components_file_navpanel); ?>
            </div>

            <div class='box-container'>

                <!-- Initialize Record -->
                <form action="<?php echo $action_add_leaverecorddata; ?>" method="post" class="modal fade"
                    id="createInitialRecord" tabindex="-1" role="dialog" aria-labelledby="createInitialRecordTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createInitialRecordModalLongTitle">Create Initial Record
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="empId" value="<?php echo $empId; ?>" />
                                <input type="hidden" name="selectedYear" value="<?php echo $selectedYear; ?>" />

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="period" class="form-control"
                                                id="floatingInitializePeriod" placeholder="2020-12-31" required>
                                            <label for="floatingInitializePeriod">Start Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="periodEnd" class="form-control"
                                                id="floatingInitializePeriodEnd" placeholder="2020-12-31" required>
                                            <label for="floatingInitializePeriodEnd">End Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" name="particularLabel" class="form-control"
                                        id="floatingparticularLabel" placeholder="">
                                    <label for="floatingparticularLabel">Label
                                        <!-- <span class="required-color">*</span> -->
                                    </label>
                                </div>

                                <div class="m-2">Vacation Leave</div>

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" step="any" name="vacationBalance" class="form-control"
                                                id="vacationBalanceInput" value="1.25" required>
                                            <label for="vacationBalanceInput">Balance <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" step="any" name="vacationUnderWOPay"
                                                class="form-control" id="vacationUnderWOPayInput" value="0" required>
                                            <label for="vacationUnderWOPayInput">Under W/O Pay <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="m-2">Sick Leave</div>

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" step="any" name="sickBalance" class="form-control"
                                                id="sickBalanceInput" value="1.25" required>
                                            <label for="sickBalanceInput">Balance <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" step="any" name="sickUnderWOPay" class="form-control"
                                                id="sickUnderWOPayInput" value="0" required>
                                            <label for="sickUnderWOPayInput">Under W/O Pay <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <input type="date" name="dateOfAction" class="form-control"
                                        id="floatingInitializeDateOfAction" placeholder="2020-12-31" required>
                                    <label for="floatingInitializeDateOfAction">Date of Action <span
                                            class="required-color">*</span></label>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary clearInitialize">Clear</button>
                                <input type="submit" name="createInitialRecord" value="Create Initial Record"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Add Modal -->
                <form action="<?php echo $action_add_leaverecorddata; ?>" method="post" class="modal fade"
                    id="addLeaveDataRecord" tabindex="-1" role="dialog" aria-labelledby="addLeaveDataRecordTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addLeaveDataRecordModalLongTitle">Add New Leave Record</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="empId" value="<?php echo $empId; ?>" />
                                <input type="hidden" name="selectedYear" value="<?php echo $selectedYear; ?>" />

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="period" class="form-control" id="floatingPeriod"
                                                placeholder="2020-12-31" required>
                                            <label for="floatingPeriod">Start Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="periodEnd" class="form-control"
                                                id="floatingPeriodEnd" placeholder="2020-12-31" required>
                                            <label for="floatingPeriodEnd">End Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <select class="form-select" id="floatingParticularType" name="particularType"
                                        aria-label="Floating Particular Type" required>
                                        <option value="" selected></option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <option value="Vacation Leave">Vacation Leave</option>
                                        <option value="Late">Late</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <label for="floatingParticularType">Type <span
                                            class="required-color">*</span></label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" name="particularLabel" class="form-control"
                                        id="floatingparticularLabel" placeholder="">
                                    <label for="floatingparticularLabel">Label
                                        <!-- <span class="required-color">*</span> -->
                                    </label>
                                </div>

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="3652" name="dayInput" class="form-control"
                                                id="floatingDayInput" placeholder="3" required>
                                            <label for="floatingDayInput">Work Day(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="24" name="hourInput" class="form-control"
                                                id="floatingHourInput" placeholder="24" required>
                                            <label for="floatingHourInput">Hour(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="60" name="minuteInput"
                                                class="form-control" id="floatingMinuteInput" placeholder="60" required>
                                            <label for="floatingMinuteInput">Minute(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <input type="date" name="dateOfAction" class="form-control"
                                        id="floatingDateOfAction" placeholder="2020-12-31" required>
                                    <label for="floatingDateOfAction">Date of Action <span
                                            class="required-color">*</span></label>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary clearAddLeaveDataInputs">Clear</button>
                                <input type="submit" name="addLeaveDataRecord" value="Add Leave Record"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <form action="<?php echo $action_add_leaverecorddata; ?>" method="post" class="modal fade"
                    id="addNewLeaveDataRecord" tabindex="-1" role="dialog" aria-labelledby="addNewLeaveDataRecordTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewLeaveDataRecordModalLongTitle">Add New Leave Record
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="empId" value="<?php echo $empId; ?>" />
                                <input type="hidden" name="selectedYear" value="<?php echo $selectedYear; ?>" />

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="period" class="form-control" id="floatingNewPeriod"
                                                placeholder="2020-12-31" required>
                                            <label for="floatingNewPeriod">Start Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="periodEnd" class="form-control"
                                                id="floatingNewPeriodEnd" placeholder="2020-12-31" required>
                                            <label for="floatingNewPeriodEnd">End Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <select class="form-select" id="floatingParticularType" name="particularType"
                                        aria-label="Floating Particular Type" required>
                                        <option value="" selected></option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <option value="Vacation Leave">Vacation Leave</option>
                                        <option value="Late">Late</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <label for="floatingParticularType">Type <span
                                            class="required-color">*</span></label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" name="particularLabel" class="form-control"
                                        id="floatingparticularLabel" placeholder="">
                                    <label for="floatingparticularLabel">Label
                                        <!-- <span class="required-color">*</span> -->
                                    </label>
                                </div>

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="3652" name="dayInput" class="form-control"
                                                id="floatingDayInput" placeholder="3" required>
                                            <label for="floatingDayInput">Work Day(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="24" name="hourInput" class="form-control"
                                                id="floatingHourInput" placeholder="24" required>
                                            <label for="floatingHourInput">Hour(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="60" name="minuteInput"
                                                class="form-control" id="floatingMinuteInput" placeholder="60" required>
                                            <label for="floatingMinuteInput">Minute(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <input type="date" name="dateOfAction" class="form-control"
                                        id="floatingNewDateOfAction" placeholder="2020-12-31" required>
                                    <label for="floatingNewDateOfAction">Date of Action <span
                                            class="required-color">*</span></label>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary clearAddLeaveDataInputs">Clear</button>
                                <input type="submit" name="addLeaveDataRecord" value="Add Leave Record"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Edit Modal -->
                <form action="<?php echo $action_edit_leaverecorddata; ?>" method="post" class="modal fade"
                    id="editLeaveDataRecord" tabindex="-1" role="dialog" aria-labelledby="editLeaveDataRecordTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editLeaveDataRecordModalLongTitle">Edit Leave Record</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="leavedataformId" id="floatingEditLeaveDataFormId" />
                                <input type="hidden" name="empId" value="<?php echo $empId; ?>" />
                                <input type="hidden" name="selectedYear" value="<?php echo $selectedYear; ?>" />

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="period" class="form-control"
                                                id="floatingEditPeriod" placeholder="2020-12-31" required>
                                            <label for="floatingEditPeriod">Start Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="date" name="periodEnd" class="form-control"
                                                id="floatingEditPeriodEnd" placeholder="2020-12-31" required>
                                            <label for="floatingEditPeriodEnd">End Period <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <select class="form-select" id="floatingEditParticularType" name="particularType"
                                        aria-label="floatingEdit Particular Type" required>
                                        <option value="" selected></option>
                                        <option value="Sick Leave">Sick Leave</option>
                                        <option value="Vacation Leave">Vacation Leave</option>
                                        <option value="Late">Late</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <label for="floatingEditParticularType">Type <span
                                            class="required-color">*</span></label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" name="particularLabel" class="form-control"
                                        id="floatingEditParticularLabel" placeholder="">
                                    <label for="floatingEditParticularLabel">Label
                                        <!-- <span class="required-color">*</span> -->
                                    </label>
                                </div>

                                <div class="row g-2 mb-2">

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="3652" name="dayInput" class="form-control"
                                                id="floatingEditDayInput" placeholder="3" required>
                                            <label for="floatingEditDayInput">Work Day(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="24" name="hourInput" class="form-control"
                                                id="floatingEditHourInput" placeholder="24" required>
                                            <label for="floatingEditHourInput">Hour(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" min="0" max="60" name="minuteInput"
                                                class="form-control" id="floatingEditMinuteInput" placeholder="60"
                                                required>
                                            <label for="floatingEditMinuteInput">Minute(s) <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-floating mb-2">
                                    <input type="date" name="dateOfAction" class="form-control"
                                        id="floatingEditDateOfAction" placeholder="2020-12-31" required>
                                    <label for="floatingEditDateOfAction">Date of Action <span
                                            class="required-color">*</span></label>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary clearEditLeaveDataInputs">Clear</button>
                                <input type="submit" name="editLeaveDataRecord" value="Save Changes"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <div class="component-container p-2">
                    <h3 class="title-text">
                        <span>Leave Data Form - Year</span>
                        <span id="selectedYear">
                            <?php echo $selectedYear; ?>
                        </span>
                    </h3>
                    <div class="title-text-caption">
                        (
                        <?php echo $employeeData['firstName'] . " " . $employeeData['lastName']; ?>)
                    </div>
                </div>

                <div class="button-container component-container mb-2">
                    <form action="" method="post">
                        <label for="year">Select a Year:</label>
                        <select name="year" id="year" class="custom-regular-button" aria-label="Year Selection">
                            <?php
                            $currentYear = date("Y");
                            $start_date = $employeeData['dateStarted'];

                            // Extract the year from the start date
                            $start_year = $start_date ? date("Y", strtotime($start_date)) : $currentYear;

                            if (!$start_year || $start_year <= 1924) {
                                $start_year = $currentYear;
                            }

                            for ($year = $currentYear; $year >= $start_year; $year--) {
                                ?>
                                <option value="<?php echo $year; ?>" <?php echo ($year == $selectedYear) ? 'selected' : ''; ?>>
                                    <?php echo $year; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="submit" name="leaveFormYear" value="Load Year Record"
                            class="custom-regular-button">
                    </form>
                    <?php
                    if ($hasInitialRecord) {
                        ?>
                        <button type="button" class="addLeaveDataRecordButton custom-regular-button" data-toggle="modal"
                            data-target="#addLeaveDataRecord">
                            Add Leave Record
                        </button>
                        <?php
                    }
                    ?>
                    <button type="button" class="custom-regular-button" onclick="window.print()">Print</button>
                </div>

                <div class="print-form-container">
                    <div class='data-form-detail-container mb-3'>
                        <div>Republic of the Philippines</div>
                        <div>Province of Cavite</div>
                        <div>Municipality of Indang</div>
                    </div>

                    <div class="overflow-auto custom-scrollbar">
                        <table class="data-form-detail-table">
                            <thead>
                                <tr>
                                    <th colspan="3" style="width: 30%;" class="table-head-base-front">
                                        <div>Name</div>
                                        <div class="table-item-base-none">
                                            <?php
                                            if (isset($employeeData['firstName']) && isset($employeeData['lastName'])) {
                                                echo $employeeData['firstName'] . ' ' . $employeeData['lastName'];
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </div>
                                    </th>
                                    <th colspan="5" style="width: 40%;" class="table-head-base-front">
                                        <div>Division/Office</div>
                                        <div class="table-item-base-none">
                                            <?php
                                            if (isset($employeeData['departmentName'])) {
                                                echo $employeeData['departmentName'];
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </div>
                                    </th>
                                    <th colspan="3" style="width: 30%;" class="table-head-base-front">
                                        <div>1st. Day of Service</div>
                                        <div class="table-item-base-none">
                                            <?php
                                            if (isset($employeeData['dateStarted'])) {
                                                echo $employeeData['dateStarted'];
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width: 10%;" class="table-head-base">Period</th>
                                    <th rowspan="2" style="width: 10%;" class="table-head-base">Particulars</th>
                                    <th colspan="4" style="width: 30%;" class="table-head-base">Vacation Leave</th>
                                    <th colspan="4" style="width: 30%;" class="table-head-base">Sick Leave</th>
                                    <th rowspan="2" style="width: 10%;" class="table-head-base">Date & Action Taken on
                                        Application For Leave</th>
                                </tr>
                                <tr>
                                    <th style="width: 7.5%;" class="table-head-base">Earned</th>
                                    <th style="width: 7.5%;" class="table-head-base">Abs. und. w/p</th>
                                    <th style="width: 7.5%;" class="table-head-base">Bal.</th>
                                    <th style="width: 7.5%;" class="table-head-base">Abs. und. w/o p</th>

                                    <th style="width: 7.5%;" class="table-head-base">Earned</th>
                                    <th style="width: 7.5%;" class="table-head-base">Abs. und. w/p</th>
                                    <th style="width: 7.5%;" class="table-head-base">Bal.</th>
                                    <th style="width: 7.5%;" class="table-head-base">Abs. und. w/o p</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($hasYearRecord) {
                                    foreach ($leaveData as $ldata) {
                                        ?>
                                        <!-- <tr key=""> -->
                                        <div id="accordionPanelsStayOpenExample">
                                        <?php
                                        ?>
                                        <tr>
                                        </tr>
                                        <?php
                                        ?>
                                            <tr class="clickable-element" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapse<?php echo $ldata['leavedataform_id']; ?>"
                                                aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapse<?php echo $ldata['leavedataform_id']; ?>">
                                                <td class="table-item-base">
                                                    <?php echo $ldata['period'];
                                                    if ($ldata['periodEnd'] && $ldata['period'] < $ldata['periodEnd']) {
                                                        echo ' to ' . $ldata['periodEnd'];
                                                    }
                                                    ?>
                                                </td>
                                                <td title="<?php
                                                if ($ldata['days'] > 0) {
                                                    echo ' ' . $ldata['days'] . ' day(s) ';
                                                }
                                                if ($ldata['hours'] > 0) {
                                                    echo ' ' . $ldata['hours'] . ' hour(s) ';
                                                }
                                                if ($ldata['minutes'] > 0) {
                                                    echo ' ' . $ldata['minutes'] . ' minute(s) ';
                                                }
                                                ?>" class="table-item-base">
                                                    <?php
                                                    if ($ldata['particular'] == "Others") {
                                                        if ($ldata['particularLabel']) {
                                                            echo $ldata['particularLabel'];
                                                        } else {
                                                            echo $ldata['particular'];
                                                        }
                                                    } else {
                                                        echo $ldata['particular'];
                                                        if ($ldata['particularLabel']) {
                                                            echo ' (' . $ldata['particularLabel'] . ')';
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['vacationLeaveEarned'], 2); ?>
                                                </td>
                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['vacationLeaveAbsUndWP'], 2); ?>
                                                </td>
                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['vacationLeaveBalance'], 2); ?>
                                                </td>
                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['vacationLeaveAbsUndWOP'], 2); ?>
                                                </td>

                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['sickLeaveEarned'], 2); ?>
                                                </td>
                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['sickLeaveAbsUndWP'], 2); ?>
                                                </td>
                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['sickLeaveBalance'], 2); ?>
                                                </td>
                                                <td class="table-item-base">
                                                    <?php echo number_format($ldata['sickLeaveAbsUndWOP'], 2); ?>
                                                </td>

                                                <td class="table-item-base">
                                                    <?php echo $ldata['dateOfAction']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($ldata['recordType'] != "Monthly Credit") {
                                                ?>
                                                <tr id="panelsStayOpen-collapse<?php echo $ldata['leavedataform_id']; ?>"
                                                    class="component-container accordion-collapse collapse"
                                                    aria-labelledby="panelsStayOpen-heading<?php echo $ldata['leavedataform_id']; ?>">
                                                    <td colspan="11" class="component-container table-item-base">
                                                        <div
                                                            class="button-container component-container justify-content-center py-1">
                                                            <button type="button" id="addNewLeaveDataRecord"
                                                                class="addNewLeaveDataRecord custom-regular-button"
                                                                data-toggle="modal" data-target="#addNewLeaveDataRecord"
                                                                data-period-date="<?php echo $ldata['periodEnd']; ?>"
                                                                data-period-end-date="<?php echo $ldata['periodEnd']; ?>"
                                                                data-date-of-action="<?php echo $ldata['dateOfAction']; ?>">
                                                                Add New Leave Record
                                                            </button>
                                                            <?php
                                                            if ($ldata['recordType'] != "Initial Record") {
                                                                ?>
                                                                <button type="button" class="editLeaveDataRecord custom-regular-button"
                                                                    data-toggle="modal" data-target="#editLeaveDataRecord"
                                                                    data-leavedata-id="<?php echo $ldata['leavedataform_id']; ?>"
                                                                    data-period-start="<?php echo $ldata['period']; ?>"
                                                                    data-period-end="<?php echo $ldata['periodEnd']; ?>"
                                                                    data-particular-type="<?php echo $ldata['particular']; ?>"
                                                                    data-particular-label="<?php echo $ldata['particularLabel']; ?>"
                                                                    data-input-day="<?php echo $ldata['days']; ?>"
                                                                    data-input-hour="<?php echo $ldata['hours']; ?>"
                                                                    data-input-minute="<?php echo $ldata['minutes']; ?>"
                                                                    data-date-of-action="<?php echo $ldata['dateOfAction']; ?>">
                                                                    Edit Leave Record
                                                                </button>
                                                                <?php
                                                            }
                                                            ?>
                                                            <form action="<?php echo $action_delete_leaverecorddata; ?>"
                                                                method="post">
                                                                <input type="hidden" name="leavedataformId"
                                                                    value="<?php echo $ldata['leavedataform_id']; ?>" />
                                                                <input type="hidden" name="empId" value="<?php echo $empId; ?>" />
                                                                <input type="hidden" name="selectedYear"
                                                                    value="<?php echo $selectedYear; ?>" />
                                                                <input type="submit" name="deleteLeaveData"
                                                                    value="Delete Leave Record" class="custom-regular-button" />
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="11" class="py-2">
                                            <div class="py-1 font-weight-light">
                                                There is no Data Found
                                            </div>
                                            <?php
                                            if (!$hasInitialRecord) {
                                                ?>
                                                <div class="button-container component-container justify-content-center py-1">
                                                    <button type="button" id="createInitialRecordButton"
                                                        class="custom-regular-button" data-toggle="modal"
                                                        data-target="#createInitialRecord"
                                                        data-period-start="<?php echo $employeeData['dateStarted']; ?>">
                                                        Create Initial Record
                                                    </button>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="button-container component-container justify-content-center py-1">
                                                    <button type="button" class="addLeaveDataRecordButton custom-regular-button"
                                                        data-toggle="modal" data-target="#addLeaveDataRecord">
                                                        Add New Leave Record
                                                    </button>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="component-container">
        <?php
        include($components_file_footer);
        ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>