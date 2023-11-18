<?php
include("../../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$empId = isset($_GET['empid']) ? filter_var($_GET['empid'], FILTER_SANITIZE_STRING) : null;
$employeeData = [];

if ($empId === 'index.php' || $empId === 'index.html' || $empId === null) {
    $empId = null;
} else {
    $sql = "SELECT * FROM tbl_useraccounts WHERE employee_id = ?";
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
}

$leaveData = [];
$selectedYear = date("Y");

if (isset($_POST['leaveFormYear']) && $empId) {
    $selectedYear = $_POST['year'];

    $sqlLeaveData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND YEAR(period) = ?";
    $stmtLeaveData = $database->prepare($sqlLeaveData);

    if ($stmtLeaveData) {
        $stmtLeaveData->bind_param("si", $empId, $selectedYear);
        $stmtLeaveData->execute();
        $resultLeaveData = $stmtLeaveData->get_result();

        while ($rowLeaveData = $resultLeaveData->fetch_assoc()) {
            $leaveData[] = $rowLeaveData;
        }

        $stmtLeaveData->close();
    } else {
        // Something Error
    }
} else {
    $currentYear = date("Y");

    $sqlCurrentYearData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND YEAR(period) = ?";
    $stmtCurrentYearData = $database->prepare($sqlCurrentYearData);

    if ($stmtCurrentYearData) {
        $stmtCurrentYearData->bind_param("si", $empId, $currentYear);
        $stmtCurrentYearData->execute();
        $resultCurrentYearData = $stmtCurrentYearData->get_result();

        while ($rowCurrentYearData = $resultCurrentYearData->fetch_assoc()) {
            $leaveData[] = $rowCurrentYearData;
        }

        $stmtCurrentYearData->close();
    } else {
        //Something Error
    }
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

                <!-- Add Modal -->
                <form action="<?php echo $action_add_leaverecorddata; ?>" method="post" class="modal fade" id="addLeaveDataRecord"
                    tabindex="-1" role="dialog" aria-labelledby="addLeaveDataRecordTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addLeaveDataRecordModalLongTitle">Add New Leave Record</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-2">
                                    <input type="date" name="period" value="<?php echo date('Y-m-d'); ?>" class="form-control"
                                        id="floatingPeriod" placeholder="2020-12-31"
                                        required>
                                    <label for="floatingPeriod">Period <span
                                            class="required-color">*</span></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="addLeaveDataRecord" value="Add Leave Record"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <form action="<?php echo $action_edit_leaverecorddata; ?>" method="post" class="modal fade" id="editLeaveDataRecord"
                    tabindex="-1" role="dialog" aria-labelledby="editLeaveDataRecordTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editLeaveDataRecordModalLongTitle">Edit New Leave Record</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-2">
                                    <input type="date" name="period" value="<?php echo date('Y-m-d'); ?>" class="form-control"
                                        id="floatingPeriod" placeholder="2020-12-31"
                                        required>
                                    <label for="floatingPeriod">Period <span
                                            class="required-color">*</span></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="editLeaveDataRecord" value="Edit Leave Record"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

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
                        <input type="submit" name="leaveFormYear" value="Submit" class="custom-regular-button">
                    </form>
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
                                    </th>
                                    <th colspan="5" style="width: 40%;" class="table-head-base-front">
                                        <div>Division/Office</div>
                                    </th>
                                    <th colspan="3" style="width: 30%;" class="table-head-base-front">
                                        <div>1st. Day of Service</div>
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
                                if (!empty($leaveData)) {
                                    foreach ($leaveData as $ldata) {
                                        ?>
                                        <tr key="">
                                            <td class="table-item-base">
                                                January 01, 2023
                                            </td>
                                            <td class="table-item-base">
                                                Vacation Leave (Late)
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                50.25
                                            </td>
                                            <td class="table-item-base">
                                                February 01, 2023
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="11">
                                            <div class="py-2 font-weight-light">
                                                There is no Data Found
                                            </div>
                                            <div class="button-container justify-content-center py-2">
                                                <button type="button" class="custom-regular-button" data-toggle="modal"
                                                    data-target="#addLeaveDataRecord">
                                                    Add New Leave Record
                                                </button>
                                                <button type="button" class="custom-regular-button" data-toggle="modal"
                                                    data-target="#editLeaveDataRecord">
                                                    Edit Leave Record
                                                </button>
                                                <form action="" method="post">
                                                    <input type="hidden" name="empid" value="<?php echo $empId; ?>" />
                                                    <input type="submit" name="deleteLeaveData" value="Delete Leave Record"
                                                        class="custom-regular-button" />
                                                </form>
                                            </div>
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
    </div>

    <div class="component-container">
        <?php
        include($components_file_footer);
        ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>