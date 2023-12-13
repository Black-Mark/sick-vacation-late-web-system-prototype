<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);
include($constants_variables);

$employeeData = [];
$departmentHeadData = [];

if (isset($_SESSION['employeeId'])) {
    $employeeId = $database->real_escape_string($_SESSION['employeeId']);

    $sql = "SELECT
                ua.*,
                d.departmentName,
                d.departmentHead
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

    if ($employeeData['departmentHead']) {

        $departmentHeadFetchQuery = "SELECT
                                        firstName, lastName, middleName, suffix, jobPosition
                                    FROM
                                        tbl_useraccounts
                                    WHERE
                                        employee_id = ?";

        $statement = $database->prepare($departmentHeadFetchQuery);
        $statement->bind_param("s", $employeeData['departmentHead']);
        $statement->execute();
        $departmentHeadResult = $statement->get_result();

        if ($departmentHeadResult) {
            $departmentHeadData = $departmentHeadResult->fetch_assoc();
        }
        $statement->close();
    }

}

$settingData = [];
$settingQuery = "SELECT * FROM tbl_systemsettings
                 LEFT JOIN tbl_useraccounts ON tbl_useraccounts.employee_id = tbl_systemsettings.settingKey WHERE settingType = 'Authorized User'";
$settingResult = mysqli_query($database, $settingQuery);

if ($settingResult) {
    $settingData = mysqli_fetch_all($settingResult, MYSQLI_ASSOC);
    // mysqli_free_result($settingResult);
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

                <form action="<?php echo $action_add_leaveappform; ?>" method="post">
                    <div class="button-container component-container mb-2">
                        <input type="submit" name="submitLeaveAppForm" class="custom-regular-button"
                            value="Submit Leave Form" />
                    </div>

                    <div class="print-form-container">
                        <div>
                            <div>CSC Form No. 6</div>
                            <div>Revised 2020</div>
                        </div>

                        <div class='leave-form-detail-container mb-3 text-uppercase'>
                            <div>Application For Leave </div>
                        </div>

                        <div class="leave-form-container overflow-auto custom-scrollbar">

                            <table class='w-100 border border-dark'>
                                <tbody>
                                    <tr>
                                        <td class='px-2'><label for="department">1. Office / Department</label></td>
                                        <td class='px-2'>2. Name</td>
                                        <td class='px-2'><label for="lastNameInput">(Last)</label></td>
                                        <td class='px-2'><label for="firstNameInput">(First)</label></td>
                                        <td class='px-2'><label for="middleNameInput">(Middle)</label></td>
                                    </tr>
                                    <tr>
                                        <td class="pb-1 px-2">
                                            <select id="department" name="departmentName"
                                                class="w-100 text-center underline-input">
                                                <option value="<?php echo $employeeData['department']; ?>" selected>
                                                    <?php
                                                    if ($employeeData['departmentName']) {
                                                        echo $employeeData['departmentName'];
                                                    } else if ($employeeData['department']) {
                                                        echo $employeeData['department'];
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </option>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td class="pb-1 px-2"><input type="text" id="lastNameInput" name="lastName"
                                                class='w-100 text-center underline-input'
                                                value="<?php echo $employeeData['lastName']; ?>" readonly /></td>
                                        <td class="pb-1 px-2"><input type="text" id="firstNameInput" name="firstName"
                                                class='w-100 text-center underline-input'
                                                value="<?php echo $employeeData['firstName']; ?>" readonly /></td>
                                        <td class="pb-1 px-2"><input type="text" id="middleNameInput" name="middleName"
                                                class='w-100 text-center underline-input'
                                                value="<?php echo $employeeData['middleName']; ?>" readonly /></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100 border border-dark">
                                <tbody>
                                    <tr>
                                        <td class="pb-1 px-2"><label for="dateFiling">3. Date Of Filing </label><input
                                                type="text" id="dateFiling" name="dateFiling"
                                                value="<?php echo date("Y-m-d"); ?>" class='text-center underline-input'
                                                readonly />
                                        </td>
                                        <td class="pb-1 px-2"><label for="position">4. Position </label><input
                                                type="text" id="position" name="position"
                                                class='underline-input text-center'
                                                value="<?php echo $employeeData['jobPosition']; ?>" readonly />
                                        </td>
                                        <td class="pb-1 px-2"><label for="salary">5. Salary </label><input type="text"
                                                id="salary" name="salary" class='underline-input' />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100 border border-dark">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class='text-center font-weight-bold text-uppercase'>
                                            6. Details of Application
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class='w-100 border border-dark'>
                                <tbody>
                                    <tr>
                                        <td class="col-6 custom-td">
                                            <div class='font-weight-bold text-uppercase'>6.A Type of
                                                Leave to be Availed Of</div>
                                            <div>
                                                <input type='radio' id="vacationLeave" name="typeOfLeave"
                                                    value="Vacation Leave" />
                                                <label for="vacationLeave" class='font-weight-bold'> Vacation Leave
                                                </label>
                                                <span>
                                                    (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="forcedLeave" name="typeOfLeave"
                                                    value="Forced Leave" />
                                                <label for="forcedLeave" class='font-weight-bold'> Mandatory / Forced
                                                    Leave
                                                </label>
                                                <span>
                                                    (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No.292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="sickLeave" name="typeOfLeave"
                                                    value="Sick Leave" />
                                                <label for="sickLeave" class='font-weight-bold'> Sick Leave </label>
                                                <span>
                                                    (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="maternityLeave" name="typeOfLeave"
                                                    value="Maternity Leave" /> <label for="maternityLeave"
                                                    class='font-weight-bold'>
                                                    Maternity Leave
                                                </label>
                                                <span>
                                                    (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="paternityLeave" name="typeOfLeave"
                                                    value="Paternity Leave" /> <label for="paternityLeave"
                                                    class='font-weight-bold'>
                                                    Paternity Leave
                                                </label>
                                                <span>
                                                    (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="special" name="typeOfLeave"
                                                    value="Special Privilege Leave" /> <label for="special"
                                                    class='font-weight-bold'>
                                                    Special Privilege Leave
                                                </label>
                                                <span>
                                                    (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="soloParent" name="typeOfLeave"
                                                    value="Solo Parent Leave" /> <label for="soloParent"
                                                    class='font-weight-bold'>
                                                    Solo Parent Leave
                                                </label>
                                                <span>
                                                    (RA No. 8972 / CSC MC No. 8, s. 2004)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="studyLeave" name="typeOfLeave"
                                                    value="Study Leave" /> <label for="studyLeave"
                                                    class='font-weight-bold'>
                                                    Doctorate Degree / Study Leave
                                                </label>
                                                <span>
                                                    (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="vawcLeave" name="typeOfLeave"
                                                    value="10-Day VAWC Leave" /> <label for="vawcLeave"
                                                    class='font-weight-bold'>
                                                    10-Day VAWC Leave
                                                </label>
                                                <span>
                                                    (RA No. 9262 / CSC MC No. 15, s. 2005)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="rehabilitation" name="typeOfLeave"
                                                    value="Rehabilitation Privilege" /> <label for="rehabilitation"
                                                    class='font-weight-bold'>
                                                    Rehabilitation Privilege
                                                </label>
                                                <span>
                                                    (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="specialLeave" name="typeOfLeave"
                                                    value="Special Leave Benefits for Women" /> <label
                                                    for="specialLeave" class='font-weight-bold'>
                                                    Special Leave Benefits for Women
                                                </label>
                                                <span>
                                                    (RA No. 9710 / CSC MC No. 25, s. 2010)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="emergencyLeave" name="typeOfLeave"
                                                    value="Special Emergency (Calamity) Leave" /> <label
                                                    for="emergencyLeave" class='font-weight-bold'>
                                                    Special Emergency (Calamity) Leave
                                                </label>
                                                <span>
                                                    (CSC MC No. 2, s. 2012, as amended)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="adoptionLeave" name="typeOfLeave"
                                                    value="Adoption Leave" /> <label for="adoptionLeave"
                                                    class='font-weight-bold'>
                                                    Adoption Leave
                                                </label>
                                                <span>
                                                    (R.A. No. 8552)
                                                </span>
                                            </div>
                                            <div>
                                                <label for="others">Others: </label> <input type="text" id="others"
                                                    name="typeOfSpecifiedOtherLeave" class='underline-input mt-4' />
                                            </div>
                                        </td>
                                        <td class='col-4 custom-td'>
                                            <div class='font-weight-bold text-uppercase'>6.B Details
                                                of Leave</div>
                                            <div>
                                                In case of Vacation/Special Privilege Leave:
                                            </div>
                                            <div>
                                                <input type='radio' id="withinPhi" name="typeOfVacationLeave"
                                                    value="Within the Philippines" /> <label for="withinPhi"
                                                    class='font-weight-bold'>
                                                    Within the Philippines <input type="text"
                                                        name="typeOfVacationLeaveWithin"
                                                        class='custom-underline-input-form' />
                                                </label>
                                            </div>
                                            <div>
                                                <input type='radio' id="abroad" name="typeOfVacationLeave"
                                                    value="Abroad" /> <label for="abroad" class='font-weight-bold'>
                                                    Abroad (Specify) <input type="text" name="typeOfVacationLeaveAbroad"
                                                        class='custom-underline-input-form' />
                                                </label>
                                            </div>
                                            <div>
                                                In case of Sick Leave:
                                            </div>
                                            <div>
                                                <input type='radio' id="inHospital" name="typeOfSickLeave"
                                                    value="In Hospital" /> <label for="inHospital"
                                                    class='font-weight-bold'>
                                                    In Hospital (Specify Illness) <input type="text"
                                                        name="typeOfSickLeaveInHospital"
                                                        class='custom-underline-input' />
                                                </label>
                                            </div>
                                            <div>
                                                <input type='radio' id="outPatient" name="typeOfSickLeave"
                                                    value="Out Patient" /> <label for="outPatient"
                                                    class='font-weight-bold'>
                                                    Out Patient (Specify Illness) <input type="text"
                                                        name="typeOfSickLeaveOutPatient"
                                                        class='custom-underline-input' />
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="" class='custom-underline-input-form-detail'
                                                    disabled />
                                            </div>
                                            <div>
                                                In case of Special Leave Benefits for Women:
                                            </div>
                                            <div>
                                                <label for="specifyIllness" class='font-weight-bold'>
                                                    (Specify Illness)</label> <input id="specifyIllness"
                                                    name="typeOfSpecialLeaveForWomen"
                                                    class='custom-underline-input-form-detail' />
                                                <input name="" class='underline-input' disabled />
                                            </div>
                                            <div>
                                                In Case of Study Leave:
                                            </div>
                                            <div>
                                                <input type='radio' id="mastersDegree" name="typeOfStudyLeave"
                                                    value="Completion of Master Degree" /> <label for="mastersDegree"
                                                    class='font-weight-bold'>
                                                    Completion of Master's Degree
                                                </label>
                                            </div>
                                            <div>
                                                <input type='radio' id="boardExam" name="typeOfStudyLeave"
                                                    value="Board Examination Review" /> <label for="boardExam"
                                                    class='font-weight-bold'>
                                                    Bar / Board Examination Review
                                                </label>
                                            </div>
                                            <div>
                                                Other Purpose:
                                            </div>
                                            <div>
                                                <input type='radio' id="monetizationLeave" name="typeOfOtherLeave"
                                                    value="Monetization of Leave Credit" />
                                                <label for="monetizationLeave" class='font-weight-bold'>
                                                    Monetization of Leave Credit
                                                </label>
                                            </div>
                                            <div>
                                                <input type='radio' id="terminalLeave" name="typeOfOtherLeave"
                                                    value="Terminal Leave" /> <label for="terminalLeave"
                                                    class='font-weight-bold'>
                                                    Terminal Leave
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100 border border-dark">
                                <tbody>
                                    <tr>
                                        <td class="col-6 custom-td">
                                            <div class='font-weight-bold text-uppercase'><label for="workingDays">
                                                    6.C NUMBER OF WORKING DAYS APPLIED FOR </label>
                                            </div>
                                            <div>
                                                <input type="number" min="0" max="3652" id="workingDays"
                                                    name="workingDays"
                                                    class='w-100 text-center custom-underline-input-form' />
                                            </div>
                                            <label for="inclusiveDates" class='font-weight-bold text-uppercase'>
                                                Inclusive Dates
                                            </label>
                                            <div>
                                                <input type="text" id="inclusiveDates" name="inclusiveDates"
                                                    class='w-100 text-center custom-underline-input-form' />
                                            </div>
                                        </td>
                                        <td class="col-4 custom-td">
                                            <div class='font-weight-bold text-uppercase'>
                                                6.D Commutation
                                            </div>
                                            <div>
                                                <input type='radio' id="requested" name="commutation"
                                                    value="Requested" /> <label for="requested"
                                                    class='font-weight-bold'>
                                                    Requested
                                                </label>
                                            </div>
                                            <div>
                                                <input type='radio' id="notRequested" name="commutation"
                                                    value="Not Requested" /> <label for="notRequested"
                                                    class='font-weight-bold'>
                                                    Not Requested
                                                </label>
                                            </div>
                                            <div>
                                                <input class='w-100 text-center custom-underline-input-form' disabled />
                                                <div class='text-center font-weight-normal'>Signature of
                                                    Applicant
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100 border border-dark">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class='text-center font-weight-bold text-uppercase'>
                                            7. Details of Action on Application
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class='w-100 border border-dark'>
                                <tbody>
                                    <tr>
                                        <td class="col-6 custom-td">
                                            <div class='font-weight-bold text-uppercase'>
                                                7.A Certification of Leave Credits
                                            </div>
                                            <div class='text-center'>
                                                <label for="asOfDate">As of</label> <input type="date"
                                                    value="<?php echo $employeeData['dateStarted'] ?>" id="asOfDate"
                                                    name="asOfDate" class='underline-input' />
                                            </div>
                                            <div class='custom-container-leave-form'>
                                                <table class='custom-table-leave-form'>
                                                    <thead>
                                                        <tr class='text-center'>
                                                            <th></th>
                                                            <th>Vacation Leave</th>
                                                            <th>Sick Leave</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class='text-center'>
                                                            <td class='font-italic'>Total Earned</td>
                                                            <td><input type="number" name="vacationLeaveTotalEarned"
                                                                    class='custom-input-leave-form' /></td>
                                                            <td><input type="number" name="sickLeaveTotalEarned"
                                                                    class='custom-input-leave-form' /></td>
                                                        </tr>
                                                        <tr class='text-center'>
                                                            <td class='font-italic'>Less this application</td>
                                                            <td><input type="number" name="vacationLeaveLess"
                                                                    class='custom-input-leave-form' /></td>
                                                            <td><input type="number" name="sickLeaveLess"
                                                                    class='custom-input-leave-form' /></td>
                                                        </tr>
                                                        <tr class='text-center'>
                                                            <td class='font-italic'>Balance</td>
                                                            <td><input type="number" name="vacationLeaveBalance"
                                                                    class='custom-input-leave-form' /></td>
                                                            <td><input type="number" name="sickLeaveBalance"
                                                                    class='custom-input-leave-form' /></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class='mt-3 font-weight-bold text-center'>
                                                <?php
                                                if (count($settingData) > 0) {
                                                    for ($i = 0; $i < count($settingData); $i++) {
                                                        if ($settingData[$i]['settingSubject'] == "Human Resources Manager") {
                                                            echo $settingData[$i]['lastName'] . ' ' . $settingData[$i]['firstName'];
                                                            echo $settingData[$i]['middleName'] ? ' ' . substr($settingData[$i]['middleName'], 0, 1) . '.' : $settingData[$i]['middleName'];
                                                            echo $settingData[$i]['suffix'] ? ' ' . $settingData[$i]['suffix'] : '';
                                                        }
                                                    }
                                                } else {
                                                    echo ' ';
                                                }
                                                ?>
                                            </div>
                                            <div class='text-center'>
                                                <?php
                                                if (count($settingData) > 0) {
                                                    for ($i = 0; $i < count($settingData); $i++) {
                                                        if ($settingData[$i]['settingSubject'] == "Human Resources Manager") {
                                                            if ($settingData[$i]['jobPosition'] != "") {
                                                                echo $settingData[$i]['jobPosition'];
                                                            } else {
                                                                echo "Human Resources Manager";
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo "Human Resources Manager";
                                                }
                                                ?>
                                            </div>
                                        </td>


                                        <td class='col-4 custom-td'>
                                            <div class='font-weight-bold text-uppercase'>
                                                7.B Recommendation
                                            </div>
                                            <div>
                                                <input type='radio' id="forApproval" name="recommendation"
                                                    value="For Approval" /> <label for="forApproval"
                                                    class='font-weight-bold'>
                                                    For Approval
                                                </label>
                                            </div>
                                            <div>
                                                <input type='radio' id="forDisapprovedDueToApproval"
                                                    name="recommendation" value="For Disapproved Due to" /> <label
                                                    for="forDisapprovedDueToApproval" class='font-weight-bold'>
                                                    For Disapproved Due to </label> <input type="text"
                                                    name="recommendMessage" class='custom-underline-input-form' />
                                                <div><input class='w-100 underline-input' disabled /></div>
                                                <div><input class='w-100 underline-input' disabled /></div>
                                                <div><input class='w-100 underline-input' disabled /></div>
                                                <div class='custom-div-leave-form'>
                                                    <input class='mt-4 w-100 text-center custom-underline-input-form'
                                                        value="<?php
                                                        if (!empty($departmentHeadData)) {
                                                            echo $departmentHeadData['lastName'] . ' ' . $departmentHeadData['firstName'];
                                                            echo $departmentHeadData['middleName'] ? ' ' . substr($departmentHeadData['middleName'], 0, 1) . '.' : $departmentHeadData['middleName'];
                                                            echo $departmentHeadData['suffix'] ? ' ' . $departmentHeadData['suffix'] : '';
                                                        }
                                                        ?>" disabled />
                                                    <div class='text-center font-weight-normal'>Department Head
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class='w-100'>
                                <tbody>
                                    <tr>
                                        <td class="col-6">
                                            <div class='font-weight-bold text-uppercase'>
                                                7. C.) APPROVED FOR:
                                            </div>
                                            <div>
                                                <input id="dayWithPay" type="number" name="dayWithPay"
                                                    class='underline-input' /><label for="dayWithPay"> days with
                                                    pay</label>
                                            </div>
                                            <div>
                                                <input id="dayWithoutPay" type="number" name="dayWithoutPay"
                                                    class='underline-input' /><label for="dayWithoutPay"> days without
                                                    pay</label>
                                            </div>
                                            <div>
                                                <input id="otherPay" type="number" name="otherDayPay"
                                                    class='underline-input' /> <label for="otherPay">Others</label>
                                                <label for="otherPaySpecify">(Specify)</label>
                                                <input type="text" id="otherPaySpecify" name="otherDaySpecify"
                                                    class='underline-input' />
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <div class='font-weight-bold text-uppercase'>
                                                7. D.) DISAPPROVED DUE TO:
                                            </div>
                                            <div><input type="text" name="disapprovedMessage"
                                                    class='w-100 underline-input' /></div>
                                            <div><input class='w-100 underline-input' disabled /></div>
                                            <div><input class='w-100 underline-input' disabled /></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <div class='custom-div-leave-form'>
                                                <input class='mt-4 text-center custom-underline-input-form' disabled />
                                                <div class='font-weight-bold text-center'>
                                                    <?php
                                                    if (count($settingData) > 0) {
                                                        for ($i = 0; $i < count($settingData); $i++) {
                                                            if ($settingData[$i]['settingSubject'] == "Municipal Mayor") {
                                                                echo $settingData[$i]['lastName'] . ' ' . $settingData[$i]['firstName'];
                                                                echo $settingData[$i]['middleName'] ? ' ' . substr($settingData[$i]['middleName'], 0, 1) . '.' : $settingData[$i]['middleName'];
                                                                echo $settingData[$i]['suffix'] ? ' ' . $settingData[$i]['suffix'] : '';
                                                            }
                                                        }
                                                    } else {
                                                        echo " ";
                                                    }
                                                    ?>
                                                </div>
                                                <div class='font-weight-normal text-center'>
                                                    <?php
                                                    if (count($settingData) > 0) {
                                                        for ($i = 0; $i < count($settingData); $i++) {
                                                            if ($settingData[$i]['settingSubject'] == "Municipal Mayor") {
                                                                if ($settingData[$i]['jobPosition'] != "") {
                                                                    echo $settingData[$i]['jobPosition'];
                                                                } else {
                                                                    echo "Municipal Mayor";
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo "Municipal Mayor";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </form>
            </div>

            <div class="component-container">
                <?php
                include($components_file_footer);
                ?>
            </div>

            <?php include($components_file_toastify); ?>

</body>

</html>