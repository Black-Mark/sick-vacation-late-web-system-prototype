<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);
include($constants_variables);

$employeeData = [];
$fetchLeaveData = [];
$fetchLeaveDataWithMontly = [];
$leaveData = [];

if (isset($_SESSION['employeeId'])) {
    $employeeId = $database->real_escape_string($_SESSION['employeeId']);
    $empId = $employeeId;

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
        $stmt->bind_param("s", $employeeId);
        $stmt->execute();
        $empResult = $stmt->get_result();

        if ($empResult->num_rows > 0) {
            $employeeData = $empResult->fetch_assoc();
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

    } else {
        // Something Error
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Employee Page">
    <?php
    include($constants_file_html_credits);
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $assets_logo_icon; ?>">

    <link rel="stylesheet" href="<?php echo $assets_bootstrap_vcss; ?>">
    <link rel="stylesheet" href="<?php echo $assets_bootstrap_css; ?>">
    <script src="<?php echo $assets_jquery; ?>"></script>
    <script src="<?php echo $assets_popper; ?>"></script>
    <script src='<?php echo $assets_bootstrap_js; ?>'></script>

    <link rel='stylesheet' href="<?php echo $assets_fontawesome; ?>">

    <link rel="stylesheet" href="<?php echo $assets_toastify_css; ?>">
    <script src="<?php echo $assets_toastify_js; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_css_styles; ?>">

    <!-- <script src="<?php
    // echo $assets_tailwind; 
    ?>"></script> -->
</head>

<body class="webpage-background-cover">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class="card-container">

                <div class="card">
                    <h1>Available Vacation Leave:</h1>
                    <h2>
                        <?php
                        if (count($fetchLeaveDataWithMontly) > 0) {
                            echo number_format($fetchLeaveDataWithMontly[count($fetchLeaveDataWithMontly) - 1]['vacationLeaveBalance'], 2);
                        } else {
                            echo "?";
                        }
                        ?>
                    </h2>
                </div>

                <div class="card">
                    <h1>Available Sick Leave:</h1>
                    <h2>
                        <?php
                        if (count($fetchLeaveDataWithMontly) > 0) {
                            echo number_format($fetchLeaveDataWithMontly[count($fetchLeaveDataWithMontly) - 1]['sickLeaveBalance'], 2);
                        } else {
                            echo "?";
                        }
                        ?>
                    </h2>
                </div>

            </div>
        </div>
    </div>

    <div>
        <?php
        include($components_file_footer)
            ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>