<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

$tablelist = isset($_GET['tablelist']) ? filter_var($_GET['tablelist'], FILTER_SANITIZE_STRING) : null;

if ($tablelist === 'index.php' || $tablelist === 'index.html') {
    $tablelist = null;
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
    <link rel="stylesheet" href="<?php echo $assets_css_styles; ?>">

    <!-- <script src="../assets/js/tailwind.js"></script> -->

    <link rel="stylesheet" href="../../assets/datatables/datatables.min.css">
    <link rel="stylesheet" href="../../assets/datatables/DataTables-1.13.6/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/datatables/Buttons-2.4.2/css/buttons.bootstrap.min.css">
</head>

<body class="webpage-background-cover-admin">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class='data-manage-nav-container custom-scrollbar'>
                <a href="<?php echo $location_admin_datamanagement; ?>/gender/"><button
                        class="data-manage-nav-button">Gender</button></a>
            </div>

            <div class="box-container">
                <h3 class="title-text">List of
                    <?php echo $tablelist; ?> Options
                </h3>

                <!-- Button trigger modal -->
                <div>
                    <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#addEmployee">
                        Add Employee
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Employee</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="example" class="display" style="width:100%">
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
                    $(document).ready(function () {
                        $('#example').DataTable({
                            "pagingType": "full_numbers",  // Show First, Previous, Page numbers, Next, Last
                            "pageLength": 10,             // Number of rows per page
                            "ordering": true,             // Allow column sorting
                            "searching": true,            // Enable search
                            "lengthChange": true,        // Show entries per page
                            "dom": 'lBfrtip',            // Show Buttons for Print, Copy, Excel, CSV, PDF
                            "buttons": [
                                'copy', 'excel', 'csv', 'pdf', 'print'
                            ]
                        });
                    });
                </script>



                <script src="../../assets/datatables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
                <script src="../../assets/datatables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
                <script src="../../assets/datatables/Buttons-2.4.2/js/buttons.print.min.js"></script>

                <script src="../../assets/datatables/JSZip-3.10.1/jszip.min.js"></script>
                <script src="../../assets/datatables/pdfmake-0.2.7/pdfmake.js"></script>
                <script src="../../assets/datatables/pdfmake-0.2.7/pdfmake.min.js"></script>
                <script src="../../assets/datatables/pdfmake-0.2.7/vfs_fonts.js"></script>
                <script src="../../assets/datatables/datatables.min.js"></script>

                

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