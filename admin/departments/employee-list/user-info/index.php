<?php
include("../../../../constants/routes.php");
include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$empId = isset($_GET['empid']) ? filter_var($_GET['empid'], FILTER_SANITIZE_STRING) : null;
$employeeData = [];

if ($empId === 'index.php' || $empId === 'index.html' || $empId === null) {
    $empId = null;
    if (isset($_SESSION['post_empId'])) {
        unset($_SESSION['post_empId']);
    }
} else {
    $_SESSION['post_empId'] = sanitizeInput($empId);
    $employeeData = getEmployeeData($empId);
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
    <div>
        <?php include($components_file_topnav); ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div>
                <?php include($components_file_navpanel); ?>
            </div>

            <div class="box-container">
                <h3 class="title-text">Account Profile Information</h3>

                <div class="account-profile-container print-form-container">
                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Employee ID:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['employee_id']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Account Role:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['role']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Account Status:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['status']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Email:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['email']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">First Name:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['firstName']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Middle Name:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['middleName']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Last Name:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['lastName']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Suffix:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['suffix']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Age:</span>
                        <span class="account-profile-context">
                            <?php echo identifyEmployeeAge($employeeData['birthdate']); ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Sex:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['sex']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Civil Status:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['civilStatus']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Birthday:</span>
                        <span class="account-profile-context">
                            <?php
                            if (empty($employeeData['birthdate']) || $employeeData['birthdate'] == '0000-00-00') {
                                echo 'Not Specified';
                            } else {
                                echo $employeeData['birthdate'];
                            }
                            ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Department:</span>
                        <span class="account-profile-context">
                            <?php
                            if ($employeeData['departmentName']) {
                                echo $employeeData['departmentName'];
                            } else if ($employeeData['department']) {
                                echo $employeeData['department'];
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Job Position:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['designationName']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Date Started:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['dateStarted']; ?>
                        </span>
                    </div>

                </div>

                <!--Button here for Personal Data Sheets -->

                <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#addEmployee">
                    Add Employee Information
                </button>
            </div>

            <!-- Add Modal -->
            <form action="<?php echo $action_add_employeeInfo; ?>" method="post" class="modal fade" id="addEmployee"
                tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEmployeeModalLongTitle">Personal Employee Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#personalInfo" role="tab">I.
                                        Personal
                                        Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#familyBackground" role="tab">II. Family
                                        Background</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#educationalBackground" role="tab">III.
                                        Educational
                                        Background</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Personal Information -->
                                <div class="tab-pane active" id="personalInfo" role="tabpanel">
                                    <input type="hidden" value="<?php echo $departmentlabel; ?>"
                                        name="departmentlabel" />
                                    <div class="form-floating mb-2">
                                        <input type="text" name="birthplace" class="form-control"
                                            id="floatingBirthplace" placeholder="Enter place of birth" required>
                                        <label for="floatingBirthplace">Place of Birth <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="height" class="form-control" id="floatingHeight"
                                            placeholder="Enter height in meters">
                                        <label for="floatingHeight">Height (m)</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="weight" class="form-control" id="floatingWeight"
                                            placeholder="Enter weight in kg">
                                        <label for="floatingWeight">Weight (kg)</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="bloodtype" class="form-control" id="floatingBloodType"
                                            placeholder="Enter blood type">
                                        <label for="floatingBloodType">Blood type</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="gsis" class="form-control" id="floatingGSIS"
                                            placeholder="Enter GSIS ID NO." required>
                                        <label for="floatingGSIS">GSIS ID NO. <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="pagibig" class="form-control" id="floatingPagibig"
                                            placeholder="Enter PAGIBIG ID NO." required>
                                        <label for="floatingPagibig">PAGIBIG ID NO. <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="philhealth" class="form-control"
                                            id="floatingPhilHealth" placeholder="Enter PHILHEALTH NO." required>
                                        <label for="floatingPhilHealth">PHILHEALTH NO. <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="sss" class="form-control" id="floatingSSS"
                                            placeholder="Enter SSS NO." required>
                                        <label for="floatingSSS">SSS NO. <span class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="tin" class="form-control" id="floatingTin"
                                            placeholder="Enter TIN NO." required>
                                        <label for="floatingTin">TIN NO. <span class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="agency" class="form-control" id="floatingAgency"
                                            placeholder="Enter Agency Employee No." required>
                                        <label for="floatingAgency">Agency Employee No. <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <select name="civilStatus" class="form-select" id="floatingCitizenship"
                                            aria-label="Floating Citizenship Selection" required>
                                            <option value="Filipino" selected>Filipino</option>
                                            <option value="Dual Citizenship">Dual Citizenship</option>
                                            <option value="by birth">by birth</option>
                                            <option value="by naturalization">by naturalization</option>
                                        </select>
                                        <label for="floatingCitizenship">Citizenship <span
                                                class="required-color">*</span></label>
                                    </div>

                                    <div class="container">
                                        <details>
                                            <summary class="form-floating mb-2">
                                                Residential Address <span class="required-color">*</span>
                                            </summary>
                                            <div class="form-group mt-2">
                                                <label for="houseNo">House/Block/Lot/No:</label>
                                                <input type="text" class="form-control mb-2" id="houseNo"
                                                    placeholder="Enter House/Block/Lot/No">
                                                <label for="street">Street:</label>
                                                <input type="text" class="form-control mb-2" id="street"
                                                    placeholder="Enter Street" required>
                                                <label for="subdivision">Subdivision/Village:</label>
                                                <input type="text" class="form-control mb-2" id="subdivision"
                                                    placeholder="Enter Subdivision/Village" required>
                                                <label for="city">City/Municipality:</label>
                                                <input type="text" class="form-control mb-2" id="city"
                                                    placeholder="Enter City/Municipality" required>
                                                <label for="province">Province:</label>
                                                <input type="text" class="form-control mb-2" id="province"
                                                    placeholder="Enter Province" required>
                                                <label for="zipCode">Zip Code:</label>
                                                <input type="text" class="form-control mb-2" id="zipCode"
                                                    placeholder="Enter Zip Code" required>
                                            </div>
                                        </details>
                                    </div>

                                    <div class="form-floating mb-2">
                                        <input type="number" name="telephone" class="form-control"
                                            id="floatingTelephone" placeholder="Enter Telephone NO." required>
                                        <label for="floatingTelephone">Telephone NO. <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="mobile" class="form-control" id="floatingMobile"
                                            placeholder="Enter Mobile NO." required>
                                        <label for="floatingMobile">Mobile NO. <span
                                                class="required-color">*</span></label>
                                    </div>

                                </div>

                                <!-- Additional Basic Information Family Background -->
                                <div class="tab-pane" id="familyBackground" role="tabpanel">
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseSurname" class="form-control"
                                            id="floatingSpouseSurname" placeholder="Spouse Surname" required>
                                        <label for="floatingSpouseSurname">Spouse's Surname <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseName" class="form-control"
                                            id="floatingSpouseName" placeholder="Spouse Name" required>
                                        <label for="floatingSpouseName">Spouse's Name <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseMiddlename" class="form-control"
                                            id="floatingSpouseMiddlename" placeholder="Spouse Middlename" required>
                                        <label for="floatingSpouseMiddlename">Spouse's Middlename <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseNameExtension" class="form-control"
                                            id="floatingSpouseNameExtension" placeholder="Name extension (Jr, Sr)"
                                            required>
                                        <label for="floatingSpouseNameExtension">Name extension (Jr, Sr) <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseOccupation" class="form-control"
                                            id="floatingSpouseOccupation" placeholder="Spouse Occupation" required>
                                        <label for="floatingSpouseOccupation">Spouse's Occupation <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseEmployer" class="form-control"
                                            id="floatingSpouseEmployer" placeholder="Employer/Business Name" required>
                                        <label for="floatingSpouseEmployer">Employer/Business Name <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseBusinessAddress" class="form-control"
                                            id="floatingSpouseBusinessAddress" placeholder="Business Address" required>
                                        <label for="floatingSpouseBusinessAddress">Business Address <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="spouseTelephone" class="form-control"
                                            id="floatingSpouseTelephone" placeholder="Telephone No." required>
                                        <label for="floatingSpouseTelephone">Telephone No. <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="number" name="numberOfChildren" class="form-control"
                                            id="floatingNumberOfChildren" placeholder="Number of Children">
                                        <label for="floatingNumberOfChildren">Name of Children (Write in fullname) <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="fathersSurname" class="form-control"
                                            id="floatingfathersSurname" placeholder="Father's Surname">
                                        <label for="floatingfathersSurname">Father's Surname <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="fathersFirstname" class="form-control"
                                            id="floatingfathersFirstname" placeholder="Father's Firstname">
                                        <label for="floatingfathersFirstname">Father's Firstname <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="fathersMiddlename" class="form-control"
                                            id="floatingfathersMiddlename" placeholder="Father's Middlename">
                                        <label for="floatingfathersMiddlename">Father's Middlename <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="fathersnameExtension" class="form-control"
                                            id="floatingnameExtension" placeholder="Name Extension">
                                        <label for="floatingnameExtension">Name extension (Jr, Sr) <span
                                                class="required-color">*</span></label>
                                    </div>

                                    <div class="container">
                                        <details>
                                            <summary class="form-floating mb-2">
                                                Mother's Maiden Name <span class="required-color">*</span>
                                            </summary>
                                            <div class="form-group mt-2">
                                                <label for="MSurname">Surname:</label>
                                                <input type="text" class="form-control mb-2" id="MSurname" required>
                                                <label for="MName">Name:</label>
                                                <input type="text" class="form-control mb-2" id="MName" required>
                                                <label for="MMName">Middle Name:</label>
                                                <input type="text" class="form-control mb-2" id="MMName" required>
                                            </div>
                                        </details>
                                    </div>
                                </div>

                                <!-- Educational Background -->
                                <div class="tab-pane" id="educationalBackground" role="tabpanel">
                                    <!-- Educational Background fields go here -->
                                    <div class="form-floating mb-2">
                                        <input type="text" name="graduateStudies" class="form-control"
                                            id="floatinggraduateStudies"
                                            placeholder="Enter Graduate Studies (optional)">
                                        <label for="floatinggraduateStudies">Graduate Studies</label>
                                    </div>

                                    <div class="container">
                                        <details>
                                            <summary class="form-floating mb-2">
                                                Elementary <span class="required-color">*</span>
                                            </summary>
                                            <div class="form-group mt-2">
                                                <label for="SchoolName">Name of School (Write in full)</label>
                                                <input type="text" class="form-control mb-2" id="SchoolName" required>
                                                <label for="BasicEducation">BasicEducation/Degree/Course (Write in
                                                    full)</label>
                                                <input type="text" class="form-control mb-2" id="BasicEducation"
                                                    required>
                                                <label for="HighestLevel">Highest Level/Units Earned (if not
                                                    graduated)</label>
                                                <input type="text" class="form-control mb-2" id="Highest Level"
                                                    required>
                                                <label for="YGraduated">Year Graduated</label>
                                                <input type="text" class="form-control mb-2" id="YGraduated" required>
                                                <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                                <input type="text" class="form-control mb-2" id="Scholarship" required>

                                                <div class="row g-2 mb-2">

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="elemPeriod" class="form-control"
                                                                id="floatingElemPeriod" placeholder="2020-12-31"
                                                                required>
                                                            <label for="floatingElemPeriod">Period of Attendance
                                                                From<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="elemperiodEnd" class="form-control"
                                                                id="floatingElemPeriodEnd" placeholder="2020-12-31"
                                                                required>
                                                            <label for="floatingElemPeriodEnd">Period of Attendance
                                                                To<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </details>
                                    </div>

                                    <div class="container">
                                        <details>
                                            <summary class="form-floating mb-2">
                                                Secondary <span class="required-color">*</span>
                                            </summary>
                                            <div class="form-group mt-2">
                                                <label for="SchoolName">Name of School (Write in full)</label>
                                                <input type="text" class="form-control mb-2" id="SchoolName" required>
                                                <label for="BasicEducation">BasicEducation/Degree/Course (Write in
                                                    full)</label>
                                                <input type="text" class="form-control mb-2" id="BasicEducation"
                                                    required>
                                                <label for="HighestLevel">Highest Level/Units Earned (if not
                                                    graduated)</label>
                                                <input type="text" class="form-control mb-2" id="Highest Level"
                                                    required>
                                                <label for="YGraduated">Year Graduated</label>
                                                <input type="text" class="form-control mb-2" id="YGraduated" required>
                                                <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                                <input type="text" class="form-control mb-2" id="Scholarship" required>

                                                <div class="row g-2 mb-2">

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="secondperiod" class="form-control"
                                                                id="floatingSecondPeriod" placeholder="2020-12-31"
                                                                required>
                                                            <label for="floatingSecondPeriod">Period of Attendance
                                                                From<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="secondperiodEnd"
                                                                class="form-control" id="floatingSecondPeriodEnd"
                                                                placeholder="2020-12-31" required>
                                                            <label for="floatingSecondPeriodEnd">Period of Attendance
                                                                To<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </details>
                                    </div>

                                    <div class="container">
                                        <details>
                                            <summary class="form-floating mb-2">
                                                Vocational / Trade Course <span class="required-color">*</span>
                                            </summary>
                                            <div class="form-group mt-2">
                                                <label for="SchoolName">Name of School (Write in full)</label>
                                                <input type="text" class="form-control mb-2" id="SchoolName" required>
                                                <label for="BasicEducation">BasicEducation/Degree/Course (Write in
                                                    full)</label>
                                                <input type="text" class="form-control mb-2" id="BasicEducation"
                                                    required>
                                                <label for="HighestLevel">Highest Level/Units Earned (if not
                                                    graduated)</label>
                                                <input type="text" class="form-control mb-2" id="Highest Level"
                                                    required>
                                                <label for="YGraduated">Year Graduated</label>
                                                <input type="text" class="form-control mb-2" id="YGraduated" required>
                                                <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                                <input type="text" class="form-control mb-2" id="Scholarship" required>

                                                <div class="row g-2 mb-2">

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="vocationalperiod"
                                                                class="form-control" id="floatingVocationalPeriod"
                                                                placeholder="2020-12-31" required>
                                                            <label for="floatingVocationalPeriod">Period of Attendance
                                                                From<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="vocationalperiodEnd"
                                                                class="form-control" id="floatingVocationalPeriodEnd"
                                                                placeholder="2020-12-31" required>
                                                            <label for="floatingVocationalPeriodEnd">Period of
                                                                Attendance
                                                                To<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </details>
                                    </div>

                                    <div class="container">
                                        <details>
                                            <summary class="form-floating mb-2">
                                                College <span class="required-color">*</span>
                                            </summary>
                                            <div class="form-group mt-2">
                                                <label for="SchoolName">Name of School (Write in full)</label>
                                                <input type="text" class="form-control mb-2" id="SchoolName" required>
                                                <label for="BasicEducation">BasicEducation/Degree/Course (Write in
                                                    full)</label>
                                                <input type="text" class="form-control mb-2" id="BasicEducation"
                                                    required>
                                                <label for="HighestLevel">Highest Level/Units Earned (if not
                                                    graduated)</label>
                                                <input type="text" class="form-control mb-2" id="Highest Level"
                                                    required>
                                                <label for="YGraduated">Year Graduated</label>
                                                <input type="text" class="form-control mb-2" id="YGraduated" required>
                                                <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                                <input type="text" class="form-control mb-2" id="Scholarship" required>

                                                <div class="row g-2 mb-2">

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="collegeperiod" class="form-control"
                                                                id="floatingCollegePeriod" placeholder="2020-12-31"
                                                                required>
                                                            <label for="floatingCollegePeriod">Period of Attendance
                                                                From<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="date" name="collegeperiodEnd"
                                                                class="form-control" id="floatingCollegePeriodEnd"
                                                                placeholder="2020-12-31" required>
                                                            <label for="floatingCollegePeriodEnd">Period of Attendance
                                                                To<span class="required-color">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </details>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="clearAddEmployeeInputs">Clear</button>
                            <input type="submit" name="addEmployeeInfo" value="Add Employee" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div>
        <?php
        include($components_file_footer);
        ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>