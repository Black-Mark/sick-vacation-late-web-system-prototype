<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_employee);
include($constants_variables);


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

                <form action="" method="post">
                    <div class="button-container component-container mb-2">
                        <input type="submit" name="submitLeaveAppForm" class="custom-regular-button"
                            value="Submit Leave Form" />
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
                                            <select class="w-100 text-center underline-input">
                                                <option value="Department">Department of Death</option>
                                                <option value="Department">Department of Life</option>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td class="pb-1 px-2"><input type="text" id="lastNameInput" name="lastName"
                                                class='w-100 text-center underline-input' /></td>
                                        <td class="pb-1 px-2"><input type="text" id="firstNameInput" name="firstName"
                                                class='w-100 text-center underline-input' /></td>
                                        <td class="pb-1 px-2"><input type="text" id="middleNameInput" name="middleName"
                                                class='w-100 text-center underline-input' /></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100 border border-dark">
                                <tbody>
                                    <tr>
                                        <td class="pb-1 px-2"><label for="dateFiling">3. Date Of Filing </label><input
                                                type="text" id="dateFiling" name="dateFiling" class='underline-input' />
                                        </td>
                                        <td class="pb-1 px-2"><label for="position">4. Position </label><input
                                                type="text" id="position" name="position" class='underline-input' />
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
                                                <input type='radio' id="vacationLeave" name="vacationLeave" />
                                                <label for="vacationLeave" class='font-weight-bold'> Vacation Leave
                                                </label>
                                                <span>
                                                    (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="forcedLeave" name="forcedLeave" />
                                                <label for="forcedLeave" class='font-weight-bold'> Mandatory / Forced
                                                    Leave
                                                </label>
                                                <span>
                                                    (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No.292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="sickLeave" name="sickLeave" />
                                                <label for="sickLeave" class='font-weight-bold'> Sick Leave </label>
                                                <span>
                                                    (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="maternityLeave" name="maternityLeave" /> <label
                                                    for="maternityLeave" class='font-weight-bold'>
                                                    Maternity Leave
                                                </label>
                                                <span>
                                                    (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="paternityLeave" name="paternityLeave" /> <label
                                                    for="parternityLeave" class='font-weight-bold'>
                                                    Paternity Leave
                                                </label>
                                                <span>
                                                    (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="special" name="special" /> <label for="special"
                                                    class='font-weight-bold'>
                                                    Special Privilege Leave
                                                </label>
                                                <span>
                                                    (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="soloParent" name="soloParent" /> <label
                                                    for="soloParent" class='font-weight-bold'>
                                                    Solo Parent Leave
                                                </label>
                                                <span>
                                                    (RA No. 8972 / CSC MC No. 8, s. 2004)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="studyLeave" name="studyLeave" /><label
                                                    for="studyLeave" class='font-weight-bold'>
                                                    Doctorate Degree / Study Leave
                                                </label>
                                                <span>
                                                    (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="vawcLeave" name="vawcLeave" /><label
                                                    for="vawcLeave" class='font-weight-bold'>
                                                    10-Day VAWC Leave
                                                </label>
                                                <span>
                                                    (RA No. 9262 / CSC MC No. 15, s. 2005)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' id="rehabilitation" name="rehabilitation" /> <label
                                                    for="rehabilitation" class='font-weight-bold'>
                                                    Rehabilitation Privilege
                                                </label>
                                                <span>
                                                    (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Special Leave Benefits for Women
                                                </span>
                                                <span>
                                                    (RA No. 9710 / CSC MC No. 25, s. 2010)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Special Emergency (Calamity) Leave
                                                </span>
                                                <span>
                                                    (CSC MC No. 2, s. 2012, as amended)
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /><span class='font-weight-bold'>
                                                    Adoption Leave
                                                </span>
                                                <span>
                                                    (R.A. No. 8552)
                                                </span>
                                            </div>
                                            <div>
                                                <label for="others">Others: </label><input type="text" id="others"
                                                    name="others" class='underline-input mt-4' />
                                            </div>
                                        </td>
                                        <td class='col-4 custom-td'>
                                            <div class='font-weight-bold text-uppercase'>6.B Details
                                                of Leave</div>
                                            <div>
                                                In case of Vacation/Special Privilege Leave:
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Within the Philippines <input class='custom-underline-input-form' />
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Abroad (Specify) <input
                                                        class='custom-underline-input-form-detail' />
                                                </span>
                                            </div>
                                            <div>
                                                In case of Sick Leave:
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    In Hospital (Specify Illness) <input
                                                        class='custom-underline-input' />
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Out Patient (Specify Illness) <input
                                                        class='custom-underline-input' />
                                                </span>
                                            </div>
                                            <div>
                                                <input class='custom-underline-input-form-detail' />
                                            </div>
                                            <div>
                                                In case of Special Leave Benefits for Women:
                                            </div>
                                            <div>
                                                <span class='font-weight-bold'>
                                                    (Specify Illness) <input
                                                        class='custom-underline-input-form-detail' />
                                                    <input class='underline-input' />
                                            </div>
                                            <div>
                                                In Case of Study Leave:
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Completion of Master's Degree
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Bar / Board Examination Review
                                                </span>
                                            </div>
                                            <div>
                                                Other Purpose:
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Monetization of Leave Credit
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Terminal Leave
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100 border border-dark">
                                <tbody>
                                    <tr>
                                        <td class="col-6 custom-td">
                                            <div class='font-weight-bold text-uppercase'>
                                                6.C NUMBER OF WORKING DAYS APPLIED FOR
                                            </div>
                                            <div>
                                                <input class='w-100 text-center custom-underline-input-form' />
                                            </div>
                                            <div class='font-weight-bold text-uppercase'>
                                                Inclusive Dates
                                            </div>
                                            <div>
                                                <input class='w-100 text-center custom-underline-input-form' />
                                            </div>
                                        </td>
                                        <td class="col-4 custom-td">
                                            <div class='font-weight-bold text-uppercase'>
                                                6.D Commutation
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Requested
                                                </span>
                                            </div>
                                            <div>
                                                <input type='radio' /> <span class='font-weight-bold'>
                                                    Not Requested
                                                </span>
                                            </div>
                                            <div>
                                                <input class='w-100 text-center custom-underline-input-form' />
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
                                                As Of <input class=' underline-input' />
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
                                                            <td><input class='custom-input-leave-form' /></td>
                                                            <td><input class='custom-input-leave-form' /></td>
                                                        </tr>
                                                        <tr class='text-center'>
                                                            <td class='font-italic'>Less this application</td>
                                                            <td><input class='custom-input-leave-form' /></td>
                                                            <td><input class='custom-input-leave-form' /></td>
                                                        </tr>
                                                        <tr class='text-center'>
                                                            <td class='font-italic'>Balance</td>
                                                            <td><input class='custom-input-leave-form' /></td>
                                                            <td><input class='custom-input-leave-form' /></td>
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
                                                <input type='checkbox' /> <span class='font-weight-bold'>
                                                    For Approval
                                                </span>
                                            </div>
                                            <div>
                                                <input type='checkbox' /> <span class='font-weight-bold'>
                                                    For Disapproved Due to <input class='custom-underline-input-form' />
                                                    <div><input class='w-100 underline-input' /></div>
                                                    <div><input class='w-100 underline-input' /></div>
                                                    <div><input class='w-100 underline-input' /></div>
                                                    <div class='custom-div-leave-form'>
                                                        <input
                                                            class='mt-4 w-100 text-center custom-underline-input-form' />
                                                        <div class='text-center font-weight-normal'>Department Head
                                                        </div>
                                                    </div>
                                                </span>
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
                                                <input class='underline-input' /><span> days with pay</span>
                                            </div>
                                            <div>
                                                <input class='underline-input' /><span> days without pay</span>
                                            </div>
                                            <div>
                                                <input class='underline-input' /><span> Others (Specify) </span><input
                                                    class='underline-input' />
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <div class='font-weight-bold text-uppercase'>
                                                7. D.) DISAPPROVED DUE TO:
                                            </div>
                                            <div><input class='w-100 underline-input' /></div>
                                            <div><input class='w-100 underline-input' /></div>
                                            <div><input class='w-100 underline-input' /></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <div class='custom-div-leave-form'>
                                                <input class='mt-4 text-center custom-underline-input-form' />
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
            </form>

            <div class="component-container">
                <?php
        include($components_file_footer);
        ?>
            </div>

            <?php include($components_file_toastify); ?>

</body>

</html>