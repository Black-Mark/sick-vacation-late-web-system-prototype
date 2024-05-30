<?php
include ("../../../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

$departmentlabel = "";
$departmentName = "";
$departments = getAllDepartments();
$designations = getAllDesignations();

$generatedEmpId = bin2hex(random_bytes(4));

if ($_GET['departmentlabel'] !== "index.php" && $_GET['departmentlabel'] !== "index.html") {
    $departmentlabel = sanitizeInput($_GET['departmentlabel']);
    $_SESSION['departmentlabel'] = $departmentlabel;
} else {
    if (isset($_SESSION['departmentlabel'])) {
        unset($_SESSION['departmentlabel']);
    }
}

if ($departmentlabel) {

    if (strcasecmp($departmentlabel, 'pending') == 0 || strcasecmp($departmentlabel, 'other') == 0 || strcasecmp($departmentlabel, 'others') == 0 || strcasecmp($departmentlabel, 'unassigned') == 0 || strcasecmp($departmentlabel, 'unassign') == 0) {
        $departmentName = "Pending and Unassigned";

        $empsql = "SELECT 
                        u.*, 
                        CASE 
                            WHEN UPPER(d.archive) = 'DELETED' THEN '' 
                            ELSE d.departmentName 
                        END AS departmentName,
                        CASE 
                            WHEN UPPER(desig.archive) = 'DELETED' THEN '' 
                            ELSE desig.designationName 
                        END AS designationName
                    FROM 
                        tbl_useraccounts u
                    LEFT JOIN 
                        tbl_departments d ON u.department = d.department_id
                    LEFT JOIN 
                        tbl_designations desig ON u.jobPosition = desig.designation_id
                    WHERE 
                        (d.department_id IS NULL OR UPPER(d.archive) = 'DELETED') 
                        AND UPPER(u.archive) != 'DELETED'
                    ORDER BY 
                        u.lastName ASC";

        $employees = $database->query($empsql);

    } else {
        for ($i = 0; $i < count($departments); $i++) {
            if ($departments[$i]['department_id'] == $departmentlabel) {
                $departmentName = $departments[$i]['departmentName'];
                break;
            }
        }

        $empsql = "SELECT
                        ua.*,
                        d.departmentName,
                        CASE 
                            WHEN UPPER(desig.archive) = 'DELETED' THEN '' 
                            ELSE desig.designationName 
                        END AS designationName
                    FROM
                        tbl_useraccounts ua
                    LEFT JOIN
                        tbl_departments d ON ua.department = d.department_id
                    LEFT JOIN
                        tbl_designations desig ON ua.jobPosition = desig.designation_id
                    WHERE
                        ua.department = ? AND UPPER(ua.archive) != 'DELETED' AND UPPER(d.archive) != 'DELETED'
                    ORDER BY
                        ua.lastName ASC";

        $stmt = $database->prepare($empsql);
        $stmt->bind_param("s", $departmentlabel);
        $stmt->execute();

        $employees = $stmt->get_result();

    }

} else {
    $departmentName = "All Employees";
    $empsql = " SELECT
                    ua.*,
                    CASE
                        WHEN UPPER(d.archive) = 'DELETED' THEN ''
                        ELSE d.departmentName
                    END AS departmentName,
                    CASE
                        WHEN UPPER(desig.archive) = 'DELETED' THEN ''
                        ELSE desig.designationName
                    END AS designationName
                FROM
                    tbl_useraccounts ua
                LEFT JOIN
                    tbl_departments d ON ua.department = d.department_id
                LEFT JOIN
                    tbl_designations desig ON ua.jobPosition = desig.designation_id
                WHERE
                    UPPER(ua.archive) != 'DELETED'
                ORDER BY
                    ua.lastName ASC;
                ";

    $employees = $database->query($empsql);
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

    <!--Additional Script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js">
    </script>

    <!-- <script src="<?php
    // echo $assets_tailwind; 
    ?>"></script> -->
</head>

<body class="webpage-background-cover-admin">
    <div>
        <?php include ($components_file_topnav) ?>
    </div>

    <!-- Add Modal -->
    <form action="<?php echo $action_add_employee; ?>" method="post" class="modal fade" id="addEmployee" tabindex="-1"
        role="dialog" aria-labelledby="addEmployeeTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLongTitle">Create New Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personalInfo" role="tab">I. Personal
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
                            <input type="hidden" value="<?php echo $departmentlabel; ?>" name="departmentlabel" />
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" name="employeeId" class="form-control"
                                            id="floatingEmployeeId" placeholder="TEMP0001"
                                            value="<?php echo $generatedEmpId; ?>" required>
                                        <label for="floatingEmployeeId">Employee ID <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="role" class="form-select" id="floatingSelectRole"
                                            aria-label="Floating Role Selection" required>
                                            <option value="Employee" selected>Employee</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                        <label for="floatingSelectRole">Account Role <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control" id="floatingEmail"
                                    placeholder="name@example.com" autocomplete="off" required>
                                <label for="floatingEmail">Email address <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="floatingPassword"
                                    placeholder="Password" required>
                                <label for="floatingPassword">Password <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="firstName" class="form-control" id="floatingFirstName"
                                    placeholder="Peter" required>
                                <label for="floatingFirstName">First Name <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="middleName" class="form-control" id="floatingMiddleName"
                                    placeholder="Benjamin">
                                <label for="floatingMiddleName">Middle Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="lastName" class="form-control" id="floatingLastName"
                                    placeholder="Parker" required>
                                <label for="floatingLastName">Last Name <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="suffix" class="form-control" id="floatingSuffix"
                                    placeholder="Jr.">
                                <label for="floatingSuffix">Suffix</label>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="sex" class="form-select" id="floatingSex"
                                            aria-label="Floating Sex Selection" required>
                                            <option value="" selected></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <label for="floatingSex">Sex <span class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="civilStatus" class="form-select" id="floatingCivilStatus"
                                            aria-label="Floating Civil Status Selection" required>
                                            <option value="Single" selected>Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Seperated">Seperated</option>
                                            <option value="Others">Other/s</option>
                                        </select>
                                        <label for="floatingCivilStatus">Civil Status <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="date" name="birthdate" class="form-control" id="floatingBirthdate"
                                    placeholder="01-01-2001" value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingBirthdate">Birthday <span class="required-color">*</span></label>
                            </div>

                            <!-- Additional for Basic Information -->
                            <div class="form-floating mb-2">
                                <input type="text" name="birthplace" class="form-control" id="floatingBirthplace"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingBirthplace">Place of Birth <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="height" class="form-control" id="floatingHeight"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingHeight">Height (m) <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="weight" class="form-control" id="floatingWeight"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingWeight">Weight (kg) <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="bloodtype" class="form-control" id="floatingBloodType"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingBloodType">Blood type <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="gsis" class="form-control" id="floatingGSIS"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingGSIS">GSIS ID NO. <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="pagibig" class="form-control" id="floatingPagibig"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingPagibig">PAGIBIG ID NO. <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="philhealth" class="form-control" id="floatingPhilHealth"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingPhilHealth">PHILHEALTH NO. <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="sss" class="form-control" id="floatingSSS"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingSSS">SSS NO. <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="tin" class="form-control" id="floatingTin"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingTin">TIN NO. <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="agency" class="form-control" id="floatingAgency"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
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
                                        <input type="text" class="form-control mb-2" id="houseNo" required>
                                        <label for="street">Street:</label>
                                        <input type="text" class="form-control mb-2" id="street" required>
                                        <label for="subdivision">Subdivision/Village:</label>
                                        <input type="text" class="form-control mb-2" id="subdivision" required>
                                        <label for="city">City/Municipality:</label>
                                        <input type="text" class="form-control mb-2" id="city" required>
                                        <label for="province">Province:</label>
                                        <input type="text" class="form-control mb-2" id="province" required>
                                        <label for="zipCode">Zip Code:</label>
                                        <input type="text" class="form-control mb-2" id="zipCode" required>
                                    </div>
                                </details>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" name="telephone" class="form-control" id="floatingTelephone"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingTelephone">Telephone NO. <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" name="mobile" class="form-control" id="floatingMobile"
                                    value="<?php // echo date('Y-m-d'); ?>" required>
                                <label for="floatingMobile">Mobile NO. <span class="required-color">*</span></label>
                            </div>
                            <!-- End of Additional Basic information -->

                            <div class="form-floating mb-2">
                                <select name="department" class="form-select" id="floatingDepartmentSelect"
                                    aria-label="Floating Department Selection" required>
                                    <option value="" selected></option>
                                    <?php
                                    if (!empty($departments)) {
                                        foreach ($departments as $department) {
                                            ?>
                                    <option value="<?php echo $department['department_id']; ?>"
                                        <?php echo ($department['department_id'] == $departmentlabel) ? 'selected' : ''; ?>>
                                        <?php echo $department['departmentName']; ?>
                                    </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <option value="Pending"
                                        <?php echo (strcasecmp($departmentlabel, 'pending') == 0 || strcasecmp($departmentlabel, 'other') == 0 || strcasecmp($departmentlabel, 'others') == 0 || strcasecmp($departmentlabel, 'unassigned') == 0 || strcasecmp($departmentlabel, 'unassign') == 0) ? 'selected' : ''; ?>>
                                        Pending</option>
                                </select>
                                <label for="floatingDepartmentSelect">Department <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <select name="jobPosition" class="form-select" id="floatingJobPosition"
                                    aria-label="Floating Designation Selection" required>
                                    <option value="" selected></option>
                                    <?php
                                    if (!empty($designations)) {
                                        foreach ($designations as $designation) {
                                            ?>
                                    <option title="<?php echo $designation['designationDescription']; ?>"
                                        value="<?php echo $designation['designation_id']; ?>">
                                        <?php echo $designation['designationName']; ?>
                                    </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="floatingJobPosition">Job Title <span class="required-color">*</span></label>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="date" name="dateStarted" class="form-control"
                                            id="floatingDateStarted" placeholder="12-31-2001"
                                            value="<?php echo date('Y-m-d'); ?>" required>
                                        <label for="floatingDateStarted">Date Started <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="status" class="form-select" id="floatingSelectStatus"
                                            aria-label="Floating Status Selection" required>
                                            <option value="Active" selected>Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Banned">Banned</option>
                                        </select>
                                        <label for="floatingSelectStatus">Status <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <!-- Initialization if Date Started Month is Less Than the Month of Today  -->
                            <div class="form-floating mb-2">
                                <input type="number" step="any" name="initialVacationCredit" class="form-control"
                                    id="floatingInitialVacationCredit" placeholder="1.25" value="1.25" required>
                                <label for="floatingInitialVacationCredit">Initial Vacation Credit <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" step="any" name="initialSickCredit" class="form-control"
                                    id="floatingInitialSickCredit" placeholder="1.25" value="1.25" required>
                                <label for="floatingInitialSickCredit">Initial Sick Credit <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>

                        <!-- Additional Basic Information Family Background -->
                        <div class="tab-pane" id="familyBackground" role="tabpanel">
                            <!-- Family Background fields go here -->
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseSurname" class="form-control" id="floatingSpouseSurname"
                                    placeholder="Spouse Surname" required>
                                <label for="floatingSpouseSurname">Spouse's Surname <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseName" class="form-control" id="floatingSpouseName"
                                    placeholder="Spouse Name" required>
                                <label for="floatingSpouseName">Spouse's Name <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseMiddlename" class="form-control"
                                    id="floatingSpouseMiddlename" placeholder="Spouse Middlename" required>
                                <label for="floatingSpouseMiddlename">Spouse's Middlename <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseNameExtension" class="form-control"
                                    id="floatingSpouseNameExtension" placeholder="Name extension (Jr, Sr)" required>
                                <label for="floatingSpouseNameExtension">Name extension (Jr, Sr) <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseOccupation" class="form-control"
                                    id="floatingSpouseOccupation" placeholder="Spouse Occupation" required>
                                <label for="floatingSpouseOccupation">Spouse's Occupation <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseEmployer" class="form-control"
                                    id="floatingSpouseEmployer" placeholder="Employer/Business Name" required>
                                <label for="floatingSpouseEmployer">Employer/Business Name <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseBusinessAddress" class="form-control"
                                    id="floatingSpouseBusinessAddress" placeholder="Business Address" required>
                                <label for="floatingSpouseBusinessAddress">Business Address <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="spouseTelephone" class="form-control"
                                    id="floatingSpouseTelephone" placeholder="Telephone No." required>
                                <label for="floatingSpouseTelephone">Telephone No. <span
                                        class="required-color">*</span></label></label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" name="numberOfChildren" class="form-control"
                                    id="floatingNumberOfChildren" placeholder="Number of Children">
                                <label for="floatingNumberOfChildren">Name of Children (Write in fullname) <span
                                        class="required-color">*</span></label></label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="text" name="fathersSurname" class="form-control"
                                    id="floatingfathersSurname" placeholder="Fathers Surname">
                                <label for="floatingfathersSurname">Father's Surname <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="fathersFirstname" class="form-control"
                                    id="floatingfathersFirstname" placeholder="Fathers Firstname">
                                <label for="floatingfathersFirstname">Father's Firstname <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="fathersMiddlename" class="form-control"
                                    id="floatingfathersMiddlename" placeholder="Fathers Middlename">
                                <label for="floatingfathersMiddlename">Father's Middlename <span
                                        class="required-color">*</span></label></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="fathersnameExtension" class="form-control"
                                    id="floatingnameExtension" placeholder="Name Extension">
                                <label for="floatingnameExtension">Name extension (Jr, Sr) <span
                                        class="required-color">*</span></label></label>
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
                                    id="floatinggraduateStudies" placeholder="Graduate Studies">
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
                                        <label for="BasicEducation">BasicEducation/Degree/Course (Write in full)</label>
                                        <input type="text" class="form-control mb-2" id="BasicEducation" required>
                                        <label for="HighestLevel">Highest Level/Units Earned (if not graduated)</label>
                                        <input type="text" class="form-control mb-2" id="Highest Level" required>
                                        <label for="YGraduated">Year Graduated</label>
                                        <input type="text" class="form-control mb-2" id="YGraduated" required>
                                        <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                        <input type="text" class="form-control mb-2" id="Scholarship" required>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="elemPeriod" class="form-control"
                                                        id="floatingElemPeriod" placeholder="2020-12-31" required>
                                                    <label for="floatingElemPeriod">Period of Attendance From<span
                                                            class="required-color">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="elemperiodEnd" class="form-control"
                                                        id="floatingElemPeriodEnd" placeholder="2020-12-31" required>
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
                                        <label for="BasicEducation">BasicEducation/Degree/Course (Write in full)</label>
                                        <input type="text" class="form-control mb-2" id="BasicEducation" required>
                                        <label for="HighestLevel">Highest Level/Units Earned (if not graduated)</label>
                                        <input type="text" class="form-control mb-2" id="Highest Level" required>
                                        <label for="YGraduated">Year Graduated</label>
                                        <input type="text" class="form-control mb-2" id="YGraduated" required>
                                        <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                        <input type="text" class="form-control mb-2" id="Scholarship" required>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="secondperiod" class="form-control"
                                                        id="floatingSecondPeriod" placeholder="2020-12-31" required>
                                                    <label for="floatingSecondPeriod">Period of Attendance From<span
                                                            class="required-color">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="secondperiodEnd" class="form-control"
                                                        id="floatingSecondPeriodEnd" placeholder="2020-12-31" required>
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
                                        <label for="BasicEducation">BasicEducation/Degree/Course (Write in full)</label>
                                        <input type="text" class="form-control mb-2" id="BasicEducation" required>
                                        <label for="HighestLevel">Highest Level/Units Earned (if not graduated)</label>
                                        <input type="text" class="form-control mb-2" id="Highest Level" required>
                                        <label for="YGraduated">Year Graduated</label>
                                        <input type="text" class="form-control mb-2" id="YGraduated" required>
                                        <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                        <input type="text" class="form-control mb-2" id="Scholarship" required>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="vocationalperiod" class="form-control"
                                                        id="floatingVocationalPeriod" placeholder="2020-12-31" required>
                                                    <label for="floatingVocationalPeriod">Period of Attendance From<span
                                                            class="required-color">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="vocationalperiodEnd" class="form-control"
                                                        id="floatingVocationalPeriodEnd" placeholder="2020-12-31"
                                                        required>
                                                    <label for="floatingVocationalPeriodEnd">Period of Attendance
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
                                        <label for="BasicEducation">BasicEducation/Degree/Course (Write in full)</label>
                                        <input type="text" class="form-control mb-2" id="BasicEducation" required>
                                        <label for="HighestLevel">Highest Level/Units Earned (if not graduated)</label>
                                        <input type="text" class="form-control mb-2" id="Highest Level" required>
                                        <label for="YGraduated">Year Graduated</label>
                                        <input type="text" class="form-control mb-2" id="YGraduated" required>
                                        <label for="Scholarship">Scholarship/Academic Honors Received</label>
                                        <input type="text" class="form-control mb-2" id="Scholarship" required>

                                        <div class="row g-2 mb-2">

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="collegeperiod" class="form-control"
                                                        id="floatingCollegePeriod" placeholder="2020-12-31" required>
                                                    <label for="floatingCollegePeriod">Period of Attendance From<span
                                                            class="required-color">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-md">
                                                <div class="form-floating">
                                                    <input type="date" name="collegeperiodEnd" class="form-control"
                                                        id="floatingCollegePeriodEnd" placeholder="2020-12-31" required>
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
                    <input type="submit" name="addEmployee" value="Add Employee" class="btn btn-primary" />
                </div>
            </div>
        </div>
    </form>

    <!-- Include Bootstrap JavaScript for the tabs functionality -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Edit Modal -->
    <form action="<?php echo $action_edit_employee; ?>" method="post" class="modal fade" id="editEmployee" tabindex="-1"
        role="dialog" aria-labelledby="editEmployeeTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLongTitle">Edit Employee Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="oldEmployeeId" id="floatingEditOldEmployeeId" />
                    <input type="hidden" value="<?php echo $departmentlabel; ?>" name="departmentlabel" />
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" name="employeeId" class="form-control" id="floatingEditEmployeeId"
                                    placeholder="TEMP0001" required readonly>
                                <label for="floatingEditEmployeeId">Employee ID <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="role" class="form-select" id="floatingEditSelectRole"
                                    aria-label="Floating Role Selection" required>
                                    <option value="Employee" selected>Employee</option>
                                    <option value="Staff">Staff</option>
                                </select>
                                <label for="floatingEditSelectRole">Account Role <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="email" name="email" class="form-control" id="floatingEditEmail"
                            placeholder="name@example.com" autocomplete="off" required>
                        <label for="floatingEditEmail">Email address <span class="required-color">*</span></label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="password" name="password" class="form-control" id="floatingEditPassword"
                            placeholder="Password" required>
                        <label for="floatingEditPassword">Password <span class="required-color">*</span></label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="firstName" class="form-control" id="floatingEditFirstName"
                            placeholder="Peter" required>
                        <label for="floatingEditFirstName">First Name <span class="required-color">*</span></label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="middleName" class="form-control" id="floatingEditMiddleName"
                            placeholder="Benjamin">
                        <label for="floatingEditMiddleName">Middle Name</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="lastName" class="form-control" id="floatingEditLastName"
                            placeholder="Parker" required>
                        <label for="floatingEditLastName">Last Name <span class="required-color">*</span></label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="suffix" class="form-control" id="floatingEditSuffix" placeholder="Sr.">
                        <label for="floatingEditSuffix">Suffix</label>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="sex" class="form-select" id="floatingEditSex"
                                    aria-label="Floating Sex Selection" required>
                                    <option value="" selected></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label for="floatingEditSex">Sex <span class="required-color">*</span></label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="civilStatus" class="form-select" id="floatingEditCivilStatus"
                                    aria-label="Floating Civil Status Selection" required>
                                    <option value="Single" selected>Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                                <label for="floatingEditCivilStatus">Civil Status <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="date" name="birthdate" class="form-control" id="floatingEditBirthdate"
                            placeholder="01-01-2001" value="<?php // echo date('Y-m-d'); ?>" required>
                        <label for="floatingEditBirthdate">Birthday <span class="required-color">*</span></label>
                    </div>
                    <div class="form-floating mb-2">
                        <select name="department" class="form-select" id="floatingEditDepartmentSelect"
                            aria-label="Floating Department Selection" required>
                            <option value="" selected></option>
                            <?php
                            if (!empty($departments)) {
                                foreach ($departments as $department) {
                                    ?>
                            <option value="<?php echo $department['department_id']; ?>">
                                <?php echo $department['departmentName']; ?>
                            </option>
                            <?php
                                }
                            }
                            ?>
                            <option value="Pending">Pending</option>
                        </select>
                        <label for="floatingEditDepartmentSelect">Department <span
                                class="required-color">*</span></label>
                    </div>
                    <div class="form-floating mb-2">
                        <select name="jobPosition" class="form-select" id="floatingEditJobPosition"
                            aria-label="Floating Designation Selection" required>
                            <option value="" selected></option>
                            <?php
                            if (!empty($designations)) {
                                foreach ($designations as $designation) {
                                    ?>
                            <option title="<?php echo $designation['designationDescription']; ?>"
                                value="<?php echo $designation['designation_id']; ?>">
                                <?php echo $designation['designationName']; ?>
                            </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label for="floatingEditJobPosition">Job Title <span class="required-color">*</span></label>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="date" name="dateStarted" class="form-control" id="floatingEditDateStarted"
                                    placeholder="12-31-2001" value="<?php echo date('Y-m-d'); ?>" required>
                                <label for="floatingEditDateStarted">Date Started <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="status" class="form-select" id="floatingEditSelectStatus"
                                    aria-label="Floating Status Selection" required>
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Banned">Banned</option>
                                </select>
                                <label for="floatingEditSelectStatus">Status <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="resetEditEmployeeInputs">Reset</button>
                    <input type="submit" name="editEmployee" value="Save Changes" class="btn btn-primary" />
                </div>
            </div>
        </div>
    </form>

    <!-- Multiple Edit Modal -->
    <!-- <form action="<?php echo $action_edit_employee; ?>" method="post" class="modal fade" id="editMultipleEmployee"
        tabindex="-1" role="dialog" aria-labelledby="editMultipleEmployeeTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMultipleEmployeeModalLongTitle">Multiple Data
                        Modification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="selectedEmpID[]" id="selectedEmpID" />
                    <input type="hidden" value="<?php echo $departmentlabel; ?>" name="departmentlabel" />
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="role" class="form-select" id="floatingEditMultipleSelectRole"
                                    aria-label="Floating Role Selection">
                                    <option value="" selected></option>
                                    <option value="Employee">Employee</option>
                                    <option value="Staff">Staff</option>
                                </select>
                                <label for="floatingEditMultipleSelectRole">Account Role</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="date" name="dateStarted" class="form-control"
                                    id="floatingEditMultipleDateStarted" placeholder="12-31-2001">
                                <label for="floatingEditMultipleDateStarted">Date Started</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="number" name="age" class="form-control" id="floatingEditMultipleAge"
                                    min="0" max="125" placeholder="32">
                                <label for="floatingEditMultipleAge">Age</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="sex" class="form-select" id="floatingEditMultipleSex"
                                    aria-label="Floating Sex Selection">
                                    <option value="" selected></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Prefer Not To Say">Prefer Not To Say</option>
                                </select>
                                <label for="floatingEditMultipleSex">Sex</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="civilStatus" class="form-select" id="floatingEditMultipleCivilStatus"
                                    aria-label="Floating Civil Status Selection">
                                    <option value="" selected></option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                                <label for="floatingEditMultipleCivilStatus">Civil Status</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="password" name="password" class="form-control" id="floatingEditMultiplePassword"
                            placeholder="Password">
                        <label for="floatingEditMultiplePassword">Password</label>
                    </div>
                    <div class="form-floating mb-2">
                        <select name="department" class="form-select" id="floatingEditMultipleDepartmentSelect"
                            aria-label="Floating Department Selection">
                            <option value="" selected></option>
                            <?php
                            if (!empty($departments)) {
                                foreach ($departments as $department) {
                                    ?>
                                    <option value="<?php echo $department['department_id']; ?>">
                                        <?php echo $department['departmentName']; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                            <option value="Pending">Pending</option>
                        </select>
                        <label for="floatingEditMultipleDepartmentSelect">Department</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="jobPosition" class="form-control" id="floatingEditMultipleJobPosition"
                            placeholder="IT Personnel">
                        <label for="floatingEditMultipleJobPosition">Job Position</label>
                    </div>
                    <div class="form-floating">
                        <select name="status" class="form-select" id="floatingEditMultipleStatus"
                            aria-label="Floating Multiple Status Selection" required>
                            <option value="" selected></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Banned">Banned</option>
                        </select>
                        <label for="floatingEditSelectStatus">Status <span class="required-color">*</span></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="editMultipleEmployee" value="Save Changes" class="btn btn-primary" />
                </div>
            </div>
        </div>
    </form> -->

    <div class="page-container">
        <div class="page-content">

            <div class="box-container">
                <div>
                    <a href="<?php echo $location_admin_departments; ?>"><button
                            class="custom-regular-button">Back</button></a>
                    <div class="title-text">List of Employees</div>
                    <div class="title-text-caption">
                        (
                        <?php echo $departmentName; ?>)
                    </div>
                </div>

                <form method="POST" action="<?php echo $action_delete_employee; ?>">
                    <div class="button-container mb-2">
                        <input type="hidden" value="<?php echo $departmentlabel; ?>" name="departmentlabel" />
                        <!-- Add Button Modal -->
                        <button type="button" class="custom-regular-button" data-toggle="modal"
                            data-target="#addEmployee">
                            Add Employee
                        </button>
                        <!-- Multiple Edit Button Modal -->
                        <!--
                        <button type="button" class="custom-regular-button" id="editMultipleEmployeeBTN"
                            data-toggle="modal" data-target="#editMultipleEmployee">
                            Multiple Edit
                        </button>
                        -->
                        <!-- Multiple Delete -->
                        <input type="submit" name="deleteMultipleEmployee" id="deleteMultipleEmployeeBTN" value="Delete"
                            class="custom-regular-button" />
                    </div>

                    <table id="employees" class="text-center hover table-striped cell-border order-column"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Job Title</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Civil Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($employees->num_rows > 0) {
                                while ($row = $employees->fetch_assoc()) {
                                    ?>
                            <tr>
                                <td>
                                    <?php if (strtoupper($row['role']) != "ADMIN") { ?>
                                    <input type="checkbox" name="selectedEmployee[]"
                                        value="<?php echo $row['employee_id']; ?>" />
                                    <?php } else { ?>
                                    <input type="checkbox" name="disabledones"
                                        value="<?php echo $row['employee_id']; ?>" disabled />
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php
                                            echo organizeFullName($row['firstName'], $row['middleName'], $row['lastName'], $row['suffix'], $order = 2);
                                            ?>
                                </td>
                                <td>
                                    <?php
                                            if ($row['departmentName']) {
                                                echo $row['departmentName'];
                                            } else if (strcasecmp($row['department'], "Pending") == 0) {
                                                echo "Pending";
                                            } else {
                                                echo "Unassigned";
                                            }
                                            ?>
                                </td>
                                <td>
                                    <?php
                                            if ($row['designationName']) {
                                                echo $row['designationName'];
                                            } else {
                                                echo "Unassigned";
                                            }
                                            ?>
                                </td>
                                <td>
                                    <?php echo $row['sex']; ?>
                                </td>
                                <td>
                                    <?php echo identifyEmployeeAge($row['birthdate']); ?>
                                </td>
                                <td>
                                    <?php echo $row['civilStatus']; ?>
                                </td>
                                <td>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <!-- <form method="POST" action="<?php echo $action_delete_employee; ?>"> -->
                                    <a
                                        href="<?php echo $location_admin_departments_employee . '/' . $row['employee_id'] . '/'; ?>">
                                        <button type="button" class="custom-regular-button">
                                            View
                                        </button>
                                    </a>
                                    <!-- data-photo-url="<?php //echo $row['photoURL']; ?>" -->
                                    <button type="button" class="custom-regular-button editEmployeeButton"
                                        data-toggle="modal" data-target="#editEmployee"
                                        data-employee-id="<?php echo $row['employee_id']; ?>"
                                        data-role="<?php echo $row['role']; ?>"
                                        data-email="<?php echo $row['email']; ?>"
                                        data-password="<?php echo $row['password']; ?>"
                                        data-first-name="<?php echo $row['firstName']; ?>"
                                        data-middle-name="<?php echo $row['middleName']; ?>"
                                        data-last-name="<?php echo $row['lastName']; ?>"
                                        data-suffix="<?php echo $row['suffix']; ?>"
                                        data-sex="<?php echo $row['sex']; ?>"
                                        data-civil-status="<?php echo $row['civilStatus']; ?>"
                                        data-birthdate="<?php echo $row['birthdate']; ?>"
                                        data-department="<?php echo $row['department']; ?>"
                                        data-job-position="<?php echo $row['jobPosition']; ?>"
                                        data-date-started="<?php echo $row['dateStarted']; ?>"
                                        data-account-status="<?php echo $row['status']; ?>">
                                        Edit
                                    </button>

                                    <!-- <input type="hidden" name="employeeNum"
                                                    value="<?php echo $row['employee_id']; ?>" />
                                                <input type="hidden" value="<?php echo $departmentlabel; ?>"
                                                    name="departmentlabel" />
                                                <?php if ($row['employee_id'] != $_SESSION['employeeId']) { ?>
                                                    <input type="submit" name="deleteEmployee" value="Delete"
                                                        class="custom-regular-button" />
                                                <?php } ?> -->
                                    <!-- </form> -->
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </form>

                <!-- Data Table Configuration -->
                <script>
                let table = new DataTable('#employees', {
                    pagingType: 'full_numbers',
                    scrollCollapse: true,
                    scrollY: '100%',
                    scrollX: true,
                    // 'select': {
                    //     'style': 'multi',
                    // },
                    // ordering: false,
                    columnDefs: [{
                            targets: [<?php if ($departmentlabel != "") {
                                    echo "2,";
                                } ?>5, 7],
                            visible: false
                        },
                        {
                            'targets': 0,
                            'orderable': false,
                            // 'checkboxes': {
                            //     'selectRow': true,
                            //     // 'page': 'current',
                            // }
                        },
                        {
                            'targets': -1,
                            'orderable': false,
                            // 'checkboxes': {
                            //     'selectRow': true,
                            //     // 'page': 'current',
                            // }
                        },
                        // {
                        //     targets: [0],
                        //     orderData: [0, 1]
                        // },
                        // {
                        //     targets: [1],
                        //     orderData: [1, 0]
                        // },
                        // {
                        //     targets: [4],
                        //     orderData: [4, 0]
                        // }
                    ],
                    search: {
                        return: true
                    },
                    "dom": 'Blfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, 'All']
                    ],
                    // "colReorder": true,
                    "buttons": [{
                            extend: 'copy',
                            exportOptions: {
                                columns: ':visible:not(:eq(0)):not(:eq(-1))',
                            }
                        },
                        {
                            extend: 'excel',
                            title: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            filename: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            exportOptions: {
                                columns: ':visible:not(:eq(0)):not(:eq(-1))',
                            }
                        },
                        {
                            extend: 'csv',
                            title: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            filename: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            exportOptions: {
                                columns: ':visible:not(:eq(0)):not(:eq(-1))',
                            }
                        },
                        {
                            extend: 'pdf',
                            title: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            filename: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            message: 'Produced and Prepared by the Human Resources System',
                            exportOptions: {
                                columns: ':visible:not(:eq(0)):not(:eq(-1))',
                            }
                        },
                        {
                            extend: 'print',
                            title: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            filename: '<?php echo $departmentName ? $departmentName . ' - ' : ''; ?>List of Employees',
                            message: 'Produced and Prepared by the Human Resources System',
                            exportOptions: {
                                columns: ':visible:not(:eq(0)):not(:eq(-1))',
                            }
                        },
                        {
                            "extend": "colvis",
                            text: 'Column Visibility',
                            columns: ':first,:gt(0),:last'
                        }
                    ],
                    // responsive: true,
                });
                </script>

                <!-- <button onclick="printSelectedValues()">Print Selected Values</button> -->
            </div>
        </div>
    </div>

    <script src="<?php echo $assets_file_employeeListing; ?>"></script>
    <div>
        <?php
        include ($components_file_footer);
        ?>
    </div>

    <?php include ($components_file_toastify); ?>

</body>

</html>