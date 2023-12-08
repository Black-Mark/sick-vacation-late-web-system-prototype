<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);
include($constants_variables);

$fetchLeaveData = [];

if (isset($_SESSION['employeeId'])) {
    $employeeId = $database->real_escape_string($_SESSION['employeeId']);

    // Get all the Records
    $sqlFetchAllLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? ORDER BY period ASC, dateCreated ASC";
    $stmtsqlFetchAllLeaveData = $database->prepare($sqlFetchAllLeaveData);

    if ($stmtsqlFetchAllLeaveData) {
        $stmtsqlFetchAllLeaveData->bind_param("s", $employeeId);
        $stmtsqlFetchAllLeaveData->execute();
        $resultAllLeaveData = $stmtsqlFetchAllLeaveData->get_result();

        while ($rowLeaveData = $resultAllLeaveData->fetch_assoc()) {
            $fetchLeaveData[] = $rowLeaveData;
        }

        // In this Part I want to compute the Values and I want to create another array every first day of the Month starting
        // from the periodEnd (Date type) of the first array where recordType == "Initial Record".
        // Every Month Increases both Vacation and Sick Leave Earned by 1.25.
        for ($i = 0; $i < count($fetchLeaveData); $i++) {
            if ($i == 0) {
                //Does not do Something
            } else {
                $totalMinutes = 0;
                $totalMinutes = (($fetchLeaveData[$i]['days'] * 8) * 60) + ($fetchLeaveData[$i]['hours'] * 60) + $fetchLeaveData[$i]['minutes'];

                $totalVacationComputedValue = 0;
                $totalSickComputedValue = 0;

                if ($fetchLeaveData[$i]['particular'] == "Sick Leave") {
                    $totalSickComputedValue = 0.002 * $totalMinutes * 1.0416667;
                } else if ($fetchLeaveData[$i]['particular'] == "Vacation Leave" || $fetchLeaveData[$i]['particular'] == "Late") {
                    $totalVacationComputedValue = 0.002 * $totalMinutes * 1.0416667;
                }

                $tempVacationBalance = $fetchLeaveData[$i - 1]['vacationLeaveBalance'];
                $fetchLeaveData[$i]['vacationLeaveEarned'] = $tempVacationBalance;
                $tempSickBalance = $fetchLeaveData[$i - 1]['sickLeaveBalance'];
                $fetchLeaveData[$i]['sickLeaveEarned'] = $tempSickBalance;
                $fetchLeaveData[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveData[$i - 1]['vacationLeaveAbsUndWOP'];
                $fetchLeaveData[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveData[$i - 1]['sickLeaveAbsUndWOP'];
                $fetchLeaveData[$i]['vacationLeaveBalance'] = $tempVacationBalance;
                $fetchLeaveData[$i]['sickLeaveBalance'] = $tempSickBalance;

                if ($fetchLeaveData[$i]['particular'] == "Vacation Leave" || $fetchLeaveData[$i]['particular'] == "Late") {
                    if ($tempVacationBalance <= $totalVacationComputedValue) {
                        $fetchLeaveData[$i]['vacationLeaveAbsUndWP'] = $tempVacationBalance;
                        $fetchLeaveData[$i]['vacationLeaveBalance'] = 0;
                        $fetchLeaveData[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveData[$i - 1]['vacationLeaveAbsUndWOP'] + ($totalVacationComputedValue - $tempVacationBalance);
                    } else {
                        $fetchLeaveData[$i]['vacationLeaveAbsUndWP'] = $totalVacationComputedValue;
                        $fetchLeaveData[$i]['vacationLeaveBalance'] = $tempVacationBalance - $totalVacationComputedValue;
                        $fetchLeaveData[$i]['vacationLeaveAbsUndWOP'] = $fetchLeaveData[$i - 1]['vacationLeaveAbsUndWOP'];
                    }
                }

                if ($fetchLeaveData[$i]['particular'] == "Sick Leave") {
                    if ($tempSickBalance <= $totalSickComputedValue) {
                        $fetchLeaveData[$i]['sickLeaveAbsUndWP'] = $tempSickBalance;
                        $fetchLeaveData[$i]['sickLeaveBalance'] = 0;
                        $fetchLeaveData[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveData[$i - 1]['sickLeaveAbsUndWOP'] + ($totalSickComputedValue - $tempSickBalance);
                    } else {
                        $fetchLeaveData[$i]['sickLeaveAbsUndWP'] = $totalSickComputedValue;
                        $fetchLeaveData[$i]['sickLeaveBalance'] = $tempSickBalance - $totalSickComputedValue;
                        $fetchLeaveData[$i]['sickLeaveAbsUndWOP'] = $fetchLeaveData[$i - 1]['sickLeaveAbsUndWOP'];
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
                        if (count($fetchLeaveData) > 0) {
                            echo number_format($fetchLeaveData[count($fetchLeaveData) - 1]['vacationLeaveBalance'], 2);
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
                        if (count($fetchLeaveData) > 0) {
                            echo number_format($fetchLeaveData[count($fetchLeaveData) - 1]['sickLeaveBalance'], 2);
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