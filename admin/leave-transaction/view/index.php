<?php
include("../../../constants/routes.php");
include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$employeeData = [];

if (isset($_SESSION['employeeId'])) {
    $employeeId = sanitizeInput($_SESSION['employeeId']);
    $employeeData = getEmployeeData($employeeId);   
}

$fullName = organizeFullName($employeeData['firstName'], $employeeData['middleName'], $employeeData['lastName'], $employeeData['suffix']) ?? "";

$settingData = getAuthorizedUser();

$leaveAppFormID = isset($_GET['leaveappid']) ? filter_var($_GET['leaveappid'], FILTER_SANITIZE_STRING) : null;
$leaveAppFormData = [];
$leaveData = [];
$leaveFormEmpData = [];
$ownerFormGender = "";

if ($leaveAppFormID === 'index.php' || $leaveAppFormID === 'index.html' || $leaveAppFormID === null) {
    $leaveAppFormID = null;
} else {
    $leaveAppFormID = sanitizeInput($leaveAppFormID);

    $fetchLeaveAppFormDataQuery = " SELECT * FROM tbl_leaveappform WHERE leaveappform_id = ? AND UPPER(archive) != 'DELETED'";

    $fetchLeaveAppFormDataStatement = $database->prepare($fetchLeaveAppFormDataQuery);
    $fetchLeaveAppFormDataStatement->bind_param("s", $leaveAppFormID);
    $fetchLeaveAppFormDataStatement->execute();

    $fetchLeaveAppFormDataResult = $fetchLeaveAppFormDataStatement->get_result();

    if ($fetchLeaveAppFormDataResult->num_rows > 0) {
        $leaveAppFormData = $fetchLeaveAppFormDataResult->fetch_assoc();
        $leaveData = getIncentiveLeaveComputation($leaveAppFormData['employee_id']);
        $leaveFormEmpData = getEmployeeData($leaveAppFormData['employee_id']);
        if(isset($leaveFormEmpData['sex'])){
            $ownerFormGender = $leaveFormEmpData['sex'];
        }

        $notifUpdateQuery = "UPDATE tbl_notifications SET status = 'read' WHERE subjectKey = '$leaveAppFormID' AND empIdTo = '@Admin'";
        mysqli_query($database, $notifUpdateQuery);
    }

}

$workingDays = 0;
$typeOfLeave = "";

if (isset($leaveAppFormData['workingDays'])) {
    $workingDays = $leaveAppFormData['workingDays'];
}

if (isset($leaveAppFormData['typeOfLeave'])) {
    $typeOfLeave = $leaveAppFormData['typeOfLeave'];
}

$vacationLeaveTotalEarned = !empty($leaveData) ? number_format($leaveData[count($leaveData) - 1]['vacationLeaveBalance'], 2) : number_format(0, 2);
$sickLeaveTotalEarned = !empty($leaveData) ? number_format($leaveData[count($leaveData) - 1]['sickLeaveBalance'], 2) : number_format(0, 2);
$vacationLeaveLess = $typeOfLeave === "Vacation Leave" || $typeOfLeave == "Forced Leave" ? number_format($workingDays, 2) : number_format(0, 2);
$sickLeaveLess = $typeOfLeave === "Sick Leave" ? number_format($workingDays, 2) : number_format(0, 2);
$vacationLeaveBalance = $typeOfLeave == "Vacation Leave" || $typeOfLeave == "Forced Leave" ? number_format($vacationLeaveTotalEarned - $workingDays, 2) : number_format($vacationLeaveTotalEarned, 2);
$sickLeaveBalance = $typeOfLeave == "Sick Leave" ? number_format($sickLeaveTotalEarned - $workingDays, 2) : number_format($sickLeaveTotalEarned, 2);

$daysWithPay = 0;
$daysWithoutPay = 0;

if($vacationLeaveTotalEarned < $vacationLeaveLess){
    $daysWithPay = $vacationLeaveTotalEarned;
    $daysWithoutPay = $vacationLeaveLess - $vacationLeaveTotalEarned;
}else if($vacationLeaveTotalEarned >= $vacationLeaveLess){
    $daysWithPay = $vacationLeaveLess;
}

if($sickLeaveTotalEarned < $sickLeaveLess){
    $daysWithPay += $sickLeaveTotalEarned;
    $daysWithoutPay += $sickLeaveLess - $sickLeaveTotalEarned;
}else if($sickLeaveTotalEarned >= $sickLeaveLess){
    $daysWithPay += $sickLeaveLess;
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
    <link rel="stylesheet" href="<?php echo $assets_css_printmedia; ?>">

    <script src="<?php echo $assets_file_leaveappform; ?>"></script>

    <!-- <script src="<?php
    // echo $assets_tailwind; 
    ?>"></script> -->
</head>

<body class="webpage-background-cover">
    <div class="component-container">
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div class='box-container'>

                <div class="text-center font-weight-bold text-uppercase title-text component-container">
                    Leave Application Form
                </div>

                <?php
                if (!empty($leaveAppFormData)) {
                    ?>

                <form action="<?php echo $action_edit_leaveappform; ?>" method="post">
                    <div class="button-container component-container mb-2">
                        <input type="hidden" name="leaveappformId" value="<?php echo $leaveAppFormID; ?>" />
                        <input type="hidden" name="ownerOfForm"
                            value="<?php echo $leaveAppFormData['employee_id']; ?>" />
                        <a href="<?php echo $location_admin_leaveapplist; ?>"><button
                                class="custom-regular-button">Back</button></a>
                        <input type="submit" name="validateLeaveAppForm" class="custom-regular-button"
                            value="Submit Leave Form" />
                        <button type="button" class="custom-regular-button" onclick="window.print()">Print</button>
                    </div>

                    <div class="print-form-container my-4">
                        <div>
                            <div>CSC Form No. 6</div>
                            <div>Revised 2020</div>
                        </div>

                        <div class="leave-app-form-container-title">
                            <div>Application For Leave</div>
                        </div>

                        <div class="leave-app-form-container">
                            <!-- Department and Full Name -->
                            <div class="leave-app-form-first-row">
                                <div class="leave-app-form-department-input-container">
                                    <label for="departmentInput" class="leave-app-form-label">1.
                                        Office/Department</label>
                                    <select id="departmentInput" name="departmentName"
                                        class="leave-app-form-input-plain">
                                        <option value="<?php echo $leaveAppFormData['departmentName']; ?>" selected>
                                            <?php echo $leaveAppFormData['departmentName']; ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="leave-app-form-fullname-input-container">
                                    <div>
                                        <div class="leave-app-form-name-container leave-app-form-label">2. Name:</div>
                                    </div>
                                    <div class="leave-app-form-lastname-container">
                                        <label for="lastNameInput">(Last)</label>
                                        <input type="text" id="lastNameInput" name="lastName"
                                            class="leave-app-form-input-plain"
                                            value="<?php echo $leaveAppFormData['lastName']; ?>" readonly />
                                    </div>
                                    <div class="leave-app-form-firstname-container">
                                        <label for="firstNameInput">(First)</label>
                                        <input type="text" id="firstNameInput" name="firstName"
                                            class="leave-app-form-input-plain"
                                            value="<?php echo $leaveAppFormData['firstName']; ?>" readonly />
                                    </div>
                                    <div class="leave-app-form-middlename-container">
                                        <label for="middleNameInput">(Middle)</label>
                                        <input type="text" id="middleNameInput" name="middleName"
                                            class="leave-app-form-input-plain"
                                            value="<?php echo $leaveAppFormData['middleName']; ?>" readonly />
                                    </div>
                                </div>
                            </div>
                            <!-- Date Filing, Position, Salary -->
                            <div class="leave-app-form-second-row">
                                <div class="leave-app-form-filingdate-container">
                                    <label for="dateFilingInput" class="leave-app-form-label">3. Date of Filing</label>
                                    <input type="date" id="dateFilingInput" name="dateFiling"
                                        class="leave-app-form-input-grow"
                                        value="<?php echo $leaveAppFormData['dateFiling']; ?>" readonly />
                                </div>
                                <div class="leave-app-form-position-container">
                                    <label for="positionInput" class="leave-app-form-label">4. Position</label>
                                    <input type="text" id="positionInput" name="position"
                                        class="leave-app-form-input-grow"
                                        value="<?php echo $leaveAppFormData['position']; ?>" readonly />
                                </div>
                                <div class="leave-app-form-salary-container">
                                    <label for="salaryInput" class="leave-app-form-label">5. Salary</label>
                                    <input type="text" id="salaryInput" name="salary" class="leave-app-form-input-grow"
                                        value="<?php echo $leaveAppFormData['salary']; ?>" />
                                </div>
                            </div>
                            <div class="leave-app-form-label-head">
                                6. Details of Application
                            </div>
                            <!-- Type of Leaves and Classification -->
                            <div class="leave-app-form-third-row">
                                <div class="leave-app-form-leavetype-container">
                                    <div class='leave-app-form-third-row-head'>6.A Type of Leave to be Availed Of</div>
                                    
                                        <div class="leave-app-form-leavetype-detail-container">
                                            <input type='radio' id="vacationLeave" name="typeOfLeave" value="Vacation Leave"
                                                class="custom-checkbox-input"
                                                <?php echo $leaveAppFormData['typeOfLeave'] === 'Vacation Leave' ? 'checked' : ''; ?>
                                                readonly />
                                            <label for="vacationLeave" class='leave-app-form-detail-subject'>Vacation Leave</label>
                                            <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#vacationLeaveModal">
                                                (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                            </span>
                                        </div>

                                        <!-- Sick Leave Modal Structure -->
                                        <div class="modal fade" id="vacationLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="vacationLeaveModalLabel">Vacation Leave</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>It shall be filed five (5) days in advance, whenever possible, of the
                                                                effective date of such leave. Vacation leave within in the Philippines or
                                                                abroad shall be indicated in the form for purposes of securing travel
                                                                authority and completing clearance from money and work
                                                                accountabilities. 
                                                                </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="forcedLeave" name="typeOfLeave" value="Forced Leave"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Forced Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="forcedLeave" class='leave-app-form-detail-subject'>
                                            Mandatory / Forced
                                            Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#forcedLeaveModal">
                                            (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No.292)
                                        </span>
                                    </div>

                                    <!-- Force Leave Modal Structure -->
                                    <div class="modal fade" id="forcedLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="forcedLeaveModalLabel">Mandatory / Forced Leave</h5>
                                                </div>
                                                <div class="modal-body">
                                                <p>Annual five-day vacation leave shall be forfeited if not taken during the
                                                    year. In case the scheduled leave has been cancelled in the exigency
                                                    of the service by the head of agency, it shall no longer be deducted from
                                                    the accumulated vacation leave. Availment of one (1) day or more
                                                    Vacation Leave (VL) shall be considered for complying the
                                                    mandatory/forced leave subject to the conditions under Section 25, Rule
                                                    XVI of the Omnibus Rules Implementing E.O. No. 292.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="sickLeave" name="typeOfLeave" value="Sick Leave"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Sick Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="sickLeave" class='leave-app-form-detail-subject'> Sick
                                            Leave </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#sickLeaveModal">
                                            (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                        </span>
                                    </div>

                                    <!-- Sick Leave Modal Structure -->
                                    <div class="modal fade" id="sickLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="sickLeaveModalLabel">Sick Leave</h5>
                                                </div>
                                                <div class="modal-body">
                                                <ul>
                                                    <li>It shall be filed immediately upon employee's return from such leave.</li>
                                                    <li>If filed in advance or exceeding five (5) days, application shall be
                                                    accompanied by a medical certificate. In case medical consultation
                                                    was not availed of, an affidavit should be executed by an applicant.</li>
                                                </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="maternityLeave" name="typeOfLeave"
                                            value="Maternity Leave" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Maternity Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="maternityLeave" class='leave-app-form-detail-subject'>
                                            Maternity Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#maternityLeaveModal">
                                            (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)
                                        </span>
                                    </div>

                                    <!-- Maternity Leave Modal Structure -->
                                    <div class="modal fade" id="maternityLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="maternityLeaveModalLabel">Maternity Leave – 105 days</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <ul>
                                                    <li>Proof of pregnancy e.g. ultrasound, doctor’s certificate on the expected date of delivery.</li>
                                                    <li>Accomplished Notice of Allocation of Maternity Leave Credits (CS Form No. 6a), if needed</li>
                                                    <li>Seconded female employees shall enjoy maternity leave with full pay in the recipient agency.</li>
                                                </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="paternityLeave" name="typeOfLeave"
                                            value="Paternity Leave" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Paternity Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="paternityLeave" class='leave-app-form-detail-subject'>
                                            Paternity Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#paternityLeaveModal">
                                            (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="paternityLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="paternityLeaveModalLabel">Paternity Leave – 7 days</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Proof of child’s delivery e.g. birth certificate, medical certificate and marriage contract.</p>                  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="special" name="typeOfLeave"
                                            value="Special Privilege Leave" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Special Privilege Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="special" class='leave-app-form-detail-subject'>
                                            Special Privilege Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#specialLeaveModal">
                                            (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="specialLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="specialLeaveModalLabel">Special Privilege Leave – 3 days</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p>It shall be filed/approved for at least one (1) week prior to availment, except on emergency cases. Special privilege leave within the
                                                        Philippines or abroad shall be indicated in the form for purposes of securing travel authority and completing clearance from money and work accountabilities. </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="soloParent" name="typeOfLeave" value="Solo Parent Leave"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Solo Parent Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="soloParent" class='leave-app-form-detail-subject'>
                                            Solo Parent Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#soloParentLeaveModal">
                                            (RA No. 8972 / CSC MC No. 8, s. 2004)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="soloParentLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="soloParentLeaveModalLabel">Solo Parent leave – 7 days</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p>It shall be filed in advance or whenever possible five (5) days before going on such leave with updated Solo Parent Identification Card. </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="studyLeave" name="typeOfLeave" value="Study Leave"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Study Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="studyLeave" class='leave-app-form-detail-subject-small'>
                                            Doctorate Degree / Study Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context-small clickable-text" data-toggle="modal" data-target="#studyLeaveModal">
                                            (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                        </span>
                                    </div>

                                     <!-- Modal Structure -->
                                     <div class="modal fade" id="studyLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="studyLeaveModalLabel">Study leave – up to 6 months</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <ul>
                                                        <li>Shall meet the agency’s internal requirements, if any;</li>
                                                        <li>Contract between the agency head or authorized representative andthe employee concerned.</li>
                                                    </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="vawcLeave" name="typeOfLeave" value="10-Day VAWC Leave"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === '10-Day VAWC Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="vawcLeave" class='leave-app-form-detail-subject'>
                                            10-Day VAWC Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#VAWCLeaveModal">
                                            (RA No. 9262 / CSC MC No. 15, s. 2005)
                                        </span>
                                    </div>

                                     <!-- Modal Structure -->
                                     <div class="modal fade" id="VAWCLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="VAWCLeaveModalLabel">VAWC Leave – 10 days</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>
                                                            <li>It shall be filed in advance or immediately upon the woman employee's return from such leave</li>
                                                            <li>It shall be accompanied by any of the following supporting documents:</li>
                                                            <p>a. Barangay Protection Order (BPO) obtained from the barangay;</p>
                                                            <p>b. Temporary/Permanent Protection Order (TPO/PPO) obtained from the court;</p>
                                                            <p>c. If the protection order is not yet issued by the barangay or the court, a certification issued by the Punong Barangay/Kagawad or
                                                                    Prosecutor or the Clerk of Court that the application for the BPO, TPO or PPO has been filed with the said office shall be sufficient
                                                                    to support the application for the ten-day leave; or</p>
                                                            <p>d. In the absence of the BPO/TPO/PPO or the certification, a police report specifying the details of the occurrence of violence on the
                                                                    victim and a medical certificate may be considered, at the discretion of the immediate supervisor of the woman employee
                                                                    concerned.</p>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="rehabilitation" name="typeOfLeave"
                                            value="Rehabilitation Privilege" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Rehabilitation Privilege' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="rehabilitation" class='leave-app-form-detail-subject'>
                                            Rehabilitation Privilege
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#rehabLeaveModal">
                                            (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="rehabLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rehabLeaveModalLabel">Rehabilitation leave – up to 6 months</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <ul>
                                                        <li>Application shall be made within one (1) week from the time of the accident except when a longer period is warranted.</li>
                                                        <li>Letter request supported by relevant reports such as the policereport, if any</li>
                                                        <li>Medical certificate on the nature of the injuries, the course of treatment involved, and the need to undergo rest, recuperation, and
                                                                rehabilitation, as the case may be. </li>
                                                        <li>Written concurrence of a government physician should be obtained relative to the recommendation for rehabilitation if the attending
                                                                physician is a private practitioner, particularly on the duration of the period of rehabilitation. </li>
                                                    </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="specialLeave" name="typeOfLeave"
                                            value="Special Leave Benefits for Women" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Special Leave Benefits for Women' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="specialLeave" class='leave-app-form-detail-subject'>
                                            Special Leave Benefits for Women
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#specialWomanLeaveModal">
                                            (RA No. 9710 / CSC MC No. 25, s. 2010)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="specialWomanLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="specialWomanLeaveModal">Special leave benefits for women – up to 2 months</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <ul>
                                                        <li>The application may be filed in advance, that is, at least five (5) days prior to the scheduled date of the gynecological surgery that will be
                                                                undergone by the employee. In case of emergency, the application for special leave shall be filed immediately upon employee’s return
                                                                but during confinement the agency shall be notified of said surgery.</li>
                                                        <li>The application shall be accompanied by a medical certificate filled out by the proper medical authorities, e.g. the attending surgeon
                                                                accompanied by a clinical summary reflecting the gynecological disorder which shall be addressed or was addressed by the said
                                                                surgery; the histopathological report; the operative technique used for the surgery; the duration of the surgery including the perioperative period (period of confinement around surgery); as well as
                                                                the employees estimated period of recuperation for the same.</li>
                                                    </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="emergencyLeave" name="typeOfLeave"
                                            value="Special Emergency (Calamity) Leave" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Special Emergency (Calamity) Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="emergencyLeave" class='leave-app-form-detail-subject'>
                                            Special Emergency (Calamity) Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#emergencyLeaveModal">
                                            (CSC MC No. 2, s. 2012, as amended)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="emergencyLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="emergencyLeaveModal">Special Emergency (Calamity) leave – up to 5 days</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <ul>
                                                        <li>The special emergency leave can be applied for a maximum of five (5) straight working days or staggered basis within thirty (30) days
                                                                from the actual occurrence of the natural calamity/disaster. Said privilege shall be enjoyed once a year, not in every instance of
                                                                calamity or disaster</li>
                                                        <li>The head of office shall take full responsibility for the grant of special emergency leave and verification of the employee’s eligibility to be
                                                                granted thereof. Said verification shall include: validation of place of residence based on latest available records of the affected
                                                                employee; verification that the place of residence is covered in the declaration of calamity area by the proper government agency; and
                                                                such other proofs as may be necessary.</li>
                                                    </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-leavetype-detail-container">
                                        <input type='radio' id="adoptionLeave" name="typeOfLeave" value="Adoption Leave"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfLeave'] === 'Adoption Leave' ? 'checked' : ''; ?>
                                            readonly />
                                        <label for="adoptionLeave" class='leave-app-form-detail-subject'>
                                            Adoption Leave
                                        </label>
                                        <span class="leave-app-form-leavetype-detail-context clickable-text" data-toggle="modal" data-target="#adoptionLeaveModal">
                                            (R.A. No. 8552)
                                        </span>
                                    </div>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="adoptionLeaveModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="adoptionLeaveModal">Adoption Leave</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <ul>
                                                        <li> Application for adoption leave shall be filed with an authenticated copy of the Pre-Adoptive Placement Authority issued by the
                                                                Department of Social Welfare and Development (DSWD).</li>
                                                    </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="leave-app-form-otherleavetype-detail-container">
                                        <label for="otherTypeOfLeave"
                                            class="leave-app-form-detail-subject font-italic">Others:</label>
                                        <input type="text" id="otherTypeOfLeave" name="otherTypeOfLeave"
                                            class="leave-app-form-input-custom-width"
                                            value="<?php echo $leaveAppFormData['typeOfSpecifiedOtherLeave']; ?>"
                                            readonly />
                                    </div>
                                </div>
                                <div class="leave-app-form-leaveclass-container">
                                    <div class='leave-app-form-third-row-head'>6.B Details of Leave</div>
                                    <div
                                        class="leave-app-form-leaveclass-detail-container leave-app-form-detail-subject font-italic">
                                        In case of Vacation Leave:
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="withinPhi" name="typeOfVacationLeave"
                                            value="Within the Philippines" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfVacationLeave'] === 'Within the Philippines' ? 'checked' : ''; ?> />
                                        <label for="withinPhi" class='leave-app-form-detail-subject'>
                                            Within the Philippines
                                        </label>
                                        <input type="text" name="typeOfVacationLeaveWithin"
                                            class='leave-app-form-input-grow'
                                            value="<?php echo $leaveAppFormData['typeOfVacationLeaveWithin']; ?>" />
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="abroad" name="typeOfVacationLeave" value="Abroad"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfVacationLeave'] === 'Abroad' ? 'checked' : ''; ?> />
                                        <label for="abroad" class='leave-app-form-detail-subject'>
                                            Abroad (Specify)
                                        </label>
                                        <input type="text" name="typeOfVacationLeaveAbroad"
                                            class='leave-app-form-input-grow'
                                            value="<?php echo $leaveAppFormData['typeOfVacationLeaveAbroad']; ?>" />
                                    </div>
                                    <div
                                        class="leave-app-form-leaveclass-detail-container leave-app-form-detail-subject font-italic">
                                        In case of Sick Leave:
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="inHospital" name="typeOfSickLeave" value="In Hospital"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfSickLeave'] === 'In Hospital' ? 'checked' : ''; ?> />
                                        <label for="inHospital" class='leave-app-form-detail-subject'>
                                            In Hospital (Specify Illness)
                                        </label>
                                        <input type="text" name="typeOfSickLeaveInHospital"
                                            class='leave-app-form-input-grow'
                                            value="<?php echo $leaveAppFormData['typeOfSickLeaveInHospital']; ?>" />
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="outPatient" name="typeOfSickLeave" value="Out Patient"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfSickLeave'] === 'Out Patient' ? 'checked' : ''; ?> />
                                        <label for="outPatient" class='leave-app-form-detail-subject'>
                                            Out Patient (Specify Illness)
                                        </label>
                                        <input type="text" name="typeOfSickLeaveOutPatient"
                                            class='leave-app-form-input-grow'
                                            value="<?php echo substr($leaveAppFormData['typeOfSickLeaveOutPatient'], 0, 40); ?>" />
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type="text" name="typeOfSickLeaveOutPatientOne"
                                            class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['typeOfSickLeaveOutPatient'], 41); ?>" />
                                    </div>
                                    <div
                                        class="leave-app-form-leaveclass-detail-container leave-app-form-detail-subject font-italic">
                                        In case of Special Leave Benefits for Women:
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <label for="specifyIllness" class='leave-app-form-detail-subject'>
                                            (Specify Illness)</label>
                                        <input id="specifyIllness" name="typeOfSpecialLeaveForWomen"
                                            class='leave-app-form-input-grow'
                                            value="<?php echo substr($leaveAppFormData['typeOfSpecialLeaveForWomen'], 0, 45); ?>" />
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type="text" name="typeOfSpecialLeaveForWomenOne"
                                            class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['typeOfSickLeaveOutPatient'], 46); ?>" />
                                    </div>
                                    <div
                                        class="leave-app-form-leaveclass-detail-container leave-app-form-detail-subject font-italic">
                                        In Case of Study Leave:
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="mastersDegree" name="typeOfStudyLeave"
                                            value="Completion of Master Degree" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfStudyLeave'] === 'Completion of Master Degree' ? 'checked' : ''; ?> />
                                        <label for="mastersDegree" class='leave-app-form-detail-subject'>
                                            Completion of Master's Degree
                                        </label>
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="boardExam" name="typeOfStudyLeave"
                                            value="Board Examination Review" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfStudyLeave'] === 'Board Examination Review' ? 'checked' : ''; ?> />
                                        <label for="boardExam" class='leave-app-form-detail-subject'>
                                            BAR / Board Examination Review
                                        </label>
                                    </div>
                                    <div
                                        class="leave-app-form-leaveclass-detail-container leave-app-form-detail-subject font-italic">
                                        Other Purpose:
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="monetizationLeave" name="typeOfOtherLeave"
                                            value="Monetization of Leave Credit" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfOtherLeave'] === 'Monetization of Leave Credit' ? 'checked' : ''; ?> />
                                        <label for="monetizationLeave" class='leave-app-form-detail-subject'>
                                            Monetization of Leave Credit
                                        </label>
                                    </div>
                                    <div class="leave-app-form-leaveclass-detail-container">
                                        <input type='radio' id="terminalLeave" name="typeOfOtherLeave"
                                            value="Terminal Leave" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['typeOfOtherLeave'] === 'Terminal Leave' ? 'checked' : ''; ?> />
                                        <label for="terminalLeave" class='leave-app-form-detail-subject'>
                                            Terminal Leave
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Inclusive Date and Commutation -->
                            <div class="leave-app-form-fourth-row">
                                <div class="leave-app-form-inclusivedate-container">
                                    <div class='leave-app-form-label'>
                                        <label for="workingDays">
                                            6.C Number of Working Days Applied For</label>
                                    </div>
                                    <div class="leave-app-form-inclusivedate-detail-container">
                                        <input type="number" min="0" max="3652" id="workingDays" name="workingDays"
                                            class='leave-app-form-input'
                                            value="<?php echo $leaveAppFormData['workingDays']; ?>" />
                                    </div>
                                    <div class="leave-app-form-inclusivedate-detail-container">

                                        <label for="inclusiveDateStart" class='leave-app-form-label'>
                                            Inclusive Dates
                                        </label>
                                        <div class="leave-app-form-inclusivedate-input-container">
                                            <input type="date" id="inclusiveDateStart" name="inclusiveDateStart"
                                                class='leave-app-form-input-plain'
                                                value="<?php echo $leaveAppFormData['inclusiveDateStart']; ?>" />
                                            <span class="inclusive-date-text">to</span>
                                            <input type="date" id="inclusiveDateEnd" name="inclusiveDateEnd"
                                                class='leave-app-form-input-plain'
                                                value="<?php echo $leaveAppFormData['inclusiveDateEnd']; ?>" />
                                        </div>

                                    </div>
                                </div>
                                <div class="leave-app-form-commutation-container">
                                    <div class='leave-app-form-label'>
                                        6.D Commutation
                                    </div>
                                    <div class="leave-app-form-commutation-detail-container">
                                        <input type='radio' id="notRequested" name="commutation" value="Not Requested"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['commutation'] === 'Not Requested' ? 'checked' : ''; ?> />
                                        <label for="notRequested" class='leave-app-form-detail-subject'>
                                            Not Requested
                                        </label>
                                    </div>
                                    <div class="leave-app-form-commutation-detail-container">
                                        <input type='radio' id="requested" name="commutation" value="Requested"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['commutation'] === 'Requested' ? 'checked' : ''; ?> />
                                        <label for="requested" class='leave-app-form-detail-subject'>
                                            Requested
                                        </label>
                                    </div>
                                    <div class="leave-app-form-signature-container">
                                        <!-- <input class="leave-app-form-input" disabled /> -->
                                        <div class='leave-app-form-signature-subject'>
                                            (Signature of Applicant)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="leave-app-form-label-head">
                                7. Details of Action On Application
                            </div>
                            <!-- HR Manager and Department Head -->
                            <div class="leave-app-form-fifth-row">
                                <div class="leave-app-form-hrmanager-container">
                                    <div class='leave-app-form-label'>
                                        7.A Certification of Leave Credits
                                    </div>
                                    <div class='leave-app-form-asofdate-container'>
                                        <label for="asOfDate">As of</label>
                                        <input type="date" id="asOfDate" name="asOfDate"
                                            class='leave-app-form-asofdate-input'
                                            value="<?php echo $leaveAppFormData['asOfDate']; ?>" />
                                    </div>

                                    <div class="leave-app-form-leave-table-container">
                                        <div class="leave-app-form-leave-table-column-container">
                                            <div class="leave-app-form-leave-table-field"></div>
                                            <div class="leave-app-form-leave-table-field">Total Earned</div>
                                            <div class="leave-app-form-leave-table-field">Less This Application</div>
                                            <div class="leave-app-form-leave-table-field">Balance</div>
                                        </div>
                                        <div class="leave-app-form-leave-table-column-container">
                                            <div class="leave-app-form-leave-table-field">Vacation Leave</div>
                                            <div class="leave-app-form-leave-table-field">
                                                <input type="number" name="vacationLeaveTotalEarned"
                                                    class='leave-app-form-input-plain' step="any"
                                                    value="<?php echo $vacationLeaveTotalEarned; ?>" />
                                            </div>
                                            <div class="leave-app-form-leave-table-field">
                                                <input type="number" name="vacationLeaveLess"
                                                    class='leave-app-form-input-plain' step="any"
                                                    value="<?php echo $vacationLeaveLess; ?>" />
                                            </div>
                                            <div class="leave-app-form-leave-table-field">
                                                <input type="number" name="vacationLeaveBalance"
                                                    class='leave-app-form-input-plain' step="any"
                                                    value="<?php echo $vacationLeaveBalance; ?>" />
                                            </div>
                                        </div>
                                        <div class="leave-app-form-leave-table-column-container">
                                            <div class="leave-app-form-leave-table-field">Sick Leave</div>
                                            <div class="leave-app-form-leave-table-field">
                                                <input type="number" name="sickLeaveTotalEarned"
                                                    class='leave-app-form-input-plain' step="any"
                                                    value="<?php echo $sickLeaveTotalEarned; ?>" />
                                            </div>
                                            <div class="leave-app-form-leave-table-field">
                                                <input type="number" name="sickLeaveLess"
                                                    class='leave-app-form-input-plain' step="any"
                                                    value="<?php echo $sickLeaveLess; ?>" />
                                            </div>
                                            <div class="leave-app-form-leave-table-field">
                                                <input type="number" name="sickLeaveBalance"
                                                    class='leave-app-form-input-plain' step="any"
                                                    value="<?php echo $sickLeaveBalance; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="leave-app-form-signature-container">
                                        <!-- <input class="leave-app-form-input" disabled /> -->
                                        <div class="leave-app-form-signature-context mt-2">
                                            <!-- <?php echo $leaveAppFormData['hrName']; ?> -->
                                            <!-- <?php 
                                            if(strtolower($leaveAppFormData['status']) != "submitted"){
                                                echo $leaveAppFormData['hrName'] ?? "";
                                            }else{
                                                echo $fullName;
                                            }
                                            ?> -->
                                        </div>
                                        <div class='leave-app-form-signature-subject'>
                                            <!-- <?php echo $leaveAppFormData['hrPosition']; ?> -->
                                            (Authorized Officer)
                                        </div>
                                    </div>

                                </div>
                                <div class="leave-app-form-departmenthead-container">
                                    <div class='leave-app-form-label'>
                                        7.B Recommendation
                                    </div>
                                    <div class="leave-app-form-departmenthead-detail-container">
                                        <input type='radio' id="forApproval" name="recommendation" value="For Approval"
                                            class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['recommendation'] === 'For Approval' ? 'checked' : ''; ?> />
                                        <label for="forApproval" class='leave-app-form-detail-subject'>
                                            For Approval
                                        </label>
                                    </div>

                                    <div class="leave-app-form-departmenthead-detail-container">
                                        <input type='radio' id="forDisapprovedDueToApproval" name="recommendation"
                                            value="For Disapproved Due to" class="custom-checkbox-input"
                                            <?php echo $leaveAppFormData['recommendation'] === 'For Disapproved Due to' ? 'checked' : ''; ?> />
                                        <label for="forDisapprovedDueToApproval" class='leave-app-form-detail-subject'>
                                            For Disapproved Due to
                                        </label>
                                        <input type="text" name="recommendMessage" class='leave-app-form-input-grow'
                                            value="<?php echo substr($leaveAppFormData['recommendMessage'], 0, 40); ?>" />
                                    </div>

                                    <div class="leave-app-form-departmenthead-detail-container-column">
                                        <input type="text" name="recommendMessageOne" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['recommendMessage'], 41, 90); ?>" />
                                        <input type="text" name="recommendMessageTwo" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['recommendMessage'], 91, 140); ?>" />
                                        <input type="text" name="recommendMessageThree" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['recommendMessage'], 141, 190); ?>" />
                                        <input type="text" name="recommendMessageFour" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['recommendMessage'], 191, 240); ?>" />
                                    </div>

                                    <div class="leave-app-form-signature-container">
                                        <!-- <input class="leave-app-form-input" disabled /> -->
                                        <!-- <div
                                            class="leave-app-form-signature-context <?php echo $leaveAppFormData['deptHeadName'] == '' ? 'mt-4' : ''; ?>">
                                            <?php
                                                echo $leaveAppFormData['deptHeadName'];
                                                ?>
                                        </div> -->
                                        <!-- <?php 
                                            if(strtolower($leaveAppFormData['status']) != "submitted"){
                                                echo $leaveAppFormData['deptHeadName'] ?? "";
                                            }else{
                                                echo $fullName;
                                            }
                                            ?> -->
                                        <div class="leave-app-form-signature-context <?php echo $leaveAppFormData['deptHeadName'] == '' && $fullName == "" ? 'mt-4' : ''; ?>"></div>
                                        <div class='leave-app-form-signature-subject'>
                                            <!-- Department Head -->
                                            (Authorized Officer)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Municipal Mayor -->
                            <div class="leave-app-form-sixth-row">
                                <div class="leave-app-form-mayorapproval-container">
                                    <div class='leave-app-form-label'>
                                        7.C Approved For:
                                    </div>
                                    <div class="leave-app-form-approvaldays-detail-container">
                                        <input id="dayWithPay" type="number" name="dayWithPay"
                                            class='leave-app-form-input-days'
                                            value="<?php echo $daysWithPay; ?>" />
                                        <label for="dayWithPay"> days with pay</label>
                                    </div>

                                    <div class="leave-app-form-approvaldays-detail-container">
                                        <input id="dayWithoutPay" type="number" name="dayWithoutPay"
                                            class='leave-app-form-input-days'
                                            value="<?php echo $daysWithoutPay; ?>" />
                                        <label for="dayWithoutPay"> days without pay</label>
                                    </div>

                                    <div class="leave-app-form-approvaldays-detail-container">
                                        <div class="leave-app-form-otherdays-detail-container">
                                            <input id="otherPay" type="number" name="otherDayPay"
                                                class='leave-app-form-input-days'
                                                value="<?php echo $leaveAppFormData['otherDayPay']; ?>" />
                                            <label for="otherPay">Others</label>
                                        </div>
                                        <div class="leave-app-form-otherdays-detail-container">
                                            <label for="otherPaySpecify">(Specify)</label>
                                            <input type="text" id="otherPaySpecify" name="otherDaySpecify"
                                                class='leave-app-form-input-custom-width'
                                                value="<?php echo $leaveAppFormData['otherDaySpecify']; ?>" />
                                        </div>
                                    </div>

                                </div>
                                <div class="leave-app-form-mayordisapproval-container">
                                    <div class='leave-app-form-label'>
                                        7.D Disapproved Due To:
                                    </div>
                                    <div class="leave-app-form-disapprovemessage-detail-container">
                                        <input type="text" name="disapprovedMessage" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['disapprovedMessage'], 0, 50); ?>" />
                                        <input type="text" name="disapprovedMessageOne" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['disapprovedMessage'], 51, 100); ?>" />
                                        <input type="text" name="disapprovedMessageTwo" class='leave-app-form-input'
                                            value="<?php echo substr($leaveAppFormData['disapprovedMessage'], 101); ?>" />
                                    </div>
                                </div>
                            </div>
                            <!-- Municipal Mayor Signature -->
                            <div class="leave-app-form-seventh-row">
                                <div class="leave-app-form-mayorsignature-container">
                                    <div class="leave-app-form-signature-context mt-4">
                                        <!-- <?php echo $leaveAppFormData['mayorName']; ?> -->
                                        <!-- <?php 
                                            if(strtolower($leaveAppFormData['status']) != "submitted"){
                                                echo $leaveAppFormData['mayorName'] ?? "";
                                            }else{
                                                echo $fullName;
                                            }
                                            ?> -->
                                    </div>
                                    <div class='leave-app-form-signature-subject'>
                                        <!-- <?php echo $leaveAppFormData['mayorPosition']; ?> -->
                                        (Authorized Official)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <?php
                } else {
                    ?>
                <div class="title-text-caption">
                    (No Leave Data Found! It might be Deleted or Does Not Exist!)
                </div>
                <?php
                }
                ?>

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