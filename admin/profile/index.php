<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

$employeeData = [];

if (isset($_SESSION['employeeId'])) {
    $employeeId = $database->real_escape_string($_SESSION['employeeId']);

    $sql = "SELECT
                ua.*,
                d.departmentName
            FROM
                tbl_useraccounts ua
            LEFT JOIN
                tbl_departments d ON ua.department = d.department_id
            WHERE
                ua.employee_id = ?";

    $stmt = $database->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $employeeId);
        $stmt->execute();
        $empResult = $stmt->get_result();

        if ($empResult->num_rows > 0) {
            $employeeData = $empResult->fetch_assoc();
        }

    } else {
        // Something
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
    <div class="component-container">
        <?php include($components_file_topnav); ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div class="box-container">
                <h3 class="title-text">Account Profile Information</h3>

                <form action="" method="post" class="account-profile-container print-form-container">
                    <div class="profile-rowing">
                        <label for="employeeIdInput">Employee ID:</label>
                        <span id="employeeIdInput">
                            <?php echo $employeeData['employee_id']; ?>
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="roleInput">Role:</label>
                        <span id="roleInput">
                            <?php echo $employeeData['role']; ?>
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="emailInput">Email:</label>
                        <span>
                            <input type="email" id="emailInput" name="email" class="account-profile-input"
                                value="<?php echo $employeeData['email']; ?>" readonly required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="passwordInput">Password:</label>
                        <span>
                            <input type="password" id="passwordInput" name="password" class="account-profile-input"
                                value="<?php echo $employeeData['password']; ?>" readonly required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="photoURLInput">PhotoURL:</label>
                        <span>
                            <input type="text" id="photoURLInput" name="photoURL" class="account-profile-input"
                                value="<?php echo $employeeData['photoURL']; ?>" readonly required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="firstNameInput">First Name:</label>
                        <span>
                            <input type="text" id="firstNameInput" name="firstName" class="account-profile-input"
                                value="<?php echo $employeeData['firstName']; ?>" readonly required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="middleNameInput">Middle Name:</label>
                        <span>
                            <input type="text" id="middleNameInput" name="middleName" class="account-profile-input"
                                value="<?php echo $employeeData['middleName']; ?>" readonly required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="lastNameInput">Last Name:</label>
                        <span>
                            <input type="text" id="lastNameInput" name="lastName" class="account-profile-input"
                                value="<?php echo $employeeData['lastName']; ?>" readonly required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="ageInput">Age:</label>
                        <span>
                            <input type="number" min="0" max="130" id="ageInput" name="age"
                                class="account-profile-input" value="<?php echo $employeeData['age']; ?>" readonly
                                required />
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="sexInput">Sex:</label>
                        <span>
                            <select id="sexInput" name="sex" class="account-profile-input" disabled required>
                                <option value="" <?php
                                if (strcasecmp($employeeData['sex'], '') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                </option>
                                <option value="Male" <?php
                                if (strcasecmp($employeeData['sex'], 'Male') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Male
                                </option>
                                <option value="Female" <?php
                                if (strcasecmp($employeeData['sex'], 'Female') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Female
                                </option>
                                <option value="Prefer Not To Say" <?php
                                if (strcasecmp($employeeData['sex'], 'Prefer Not To Say') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Prefer Not To Say
                                </option>
                            </select>
                        </span>
                    </div>


                    <div class="profile-rowing">
                        <label for="civilStatusInput">Civil Status:</label>
                        <span>
                            <select id="civilStatusInput" name="civilStatus" class="account-profile-input" disabled
                                required>
                                <option value="Single" <?php
                                if (strcasecmp($employeeData['civilStatus'], 'Single') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Single
                                </option>
                                <option value="Married" <?php
                                if (strcasecmp($employeeData['civilStatus'], 'Married') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Married
                                </option>
                                <option value="Widowed" <?php
                                if (strcasecmp($employeeData['civilStatus'], 'Widowed') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Widowed
                                </option>
                                <option value="Divorced" <?php
                                if (strcasecmp($employeeData['civilStatus'], 'Divorced') == 0) {
                                    echo "selected";
                                }
                                ?>>
                                    Divorced
                                </option>
                            </select>
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="departmentInput">Department:</label>
                        <span>
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

                    <div class="profile-rowing">
                        <label for="jobPosition">Job Position:</label>
                        <span>
                            <?php echo $employeeData['jobPosition']; ?>
                        </span>
                    </div>

                    <div class="profile-rowing">
                        <label for="dateStarted">Date Started:</label>
                        <span>
                            <?php echo $employeeData['dateStarted']; ?>
                        </span>
                    </div>

                </form>
                
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