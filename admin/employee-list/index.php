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
                <h3 class="title-text">List of Employees</h3>

                <div class="button-container mb-1">
                    <!-- Add Button Modal -->
                    <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#addEmployee">
                        Add Employee
                    </button>

                    <!-- Add Modal -->
                    <form action="<?php echo $action_add_employee; ?>" method="post" class="modal fade custom-scrollbar"
                        id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEmployeeModalLongTitle">Create New Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
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
                                        <input type="password" name="password" class="form-control"
                                            id="floatingPassword" placeholder="Password" required>
                                        <label for="floatingPassword">Password <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="firstName" class="form-control" id="floatingFirstName"
                                            placeholder="Peter" required>
                                        <label for="floatingFirstName">First Name <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="middleName" class="form-control"
                                            id="floatingMiddleName" placeholder="Benjamin">
                                        <label for="floatingMiddleName">Middle Name</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="lastName" class="form-control" id="floatingLastName"
                                            placeholder="Parker" required>
                                        <label for="floatingLastName">Last Name <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <input type="number" name="age" class="form-control" id="floatingAge"
                                                    min="0" max="125" placeholder="32" required>
                                                <label for="floatingAge">Age <span
                                                        class="required-color">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <select name="sex" class="form-select" id="floatingSex"
                                                    aria-label="Floating Sex Selection" required>
                                                    <option value="" selected>Prefer Not To Say</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <label for="floatingSex">Sex <span
                                                        class="required-color">*</span></label>
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
                                            <option value="" selected>Pending</option>
                                            <option value="1">Department of Math</option>
                                            <option value="2">Department of Humanity</option>
                                            <option value="3">Department of Science</option>
                                        </select>
                                        <label for="floatingDepartmentSelect">Department <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="jobPosition" class="form-control"
                                            id="floatingJobPosition" placeholder="IT Personnel" required>
                                        <label for="floatingJobPosition">Job Position <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="date" name="dateStarted" class="form-control"
                                            id="floatingDateStarted" placeholder="12-31-2001"
                                            value="<?php echo date('Y-m-d'); ?>" required>
                                        <label for="floatingDateStarted">Date Started <span
                                                class="required-color">*</span></label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"
                                        id="clearAddEmployeeInputs">Clear</button>
                                    <input type="submit" name="addEmployee" value="Save Changes"
                                        class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Edit Button Modal -->
                    <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#editEmployee">
                        Edit
                    </button>

                    <!-- Edit Modal -->
                    <form action="<?php echo $action_edit_employee; ?>" method="post"
                        class="modal fade custom-scrollbar" id="editEmployee" tabindex="-1" role="dialog"
                        aria-labelledby="editEmployeeTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEmployeeModalLongTitle">Create New Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
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
                                        <input type="text" name="firstName" class="form-control"
                                            id="floatingEditFirstName" placeholder="Peter" required>
                                        <label for="floatingEditFirstName">First Name <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="middleName" class="form-control"
                                            id="floatingEditMiddleName" placeholder="Benjamin">
                                        <label for="floatingEditMiddleName">Middle Name</label>
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text" name="lastName" class="form-control"
                                            id="floatingEditLastName" placeholder="Parker" required>
                                        <label for="floatingEditLastName">Last Name <span
                                                class="required-color">*</span></label>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <input type="number" name="age" class="form-control"
                                                    id="floatingEditAge" min="0" max="125" placeholder="32" required>
                                                <label for="floatingEditAge">Age <span
                                                        class="required-color">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <select name="sex" class="form-select" id="floatingEditSex"
                                                    aria-label="Floating Sex Selection" required>
                                                    <option value="" selected>Prefer Not To Say</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <label for="floatingEditSex">Sex <span
                                                        class="required-color">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <select name="civilStatus" class="form-select"
                                                    id="floatingEditCivilStatus"
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
                                            <option value="" selected>Pending</option>
                                            <option value="1">Department of Math</option>
                                            <option value="2">Department of Humanity</option>
                                            <option value="3">Department of Science</option>
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
                                        id="cleareditEmployeeInputs">Clear</button>
                                    <input type="submit" name="editEmployee" value="Save Changes"
                                        class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </form>

                    <button type="button" id="deleteEmployees" class="custom-regular-button" data-toggle="modal"
                        data-target="#deleteEmployee">
                        Delete
                    </button>

                </div>

                <table id="employees" class="text-center hover table-striped cell-border order-column"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_useraccounts";
                        $result = $database->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selectedEmployee[]"
                                            value="<?php echo $row['employee_id']; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $row['lastName']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['firstName']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['middleName']; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="custom-regular-button" data-toggle="modal"
                                            data-target="#addEmployee">
                                            View
                                        </button>
                                        <button type="button" class="custom-regular-button" data-toggle="modal"
                                            data-target="#addEmployee">
                                            Edit
                                        </button>
                                        <button type="button" class="custom-regular-button" data-toggle="modal"
                                            data-target="#addEmployee">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

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
                            {
                                'targets': 0,
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
                            'copy',
                            {
                                extend: 'excel',
                                title: 'CustomExcelFileName',
                                filename: 'custom_excel_file'
                            },
                            {
                                extend: 'csv',
                                title: 'CustomCSVFileName',
                                filename: 'custom_csv_file',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdf',
                                title: 'CustomPDFFileName',
                                filename: 'custom_PDF_file',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'print',
                                title: 'CustomPrintFileName',
                                filename: 'custom_print_file',
                                message: 'This print was produced by Computer',
                                exportOptions: {
                                    columns: ':visible'
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

                <script>
                    $(document).ready(function () {
                        $("#clearAddEmployeeInputs").click(function () {
                            $("#addEmployee input").val('');
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
                </script>

                <button onclick="printSelectedValues()">Print Selected Values</button>

                <script>
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