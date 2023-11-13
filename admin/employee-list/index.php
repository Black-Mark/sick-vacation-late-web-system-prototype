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

                <!-- Button trigger modal -->
                <div class="mb-1">
                    <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#addEmployee">
                        Add Employee
                    </button>
                </div>

                <!-- Modal -->
                <form class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addEmployeeModalLongTitle">Create New Employee</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingEmployeeID"
                                        placeholder="TEMP0001" required>
                                    <label for="floatingEmployeeID">Employee ID</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword"
                                        placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="employees" class="hover table-striped cell-border order-column" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
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
                                        <?php echo $row['employee_id']; ?>
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
                        'select': {
                            'style': 'multi'
                        },
                        // ordering: false,
                        columnDefs: [
                            {
                                'targets': 0,
                                'orderable': false,
                                'checkboxes': {
                                    'selectRow': true
                                }
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
                                columns: ':first,:gt(1),:last'
                            }
                        ],
                        responsive: true,
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- <div>
        <?php
        // include($components_file_footer)
        ?>
    </div> -->
</body>

</html>