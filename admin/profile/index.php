<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

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
    <link rel="icon" type="image/x-icon" href="../../assets/images/indang-logo.ico">

    <link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css">
    <script src="../../assets/bootstrap/assets/js/vendor/jquery-slim.min.js"></script>
    <script src="../../assets/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>

    <link rel='stylesheet' href='../../assets/font-awesome/css/font-awesome.min.css'>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- <script src="../assets/js/tailwind.js"></script> -->
</head>

<body class="webpage-background-cover-admin">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class="text-experiment">This is Profile Page</div>

            <!-- Multiple Edit Button Modal -->
            <div class="mb-1">
                <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#editMultipleEmployee">
                    Multiple Edit
                </button>
            </div>

            <!-- Multiple Edit Modal -->
            <form action="<?php echo $action_edit_employee; ?>" method="post" class="modal fade"
                id="editMultipleEmployee" tabindex="-1" role="dialog" aria-labelledby="editMultipleEmployeeTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMultipleEmployeeModalLongTitle">Create New Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" name="employeeId" class="form-control"
                                            id="floatingEditMultipleEmployeeId" placeholder="TEMP0001" required>
                                        <label for="floatingEditMultipleEmployeeId">Employee ID <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="role" class="form-select" id="floatingEditMultipleSelectRole"
                                            aria-label="Floating Role Selection" required>
                                            <option value="Employee" selected>Employee</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        <label for="floatingEditMultipleSelectRole">Account Role <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control" id="floatingEditMultipleEmail"
                                    placeholder="name@example.com" autocomplete="off" required>
                                <label for="floatingEditMultipleEmail">Email address <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="floatingEditMultiplePassword"
                                    placeholder="Password" required>
                                <label for="floatingEditMultiplePassword">Password <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="firstName" class="form-control" id="floatingEditMultipleFirstName"
                                    placeholder="Peter" required>
                                <label for="floatingEditMultipleFirstName">First Name <span class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="middleName" class="form-control" id="floatingEditMultipleMiddleName"
                                    placeholder="Benjamin">
                                <label for="floatingEditMultipleMiddleName">Middle Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="lastName" class="form-control" id="floatingEditMultipleLastName"
                                    placeholder="Parker" required>
                                <label for="floatingEditMultipleLastName">Last Name <span class="required-color">*</span></label>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="number" name="age" class="form-control" id="floatingEditMultipleAge" min="0"
                                            max="125" placeholder="32" required>
                                        <label for="floatingEditMultipleAge">Age <span class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="sex" class="form-select" id="floatingEditMultipleSex"
                                            aria-label="Floating Sex Selection" required>
                                            <option value="" selected>Prefer Not To Say</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <label for="floatingEditMultipleSex">Sex <span class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select name="civilStatus" class="form-select" id="floatingEditMultipleCivilStatus"
                                            aria-label="Floating Civil Status Selection" required>
                                            <option value="Single" selected>Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Divorced">Divorced</option>
                                        </select>
                                        <label for="floatingEditMultipleCivilStatus">Civil Status <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-2">
                                <select name="department" class="form-select" id="floatingEditMultipleDepartmentSelect"
                                    aria-label="Floating Department Selection" required>
                                    <option value="" selected>Pending</option>
                                    <option value="1">Department of Math</option>
                                    <option value="2">Department of Humanity</option>
                                    <option value="3">Department of Science</option>
                                </select>
                                <label for="floatingEditMultipleDepartmentSelect">Department <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" name="jobPosition" class="form-control" id="floatingEditMultipleJobPosition"
                                    placeholder="IT Personnel" required>
                                <label for="floatingEditMultipleJobPosition">Job Position <span
                                        class="required-color">*</span></label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="date" name="dateStarted" class="form-control" id="floatingEditMultipleDateStarted"
                                    placeholder="12-31-2001" value="<?php echo date('Y-m-d'); ?>" required>
                                <label for="floatingEditMultipleDateStarted">Date Started <span
                                        class="required-color">*</span></label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="cleareditEmployeeInputs">Clear</button>
                            <input type="submit" name="editMultipleEmployee" value="Save Changes" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- <div>
        <?php
        // include($components_file_footer)
        ?>
    </div> -->
</body>

</html>