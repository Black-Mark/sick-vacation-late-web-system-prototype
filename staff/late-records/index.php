<?php
include ("../../constants/routes.php");
include ($constants_file_dbconnect);
include ($constants_file_session_staff);
include ($constants_variables);

$mostMinimalPeriod = getMinYearPeriodEnd(); // Value changes based on fetch data 2023-07-05
$mostMinimalYear = date("Y", strtotime($mostMinimalPeriod));
$monthStartInMinimalYear = intval(date("m", strtotime($mostMinimalPeriod)));

// echo $mostMinimalPeriod;
// echo $mostMinimalYear;
// echo $monthStartInMinimalYear;

$currentYear = date("Y");

// echo $_SESSION['post_lateYear'];

$selectedYear = $currentYear;
if (isset($_POST['selectedLateYear'])) {
    $selectedYear = $_POST['selectedLateYear'];
    if (isset($_SESSION['post_lateYear'])) {
        unset($_SESSION['post_lateYear']);
    }
} else if (isset($_SESSION['post_lateYear'])) {
    $selectedYear = $_SESSION['post_lateYear'];
} else {
    $selectedYear = date("Y");
}

$sql = "SELECT * FROM tbl_laterecordfile WHERE monthYearOfRecord LIKE '%$selectedYear%' ORDER BY monthYearOfRecord ASC";
$result = $database->query($sql);

$records = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[$row['monthYearOfRecord']] = $row;
    }
}

$months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Staff</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Staff Page">
    <?php
    include ($constants_file_html_credits);
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
    <div>
        <?php include ($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div class="box-container">
                <div>
                    <div class="title-text">Employee Late Record</div>
                    <div class="title-text-caption">
                        <h6>Selected Year: <?php echo $selectedYear; ?></h6>
                    </div>
                </div>

                <form action="<?php echo $action_upload_leave_record; ?>" method="post" class="modal fade"
                    id="uploadLeaveRecord" enctype="multipart/form-data" tabindex="-1" role="dialog"
                    aria-labelledby="uploadLeaveRecordTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addEmployeeModalLongTitle">Upload Employee Late Record</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="monthYearName" id="floatingEditMonthlyLateRecord" value="" />
                                <h5 id="monthYearModalLabel" class="w-100 text-center text-uppercase mb-2">
                                </h5>
                                <div class="input-group mb-3">
                                    <input type="file" name="file" class="form-control" id="file" accept=".csv"
                                        autocomplete="off" required>
                                    <label for="file" class="input-group-text">.csv file &nbsp; <span
                                            class="required-color"> *</span></label>
                                </div>
                                <div class="form-check text-center mb-3">
                                    <input type="checkbox" name="typeOfRecording" class="form-check-input"
                                        id="typeOfRecording" value="autosumduplicate">
                                    <label for="typeOfRecording" class="form-check-label">Auto Sum Duplicate Employee
                                        Entry</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="upload" value="Upload" class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <div class="button-container component-container mb-2">
                    <form action="" method="post">
                        <label for="selectedLateYear">Select a Year:</label>
                        <select name="selectedLateYear" id="selectedLateYear" class="custom-regular-button"
                            aria-label="Year Selection">
                            <?php

                            $start_year = $mostMinimalYear ?? $currentYear;

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
                        <input type="submit" name="leaveTransactionYear" value="Load Year Record"
                            class="custom-regular-button">
                    </form>
                </div>

                <div class="month-records table-extend overflow-auto">
                    <table class="w-100 text-center">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Uploaded Record</th>
                                <th>Late Sheet</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentMonth = date("n");

                            foreach ($months as $key => $month) {
                                $monthNumber = $key + 1;

                                $monthYear = "$month $selectedYear";

                                if (($selectedYear == $currentYear && $monthNumber > $currentMonth) || ($selectedYear < $currentYear && $selectedYear == $mostMinimalYear && $monthNumber <= $monthStartInMinimalYear - 1)) {
                                    continue;
                                }

                                ?>
                                <tr>
                                    <td><?php echo $month; ?></td>
                                    <td>
                                        <?php
                                        if (isset($records[$monthYear])) {
                                            $file = "../../" . $records[$monthYear]['fileOfRecord'];
                                            if (file_exists($file)) {
                                                ?>
                                                <i class="fa fa-download"></i>
                                                <a class="link-hover-underline" href="<?php echo $file; ?>" download>Download</a>
                                                <?php
                                            } else {
                                                ?>
                                                <i class="fa fa-file-o"></i>
                                                Missing file
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <i>No record</i>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <form action="<?php echo $action_download_latesheet; ?>" method="post">
                                            <input type="hidden" name="monthYearName" value="<?php echo $monthYear; ?>" />
                                            <input type="submit" name="downloadLateSheet" class="input-submit-plain"
                                                value="<?php echo 'Late Sheet - ' . $monthYear; ?>" />
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="custom-regular-button uploadMonthlyLateRecord"
                                            data-toggle="modal" data-target="#uploadLeaveRecord"
                                            data-month-year="<?php echo $monthYear; ?>">Upload Late Record</button>
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

    <script src="<?php echo $assets_monthlylaterecordlist_js; ?>"></script>

    <div>
        <?php
        include ($components_file_footer);
        ?>
    </div>

    <?php include ($components_file_toastify); ?>

</body>

</html>