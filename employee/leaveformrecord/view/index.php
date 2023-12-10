<?php
include("../../../constants/routes.php");
include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);
include($constants_variables);

$leaveAppFormData = [];

if (isset($_SESSION['employeeId']) && isset($_GET['leaveappid'])) {
    $employeeId = $database->real_escape_string($_SESSION['employeeId']);
    $leaveAppFormId = $database->real_escape_string($_GET['leaveappid']);
    

    $sql = "SELECT
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
                laf.leaveappform_id = ?";

    $stmt = $database->prepare($sql);
    $stmt->bind_param("ss", $employeeId, $leaveAppFormId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $leaveAppFormData = $result->fetch_assoc();
        // echo $employeeData['employee_id'];
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

            <div class='box-container'>

                <div class="text-center font-weight-bold text-uppercase title-text component-container">
                    Leave Application Form
                </div>

                <div class="button-container component-container mb-2">
                    <a href='<?php echo $location_employee_leave_form_record; ?>'><button type="button"
                            class="custom-regular-button">Back</button></a>
                    <button type="button" class="custom-regular-button" onclick="window.print()">Print</button>
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
                                        <input type="text" id="department" name="departmentName"
                                            class='w-100 text-center underline-input'
                                            value="<?php echo $leaveAppFormData['departmentName']; ?>" disabled />
                                    </td>
                                    <td></td>
                                    <td class="pb-1 px-2"><input type="text" id="lastNameInput" name="lastName"
                                            class='w-100 text-center underline-input'
                                            value="<?php echo $leaveAppFormData['lastName']; ?>" disabled /></td>
                                    <td class="pb-1 px-2"><input type="text" id="firstNameInput" name="firstName"
                                            class='w-100 text-center underline-input'
                                            value="<?php echo $leaveAppFormData['firstName']; ?>" disabled /></td>
                                    <td class="pb-1 px-2"><input type="text" id="middleNameInput" name="middleName"
                                            class='w-100 text-center underline-input'
                                            value="<?php echo $leaveAppFormData['middleName']; ?>" disabled /></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="w-100 border border-dark">
                            <tbody>
                                <tr>
                                    <td class="pb-1 px-2"><label for="dateFiling">3. Date Of Filing </label><input
                                            type="text" id="dateFiling" name="dateFiling"
                                            class='underline-input text-center'
                                            value="<?php echo $leaveAppFormData['dateFiling']; ?>" disabled />
                                    </td>
                                    <td class="pb-1 px-2"><label for="position">4. Position </label><input type="text"
                                            id="position" name="position" class='underline-input text-center'
                                            value="<?php echo $leaveAppFormData['position']; ?>" disabled />
                                    </td>
                                    <td class="pb-1 px-2"><label for="salary">5. Salary </label><input type="text"
                                            id="salary" name="salary" class='underline-input text-center'
                                            value="<?php echo $leaveAppFormData['salary']; ?>" disabled />
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
                                                value="Vacation Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Vacation Leave' ? 'checked' : '';  ?>
                                                disabled />
                                            <label for="vacationLeave" class='font-weight-bold'> Vacation Leave
                                            </label>
                                            <span>
                                                (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="forcedLeave" name="typeOfLeave" value="Forced Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Forced Leave' ? 'checked' : '';  ?>
                                                disabled />
                                            <label for="forcedLeave" class='font-weight-bold'> Mandatory / Forced
                                                Leave
                                            </label>
                                            <span>
                                                (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No.292)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="sickLeave" name="typeOfLeave" value="Sick Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Sick Leave' ? 'checked' : '';  ?>
                                                disabled />
                                            <label for="sickLeave" class='font-weight-bold'> Sick Leave </label>
                                            <span>
                                                (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="maternityLeave" name="typeOfLeave"
                                                value="Maternity Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Maternity Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="maternityLeave" class='font-weight-bold'>
                                                Maternity Leave
                                            </label>
                                            <span>
                                                (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="paternityLeave" name="typeOfLeave"
                                                value="Paternity Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Paternity Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="paternityLeave" class='font-weight-bold'>
                                                Paternity Leave
                                            </label>
                                            <span>
                                                (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="special" name="typeOfLeave"
                                                value="Special Privilege Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Special Privilege Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="special" class='font-weight-bold'>
                                                Special Privilege Leave
                                            </label>
                                            <span>
                                                (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="soloParent" name="typeOfLeave"
                                                value="Solo Parent Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Solo Parent Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="soloParent" class='font-weight-bold'>
                                                Solo Parent Leave
                                            </label>
                                            <span>
                                                (RA No. 8972 / CSC MC No. 8, s. 2004)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="studyLeave" name="typeOfLeave" value="Study Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Study Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="studyLeave" class='font-weight-bold'>
                                                Doctorate Degree / Study Leave
                                            </label>
                                            <span>
                                                (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="vawcLeave" name="typeOfLeave"
                                                value="10-Day VAWC Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == '10-Day VAWC Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="vawcLeave" class='font-weight-bold'>
                                                10-Day VAWC Leave
                                            </label>
                                            <span>
                                                (RA No. 9262 / CSC MC No. 15, s. 2005)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="rehabilitation" name="typeOfLeave"
                                                value="Rehabilitation Privilege"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Rehabilitation Privilege' ? 'checked' : '';  ?>
                                                disabled /> <label for="rehabilitation" class='font-weight-bold'>
                                                Rehabilitation Privilege
                                            </label>
                                            <span>
                                                (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="specialLeave" name="typeOfLeave"
                                                value="Special Leave Benefits for Women"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Special Leave Benefits for Women' ? 'checked' : '';  ?>
                                                disabled /> <label for="specialLeave" class='font-weight-bold'>
                                                Special Leave Benefits for Women
                                            </label>
                                            <span>
                                                (RA No. 9710 / CSC MC No. 25, s. 2010)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="emergencyLeave" name="typeOfLeave"
                                                value="Special Emergency (Calamity) Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Solo Parent Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="emergencyLeave" class='font-weight-bold'>
                                                Special Emergency (Calamity) Leave
                                            </label>
                                            <span>
                                                (CSC MC No. 2, s. 2012, as amended)
                                            </span>
                                        </div>
                                        <div>
                                            <input type='radio' id="adoptionLeave" name="typeOfLeave"
                                                value="Adoption Leave"
                                                <?php echo $leaveAppFormData['typeOfLeave'] == 'Adoption Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="adoptionLeave" class='font-weight-bold'>
                                                Adoption Leave
                                            </label>
                                            <span>
                                                (R.A. No. 8552)
                                            </span>
                                        </div>
                                        <div>
                                            <label for="others">Others: </label> <input type="text" id="others"
                                                name="typeOfSpecifiedOtherLeave" class='underline-input mt-4'
                                                value="<?php echo $leaveAppFormData['salary']; ?>" disabled />
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
                                                value="Within the Philippines"
                                                <?php echo $leaveAppFormData['typeOfVacationLeave'] == 'Within the Philippines' ? 'checked' : '';  ?>
                                                disabled /> <label for="withinPhi" class='font-weight-bold'>
                                                Within the Philippines <input type="text"
                                                    name="typeOfVacationLeaveWithin" class='custom-underline-input-form'
                                                    value="<?php echo $leaveAppFormData['typeOfVacationLeaveWithin']; ?>"
                                                    disabled />
                                            </label>
                                        </div>
                                        <div>
                                            <input type='radio' id="abroad" name="typeOfVacationLeave" value="Abroad"
                                                <?php echo $leaveAppFormData['typeOfVacationLeave'] == 'Abroad' ? 'checked' : '';  ?>
                                                disabled />
                                            <label for="abroad" class='font-weight-bold'>
                                                Abroad (Specify) <input type="text" name="typeOfVacationLeaveAbroad"
                                                    class='custom-underline-input-form'
                                                    value="<?php echo $leaveAppFormData['typeOfVacationLeaveAbroad']; ?>"
                                                    disabled />
                                            </label>
                                        </div>
                                        <div>
                                            In case of Sick Leave:
                                        </div>
                                        <div>
                                            <input type='radio' id="inHospital" name="typeOfSickLeave"
                                                value="In Hospital"
                                                <?php echo $leaveAppFormData['typeOfSickLeave'] == 'In Hospital' ? 'checked' : '';  ?>
                                                disabled /> <label for="inHospital" class='font-weight-bold'>
                                                In Hospital (Specify Illness) <input type="text"
                                                    name="typeOfSickLeaveInHospital" class='custom-underline-input'
                                                    value="<?php echo $leaveAppFormData['typeOfSickLeaveInHospital']; ?>"
                                                    disabled />
                                            </label>
                                        </div>
                                        <div>
                                            <input type='radio' id="outPatient" name="typeOfSickLeave"
                                                value="Out Patient"
                                                <?php echo $leaveAppFormData['typeOfSickLeave'] == 'Out Patient' ? 'checked' : '';  ?>
                                                disabled /> <label for="outPatient" class='font-weight-bold'>
                                                Out Patient (Specify Illness) <input type="text"
                                                    name="typeOfSickLeaveOutPatient" class='custom-underline-input'
                                                    value="<?php echo $leaveAppFormData['typeOfSickLeaveOutPatient']; ?>"
                                                    disabled />
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
                                                class='custom-underline-input-form-detail'
                                                value="<?php echo $leaveAppFormData['typeOfSpecialLeaveForWomen']; ?>"
                                                disabled />
                                            <input name="" class='underline-input' disabled />
                                        </div>
                                        <div>
                                            In Case of Study Leave:
                                        </div>
                                        <div>
                                            <input type='radio' id="mastersDegree" name="typeOfStudyLeave"
                                                value="Completion of Master Degree"
                                                <?php echo $leaveAppFormData['typeOfStudyLeave'] == 'Completion of Master Degree' ? 'checked' : '';  ?>
                                                disabled /> <label for="mastersDegree" class='font-weight-bold'>
                                                Completion of Master's Degree
                                            </label>
                                        </div>
                                        <div>
                                            <input type='radio' id="boardExam" name="typeOfStudyLeave"
                                                value="Board Examination Review"
                                                <?php echo $leaveAppFormData['typeOfStudyLeave'] == 'Board Examination Review' ? 'checked' : '';  ?>
                                                disabled /> <label for="boardExam" class='font-weight-bold'>
                                                Bar / Board Examination Review
                                            </label>
                                        </div>
                                        <div>
                                            Other Purpose:
                                        </div>
                                        <div>
                                            <input type='radio' id="monetizationLeave" name="typeOfOtherLeave"
                                                value="Monetization of Leave Credit"
                                                <?php echo $leaveAppFormData['typeOfOtherLeave'] == 'Monetization of Leave Credit' ? 'checked' : '';  ?>
                                                disabled />
                                            <label for="monetizationLeave" class='font-weight-bold'>
                                                Monetization of Leave Credit
                                            </label>
                                        </div>
                                        <div>
                                            <input type='radio' id="terminalLeave" name="typeOfOtherLeave"
                                                value="Terminal Leave"
                                                <?php echo $leaveAppFormData['typeOfOtherLeave'] == 'Terminal Leave' ? 'checked' : '';  ?>
                                                disabled /> <label for="terminalLeave" class='font-weight-bold'>
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
                                            <input type="number" min="0" max="3652" id="workingDays" name="workingDays"
                                                class='w-100 text-center custom-underline-input-form'
                                                value="<?php echo $leaveAppFormData['workingDays']; ?>" disabled />
                                        </div>
                                        <label for="inclusiveDates" class='font-weight-bold text-uppercase'>
                                            Inclusive Dates
                                        </label>
                                        <div>
                                            <input type="text" id="inclusiveDates" name="inclusiveDates"
                                                class='w-100 text-center custom-underline-input-form'
                                                value="<?php echo $leaveAppFormData['inclusiveDates']; ?>" disabled />
                                        </div>
                                    </td>
                                    <td class="col-4 custom-td">
                                        <div class='font-weight-bold text-uppercase'>
                                            6.D Commutation
                                        </div>
                                        <div>
                                            <input type='radio' id="requested" name="commutation" value="Requested"
                                                <?php echo $leaveAppFormData['commutation'] == 'Requested' ? 'checked' : '';  ?>
                                                disabled />
                                            <label for="requested" class='font-weight-bold'>
                                                Requested
                                            </label>
                                        </div>
                                        <div>
                                            <input type='radio' id="notRequested" name="commutation"
                                                value="Not Requested"
                                                <?php echo $leaveAppFormData['commutation'] == 'Not Requested' ? 'checked' : '';  ?>
                                                disabled /> <label for="notRequested" class='font-weight-bold'>
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
                                                value="<?php echo $leaveAppFormData['asOfDate']; ?>" id="asOfDate"
                                                name="asOfDate" class='underline-input text-center' disabled />
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
                                                                class='custom-input-leave-form'
                                                                value="<?php echo $leaveAppFormData['vacationLeaveTotalEarned']; ?>"
                                                                disabled /></td>
                                                        <td><input type="number" name="sickLeaveTotalEarned"
                                                                class='custom-input-leave-form'
                                                                value="<?php echo $leaveAppFormData['sickLeaveTotalEarned']; ?>"
                                                                disabled /></td>
                                                    </tr>
                                                    <tr class='text-center'>
                                                        <td class='font-italic'>Less this application</td>
                                                        <td><input type="number" name="vacationLeaveLess"
                                                                class='custom-input-leave-form'
                                                                value="<?php echo $leaveAppFormData['vacationLeaveLess']; ?>"
                                                                disabled /></td>
                                                        <td><input type="number" name="sickLeaveLess"
                                                                class='custom-input-leave-form'
                                                                value="<?php echo $leaveAppFormData['sickLeaveLess']; ?>"
                                                                disabled /></td>
                                                    </tr>
                                                    <tr class='text-center'>
                                                        <td class='font-italic'>Balance</td>
                                                        <td><input type="number" name="vacationLeaveBalance"
                                                                class='custom-input-leave-form'
                                                                value="<?php echo $leaveAppFormData['vacationLeaveBalance']; ?>"
                                                                disabled /></td>
                                                        <td><input type="number" name="sickLeaveBalance"
                                                                class='custom-input-leave-form'
                                                                value="<?php echo $leaveAppFormData['sickLeaveBalance']; ?>"
                                                                disabled /></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class='mt-3 font-weight-bold text-center'>
                                            Leilani R. Vicedo
                                        </div>
                                        <div class='text-center'>
                                            Human Resource Mgt. Officer IV
                                        </div>
                                    </td>


                                    <td class='col-4 custom-td'>
                                        <div class='font-weight-bold text-uppercase'>
                                            7.B Recommendation
                                        </div>
                                        <div>
                                            <input type='radio' id="forApproval" name="recommendation"
                                                value="For Approval"
                                                <?php echo $leaveAppFormData['recommendation'] == 'For Approval' ? 'checked' : '';  ?>
                                                disabled /> <label for="forApproval" class='font-weight-bold'>
                                                For Approval
                                            </label>
                                        </div>
                                        <div>
                                            <input type='radio' id="forDisapprovedDueToApproval" name="recommendation"
                                                value="For Disapproved Due to"
                                                <?php echo $leaveAppFormData['recommendation'] == 'For Disapproved Due to' ? 'checked' : '';  ?>
                                                disabled /> <label for="forDisapprovedDueToApproval"
                                                class='font-weight-bold'>
                                                For Disapproved Due to </label> <input type="text"
                                                name="recommendMessage" class='custom-underline-input-form'
                                                value="<?php echo $leaveAppFormData['recommendMessage']; ?>" disabled />
                                            <div><input class='w-100 underline-input' disabled /></div>
                                            <div><input class='w-100 underline-input' disabled /></div>
                                            <div><input class='w-100 underline-input' disabled /></div>
                                            <div class='custom-div-leave-form'>
                                                <input class='mt-4 w-100 text-center custom-underline-input-form'
                                                    disabled />
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
                                                class='underline-input'
                                                value="<?php echo $leaveAppFormData['dayWithPay']; ?>" disabled /><label
                                                for="dayWithPay"> days with
                                                pay</label>
                                        </div>
                                        <div>
                                            <input id="dayWithoutPay" type="number" name="dayWithoutPay"
                                                class='underline-input'
                                                value="<?php echo $leaveAppFormData['dayWithoutPay']; ?>"
                                                disabled /><label for="dayWithoutPay"> days without
                                                pay</label>
                                        </div>
                                        <div>
                                            <input id="otherPay" type="number" name="otherDayPay"
                                                class='underline-input'
                                                value="<?php echo $leaveAppFormData['otherDayPay']; ?>" disabled />
                                            <label for="otherPay">Others</label>
                                            <label for="otherPaySpecify">(Specify)</label>
                                            <input type="text" id="otherPaySpecify" name="otherDaySpecify"
                                                class='underline-input'
                                                value="<?php echo $leaveAppFormData['otherDaySpecify']; ?>" disabled />
                                        </div>
                                    </td>
                                    <td class="col-4">
                                        <div class='font-weight-bold text-uppercase'>
                                            7. D.) DISAPPROVED DUE TO:
                                        </div>
                                        <div><input type="text" name="disapprovedMessage" class='w-100 underline-input'
                                                value="<?php echo $leaveAppFormData['disapprovedMessage']; ?>"
                                                disabled /></div>
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
                                            <div class='font-weight-bold text-center'>Perfecto V. Fidel
                                            </div>
                                            <div class='font-weight-normal text-center'>Municipal Mayor
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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