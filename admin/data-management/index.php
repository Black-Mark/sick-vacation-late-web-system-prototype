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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- <script src="../assets/js/tailwind.js"></script> -->
</head>

<body class="webpage-background-cover-admin">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class='data-manage-nav-container custom-scrollbar'>
                <a href="#"><button class="data-manage-nav-button">Manage Data</button></a>
            </div>

            <div class="box-container">
                <h3 class="title-text">List of Teachers</h3>

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