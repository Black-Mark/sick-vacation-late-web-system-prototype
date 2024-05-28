<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$employeeData = [];

if (isset($_SESSION['employeeId'])) {
    $employeeId = sanitizeInput($_SESSION['employeeId']);
    $employeeData = getEmployeeData($employeeId);   
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
    <div class="component-container">
        <?php include($components_file_topnav); ?>
    </div>

    <!-- Change Password -->
    <form action="<?php echo $action_update_password; ?>" method="post" class="modal fade"
        id="changeUserProfilePassword" tabindex="-1" role="dialog" aria-labelledby="changeUserProfilePasswordTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeUserProfilePasswordModalLongTitle">Change User Password
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-floating mb-2">
                        <input type="password" name="currentPassword" class="form-control" id="floatingCurrentPassword"
                            placeholder="Password" required>
                        <label for="floatingCurrentPassword">Current Password: <span
                                class="required-color">*</span></label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password" name="newPassword" class="form-control" id="floatingNewPassword"
                            placeholder="New Password" required>
                        <label for="floatingNewPassword">New Password: <span class="required-color">*</span></label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password" name="confirmPassword" class="form-control" id="floatingConfirmPassword"
                            placeholder="Confirm Password" required>
                        <label for="floatingConfirmPassword">Confirm Password: <span
                                class="required-color">*</span></label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="changeUserProfilePassword" value="Submit" class="btn btn-primary" />
                </div>
            </div>
        </div>
    </form>

    <div class="page-container">
        <div class="page-content">

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
                        <span class="account-profile-subject">Role:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['role']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center">
                        <span class="account-profile-subject">Email:</span>
                        <span class="account-profile-context">
                            <?php echo $employeeData['email']; ?>
                        </span>
                    </div>

                    <div class="d-flex flex-row gap-1 align-items-center text-primary">
                        <i class="fa fa-lock"></i>
                        <span class="pl-2 clickable-element text-primary" data-toggle="modal"
                            data-target="#changeUserProfilePassword">Change Password</span>
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

            </div>

        </div>
    </div>

    <div class="component-container">
        <?php
        include($components_file_footer);
        ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>