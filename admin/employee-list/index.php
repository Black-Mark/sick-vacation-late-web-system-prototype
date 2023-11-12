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
            <div class="text-experiment">This is Employee List</div>

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

    <!-- <div>
        <?php
        // include($components_file_footer)
        ?>
    </div> -->
</body>

</html>