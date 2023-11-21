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
}

$leaveData = [];

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
    $sqlCurrentYearData = "SELECT * FROM tbl_leavedataform WHERE employee_id = ? AND (YEAR(period) = ? OR YEAR(periodEnd) = ?) ORDER BY period ASC";
    $stmtCurrentYearData = $database->prepare($sqlCurrentYearData);

    if ($stmtCurrentYearData) {
        $stmtCurrentYearData->bind_param("sii", $empId, $selectedYear, $selectedYear);
        $stmtCurrentYearData->execute();
        $resultCurrentYearData = $stmtCurrentYearData->get_result();

        while ($rowCurrentYearData = $resultCurrentYearData->fetch_assoc()) {
            $leaveData[] = $rowCurrentYearData;
        }

        $stmtCurrentYearData->close();
    } else {
        // Something Error
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

                <div class="text-center font-weight-bold text-uppercase title-text component-container">
                    <span>Year</span> 
                    <span id="selectedYear"><?php echo $selectedYear; ?></span>
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
                        <input type="submit" name="leaveFormYear" value="Submit" class="custom-regular-button">
                    </form>
                    <?php
                    if (!empty($leaveData)) {
                        ?>
                        <button type="button" id="createInitialRecord" class="custom-regular-button" data-toggle="modal"
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
                                if (!empty($leaveData)) {
                                    foreach ($leaveData as $ldata) {
                                        ?>
                                        <!-- <tr key=""> -->
                                        <div id="accordionPanelsStayOpenExample">
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
                                                    echo ' ' . $ldata['days'] . ' days ';
                                                }
                                                if ($ldata['hours'] > 0) {
                                                    echo ' ' . $ldata['hours'] . ' hours ';
                                                }
                                                if ($ldata['minutes'] > 0) {
                                                    echo ' ' . $ldata['minutes'] . ' minutes ';
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
                                            <tr id="panelsStayOpen-collapse<?php echo $ldata['leavedataform_id']; ?>"
                                                class="component-container accordion-collapse collapse"
                                                aria-labelledby="panelsStayOpen-heading<?php echo $ldata['leavedataform_id']; ?>">
                                                <td colspan="11" class="component-container table-item-base">
                                                    <div
                                                        class="button-container component-container justify-content-center py-1">
                                                        <button type="button" id="addNewLeaveDataRecord"
                                                            class="addNewLeaveDataRecord custom-regular-button"
                                                            data-toggle="modal" data-target="#addNewLeaveDataRecord"
                                                            data-period-date="<?php echo $ldata['period']; ?>"
                                                            data-period-end-date="<?php echo $ldata['periodEnd']; ?>"
                                                            data-date-of-action="<?php echo $ldata['dateOfAction']; ?>">
                                                            Add New Leave Record
                                                        </button>
                                                        <button type="button" class="editLeaveDataRecord custom-regular-button"
                                                            data-toggle="modal" data-target="#editLeaveDataRecord"
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
                                            <div class="button-container component-container justify-content-center py-1">
                                                <button type="button" id="createInitialRecord" class="custom-regular-button"
                                                    data-toggle="modal" data-target="#addLeaveDataRecord">
                                                    Add New Leave Record
                                                </button>
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

    <div class="component-container">
        <?php
        include($components_file_footer);
        ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>