<?php
include("../../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$departmentlabel = "";

if ($_GET['departmentlabel'] !== "index.php" && $_GET['departmentlabel'] !== "index.html") {
    $departmentlabel = $_GET['departmentlabel'];
    $_SESSION['departmentlabel'] = $_GET['departmentlabel'];
} else {
    if (isset($_SESSION['departmentlabel'])) {
        unset($_SESSION['departmentlabel']);
    }
}

if ($departmentlabel) {

    if (strcasecmp($departmentlabel, 'pending') == 0 || strcasecmp($departmentlabel, 'other') == 0 || strcasecmp($departmentlabel, 'others') == 0 || strcasecmp($departmentlabel, 'unassigned') == 0 || strcasecmp($departmentlabel, 'unassign') == 0) {
        $empsql = "SELECT u.*, d.departmentName
           FROM tbl_useraccounts u
           LEFT JOIN tbl_departments d ON u.department = d.department_id
           WHERE d.department_id IS NULL
           ORDER BY u.lastName ASC";
        $employees = $database->query($empsql);
    } else {
        $empsql = "SELECT
                        ua.*,
                        d.departmentName
                    FROM
                        tbl_useraccounts ua
                    LEFT JOIN
                        tbl_departments d ON ua.department = d.department_id
                    WHERE
                        ua.department = ?
                    ORDER BY
                        ua.lastName ASC";

        $stmt = $database->prepare($empsql);
        $stmt->bind_param("s", $departmentlabel);
        $stmt->execute();

        $employees = $stmt->get_result();
    }

} else {
    $empsql = "SELECT
                ua.*,
                d.departmentName
            FROM
                tbl_useraccounts ua
            LEFT JOIN
                tbl_departments d ON ua.department = d.department_id ORDER BY ua.lastName ASC";

    $employees = $database->query($empsql);
}

$deptsql = "SELECT * FROM tbl_departments";

$department_result = $database->query($deptsql);
$departments = [];

if ($department_result->num_rows > 0) {
    while ($departmentData = $department_result->fetch_assoc()) {
        $departments[] = $departmentData;
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
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div class="box-container">
                <div>
                    <a href="<?php echo $location_admin_departments; ?>"><button
                            class="custom-regular-button">Back</button></a>
                    <div class="title-text">List of Employees</div>
                </div>

                <!-- Add Modal -->
                <form action="<?php echo $action_add_employee; ?>" method="post" class="modal fade" id="addEmployee"
                    tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addEmployeeModalLongTitle">Create New Employee</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" value="<?php echo $departmentlabel; ?>" name="departmentlabel" />
                                <div class="row g-2 mb-2">
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" name="employeeId" class="form-control"
                                                id="floatingEmployeeId" placeholder="TEMP0001" required>
                                            <label for="floatingEmployeeId">Employee ID <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <select name="role" class="form-select" id="floatingSelectRole"
                                                aria-label="Floating Role Selection" required>
                                                <option value="Employee" selected>Employee</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                            <label for="floatingSelectRole">Account Role <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="email" name="email" class="form-control" id="floatingEmail"
                                        placeholder="name@example.com" autocomplete="off" required>
                                    <label for="floatingEmail">Email address <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" name="password" class="form-control" id="floatingPassword"
                                        placeholder="Password" required>
                                    <label for="floatingPassword">Password <span class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="firstName" class="form-control" id="floatingFirstName"
                                        placeholder="Peter" required>
                                    <label for="floatingFirstName">First Name <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="middleName" class="form-control" id="floatingMiddleName"
                                        placeholder="Benjamin">
                                    <label for="floatingMiddleName">Middle Name</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="lastName" class="form-control" id="floatingLastName"
                                        placeholder="Parker" required>
                                    <label for="floatingLastName">Last Name <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="suffix" class="form-control" id="floatingSuffix"
                                        placeholder="Jr.">
                                    <label for="floatingSuffix">Suffix</label>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" name="age" class="form-control" id="floatingAge"
                                                min="0" max="125" placeholder="32" required>
                                            <label for="floatingAge">Age <span class="required-color">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <select name="sex" class="form-select" id="floatingSex"
                                                aria-label="Floating Sex Selection" required>
                                                <option value="" selected></option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Prefer Not To Say">Prefer Not To Say</option>
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
                                                <option value="Divorced">Divorced</option>
                                            </select>
                                            <label for="floatingCivilStatus">Civil Status <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-2">
                                    <select name="department" class="form-select" id="floatingDepartmentSelect"
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
                                    <label for="floatingDepartmentSelect">Department <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="jobPosition" class="form-control" id="floatingJobPosition"
                                        placeholder="IT Personnel" required>
                                    <label for="floatingJobPosition">Job Position <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="date" name="dateStarted" class="form-control" id="floatingDateStarted"
                                        placeholder="12-31-2001" value="<?php echo date('Y-m-d'); ?>" required>
                                    <label for="floatingDateStarted">Date Started <span
                                            class="required-color">*</span></label>
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

                <form action="<?php echo $action_upload_leave_record; ?>" method="post" class="modal fade" id="uploadLeaveRecord"
                      tabindex="-1" role="dialog" aria-labelledby="uploadLeaveRecordTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addEmployeeModalLongTitle">Upload Leave Record (Late)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-2">
                                    <input type="file" name="file" class="form-control" id="file" autocomplete="off" required>
                                    <label for="file">CSV File <span
                                                class="required-color">*</span></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="upload" value="Upload" class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Edit Modal -->
                <form action="<?php echo $action_edit_employee; ?>" method="post" class="modal fade" id="editEmployee"
                    tabindex="-1" role="dialog" aria-labelledby="editEmployeeTitle" aria-hidden="true">
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
                                            <input type="text" name="employeeId" class="form-control"
                                                id="floatingEditEmployeeId" placeholder="TEMP0001" required>
                                            <label for="floatingEditEmployeeId">Employee ID <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <select name="role" class="form-select" id="floatingEditSelectRole"
                                                aria-label="Floating Role Selection" required>
                                                <option value="Employee" selected>Employee</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                            <label for="floatingEditSelectRole">Account Role <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="email" name="email" class="form-control" id="floatingEditEmail"
                                        placeholder="name@example.com" autocomplete="off" required>
                                    <label for="floatingEditEmail">Email address <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" name="password" class="form-control"
                                        id="floatingEditPassword" placeholder="Password" required>
                                    <label for="floatingEditPassword">Password <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="firstName" class="form-control" id="floatingEditFirstName"
                                        placeholder="Peter" required>
                                    <label for="floatingEditFirstName">First Name <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="middleName" class="form-control"
                                        id="floatingEditMiddleName" placeholder="Benjamin">
                                    <label for="floatingEditMiddleName">Middle Name</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="lastName" class="form-control" id="floatingEditLastName"
                                        placeholder="Parker" required>
                                    <label for="floatingEditLastName">Last Name <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="text" name="suffix" class="form-control" id="floatingEditSuffix"
                                        placeholder="Sr.">
                                    <label for="floatingEditSuffix">Suffix</label>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="number" name="age" class="form-control" id="floatingEditAge"
                                                min="0" max="125" placeholder="32" required>
                                            <label for="floatingEditAge">Age <span
                                                    class="required-color">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <select name="sex" class="form-select" id="floatingEditSex"
                                                aria-label="Floating Sex Selection" required>
                                                <option value="" selected></option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Prefer Not To Say">Prefer Not To Say</option>
                                            </select>
                                            <label for="floatingEditSex">Sex <span
                                                    class="required-color">*</span></label>
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
                                    <input type="text" name="jobPosition" class="form-control"
                                        id="floatingEditJobPosition" placeholder="IT Personnel" required>
                                    <label for="floatingEditJobPosition">Job Position <span
                                            class="required-color">*</span></label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="date" name="dateStarted" class="form-control"
                                        id="floatingEditDateStarted" placeholder="12-31-2001"
                                        value="<?php echo date('Y-m-d'); ?>" required>
                                    <label for="floatingEditDateStarted">Date Started <span
                                            class="required-color">*</span></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary"
                                    id="resetEditEmployeeInputs">Reset</button>
                                <input type="submit" name="editEmployee" value="Save Changes" class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Multiple Edit Modal -->
                <form action="<?php echo $action_edit_employee; ?>" method="post" class="modal fade"
                    id="editMultipleEmployee" tabindex="-1" role="dialog" aria-labelledby="editMultipleEmployeeTitle"
                    aria-hidden="true">
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
                                                <option value="Admin">Admin</option>
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
                                            <input type="number" name="age" class="form-control"
                                                id="floatingEditMultipleAge" min="0" max="125" placeholder="32">
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
                                            <select name="civilStatus" class="form-select"
                                                id="floatingEditMultipleCivilStatus"
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
                                    <input type="password" name="password" class="form-control"
                                        id="floatingEditMultiplePassword" placeholder="Password">
                                    <label for="floatingEditMultiplePassword">Password</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <select name="department" class="form-select"
                                        id="floatingEditMultipleDepartmentSelect"
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
                                    <input type="text" name="jobPosition" class="form-control"
                                        id="floatingEditMultipleJobPosition" placeholder="IT Personnel">
                                    <label for="floatingEditMultipleJobPosition">Job Position</label>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" name="editMultipleEmployee" value="Save Changes"
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>

                <form method="POST" action="<?php echo $action_delete_employee; ?>">
                    <div class="button-container mb-2">
                        <input type="hidden" value="<?php echo $departmentlabel; ?>" name="departmentlabel" />
                        <!-- Add Button Modal -->
                        <button type="button" class="custom-regular-button" data-toggle="modal"
                            data-target="#addEmployee">
                            Add Employee
                        </button>
                        <button type="button" class="custom-regular-button" data-toggle="modal"
                                data-target="#uploadLeaveRecord">
                            Upload Leave Record (Late)
                        </button>
                        <!-- Multiple Edit Button Modal -->
                        <button type="button" class="custom-regular-button" id="editMultipleEmployeeBTN"
                            data-toggle="modal" data-target="#editMultipleEmployee">
                            Multiple Edit
                        </button>
                        <!-- Multiple Delete -->
                        <input type="submit" name="deleteMultipleEmployee" id="deleteMultipleEmployeeBTN"
                            value="Multiple Delete" class="custom-regular-button" />
                    </div>

                    <table id="employees" class="text-center hover table-striped cell-border order-column"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Sex</th>
                                <th>Civil Status</th>
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
                                            <input type="checkbox" name="selectedEmployee[]"
                                                value="<?php echo $row['employee_id']; ?>" />
                                        </td>
                                        <td>
                                            <?php
                                            echo $row['lastName'] . ' ' . $row['firstName'];
                                            echo $row['middleName'] ? ' ' . substr($row['middleName'], 0, 1) . '.' : $row['middleName'];
                                            echo $row['suffix'] ? ' ' . $row['suffix'] : '';
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
                                            <?php echo $row['sex']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['civilStatus']; ?>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo $action_delete_employee; ?>">
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
                                                    data-age="<?php echo $row['age']; ?>" data-sex="<?php echo $row['sex']; ?>"
                                                    data-civil-status="<?php echo $row['civilStatus']; ?>"
                                                    data-department="<?php echo $row['department']; ?>"
                                                    data-job-position="<?php echo $row['jobPosition']; ?>"
                                                    data-date-started="<?php echo $row['dateStarted']; ?>">
                                                    Edit
                                                </button>

                                                <input type="hidden" name="employeeNum"
                                                    value="<?php echo $row['employee_id']; ?>" />
                                                <input type="hidden" value="<?php echo $departmentlabel; ?>"
                                                    name="departmentlabel" />
                                                <input type="submit" name="deleteEmployee" value="Delete"
                                                    class="custom-regular-button" />
                                            </form>
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
                        columnDefs: [
                            { targets: [3, 4], visible: false },
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
                        "buttons": [
                            {
                                extend: 'copy',
                                exportOptions: {
                                    columns: ':visible:not(:eq(0)):not(:eq(-1))',
                                }
                            },
                            {
                                extend: 'excel',
                                title: 'CustomExcelFileName',
                                filename: 'custom_excel_file',
                                exportOptions: {
                                    columns: ':visible:not(:eq(0)):not(:eq(-1))',
                                }
                            },
                            {
                                extend: 'csv',
                                title: 'CustomCSVFileName',
                                filename: 'custom_csv_file',
                                exportOptions: {
                                    columns: ':visible:not(:eq(0)):not(:eq(-1))',
                                }
                            },
                            {
                                extend: 'pdf',
                                title: 'CustomPDFFileName',
                                filename: 'custom_PDF_file',
                                exportOptions: {
                                    columns: ':visible:not(:eq(0)):not(:eq(-1))',
                                }
                            },
                            {
                                extend: 'print',
                                title: 'List of Employees',
                                filename: 'custom_print_file',
                                message: 'Municipal of Indang',
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

                <!-- Checking Check Values -->
                <script>
                    $(document).ready(function () {
                        $("#clearAddEmployeeInputs").click(function () {
                            $("#addEmployee :input:not(:submit)").val('');
                            $("#addEmployee select").prop('selectedIndex', 0);

                            var currentDate = new Date().toISOString().split('T')[0];
                            $("#floatingDateStarted").val(currentDate);
                        });


                        // Get all selected rows
                        // $('#OLDdeleteEmployees').on('click', function () {
                        //     // let selectedRows = table.rows({ selected: true }).data().toArray();
                        //     // console.log(selectedRows);

                        //     let selectedData = table.rows({ selected: true }).data().pluck(0).toArray();
                        //     console.log(selectedData);
                        // });
                    });

                    function printSelectedValues() {
                        var checkboxes = document.getElementsByName('selectedEmployee[]');
                        var selectedValues = [];

                        // Iterate through checkboxes and check if they are checked
                        for (var i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i].checked) {
                                selectedValues.push(checkboxes[i].value);
                            }
                        }

                        console.log(selectedValues);
                        // console.log("Selected values: " + selectedValues.join(', '));
                    }
                </script>

                <!-- Disable Multiple Select Button -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var checkboxes = document.getElementsByName('selectedEmployee[]');
                        var deleteEmployeesButton = document.getElementById('deleteMultipleEmployeeBTN');
                        var editEmployeesButton = document.getElementById('editMultipleEmployeeBTN');
                        var selectedEmpIDInput = document.getElementById('selectedEmpID');

                        // Add event listener to checkboxes
                        checkboxes.forEach(function (checkbox) {
                            checkbox.addEventListener('change', function () {
                                updateDeleteEmployeesButtonState();
                            });
                        });

                        // Function to update the state of the delete button
                        function updateDeleteEmployeesButtonState() {
                            var selectedValues = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
                            deleteEmployeesButton.disabled = selectedValues.length <= 1;
                            editEmployeesButton.disabled = selectedValues.length <= 1;

                            // Convert the array to JSON and update the value of the hidden input
                            selectedEmpIDInput.value = JSON.stringify(selectedValues);
                        }

                        // Initial update of the delete button state
                        updateDeleteEmployeesButtonState();
                    });
                </script>

                <!-- Edit Modal Fetch and Reset -->
                <script>
                    // Variable to store the state
                    var editEmployeeState = null;

                    $(document).ready(function () {
                        $('.editEmployeeButton').click(function () {
                            // Get data from the button
                            var employeeId = $(this).data('employee-id');
                            var role = $(this).data('role');
                            var email = $(this).data('email');
                            var password = $(this).data('password');
                            var firstName = $(this).data('first-name');
                            var middleName = $(this).data('middle-name');
                            var lastName = $(this).data('last-name');
                            var suffix = $(this).data('suffix');
                            var age = $(this).data('age');
                            var sex = $(this).data('sex');
                            var civilStatus = $(this).data('civil-status');
                            var department = $(this).data('department');
                            var jobPosition = $(this).data('job-position');
                            var dateStarted = $(this).data('date-started');

                            // Set form field values
                            $('#floatingEditOldEmployeeId').val(employeeId);
                            $('#floatingEditEmployeeId').val(employeeId);
                            $('#floatingEditSelectRole').val(role);
                            $('#floatingEditEmail').val(email);
                            $('#floatingEditPassword').val(password);
                            $('#floatingEditFirstName').val(firstName);
                            $('#floatingEditMiddleName').val(middleName);
                            $('#floatingEditLastName').val(lastName);
                            $('#floatingEditSuffix').val(suffix);
                            $('#floatingEditAge').val(age);
                            $('#floatingEditSex').val(sex);
                            $('#floatingEditCivilStatus').val(civilStatus);
                            $('#floatingEditDepartmentSelect').val(department);
                            $('#floatingEditJobPosition').val(jobPosition);
                            $('#floatingEditDateStarted').val(dateStarted);

                            // Save the state
                            editEmployeeState = {
                                employeeId: employeeId,
                                role: role,
                                email: email,
                                password: password,
                                firstName: firstName,
                                middleName: middleName,
                                lastName: lastName,
                                suffix: suffix,
                                age: age,
                                sex: sex,
                                civilStatus: civilStatus,
                                department: department,
                                jobPosition: jobPosition,
                                dateStarted: dateStarted
                            };
                        });

                        // Function to set data based on the saved state
                        function setDataFromState() {
                            if (editEmployeeState) {
                                // Set form field values based on the saved state
                                $('#floatingEditOldEmployeeId').val(editEmployeeState.employeeId);
                                $('#floatingEditEmployeeId').val(editEmployeeState.employeeId);
                                $('#floatingEditSelectRole').val(editEmployeeState.role);
                                $('#floatingEditEmail').val(editEmployeeState.email);
                                $('#floatingEditPassword').val(editEmployeeState.password);
                                $('#floatingEditFirstName').val(editEmployeeState.firstName);
                                $('#floatingEditMiddleName').val(editEmployeeState.middleName);
                                $('#floatingEditLastName').val(editEmployeeState.lastName);
                                $('#floatingEditSuffix').val(editEmployeeState.suffix);
                                $('#floatingEditAge').val(editEmployeeState.age);
                                $('#floatingEditSex').val(editEmployeeState.sex);
                                $('#floatingEditCivilStatus').val(editEmployeeState.civilStatus);
                                $('#floatingEditDepartmentSelect').val(editEmployeeState.department);
                                $('#floatingEditJobPosition').val(editEmployeeState.jobPosition);
                                $('#floatingEditDateStarted').val(editEmployeeState.dateStarted);
                            }
                        }

                        // Add click event handler for the Reset button
                        $('#resetEditEmployeeInputs').click(function () {
                            // Reset form fields to their initial values
                            setDataFromState();
                        });
                    });
                </script>

                <!-- <button onclick="printSelectedValues()">Print Selected Values</button> -->
            </div>
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