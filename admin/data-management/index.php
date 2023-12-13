<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

$settingData = [];
$settingQuery = "SELECT * FROM tbl_systemsettings
                 LEFT JOIN tbl_useraccounts ON tbl_useraccounts.employee_id = tbl_systemsettings.settingKey";
$settingResult = mysqli_query($database, $settingQuery);

if ($settingResult) {
    $settingData = mysqli_fetch_all($settingResult, MYSQLI_ASSOC);
    mysqli_free_result($settingResult);
}

// print_r($settingData);

$employees = [];

$sql_employee = "SELECT firstName, lastName, employee_id FROM tbl_useraccounts";
$employees_result = $database->query($sql_employee);

if ($employees_result) {
    $employees = mysqli_fetch_all($employees_result, MYSQLI_ASSOC);
    mysqli_free_result($employees_result);
}

// print_r($employees);

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

                <div class="p-2">
                    <h3 class="title-text">
                        Data Management
                    </h3>

                    <h5 class="mt-4 mb-2 text-uppercase font-weight-bold">Authorized Person:</h5>

                    <form action="<?php echo $action_update_system_setting; ?>" method="post" class="d-flex flex-row gap-2 align-items-center mb-2">
                        <div class="w-25 font-weight-bold text-truncate">Human Resources Manager:</div>
                        <?php
                        for ($i = 0; $i < count($settingData); $i++) {
                            if ($settingData[$i]['settingType'] == "Authorized User" && $settingData[$i]['settingSubject'] == "Human Resources Manager") {
                                ?>
                                <div class="w-25 text-truncate">
                                    <?php
                                    echo $settingData[$i]['lastName'] . ' ' . $settingData[$i]['firstName'];
                                    echo $settingData[$i]['middleName'] ? ' ' . substr($settingData[$i]['middleName'], 0, 1) . '.' : $settingData[$i]['middleName'];
                                    echo $settingData[$i]['suffix'] ? ' ' . $settingData[$i]['suffix'] : '';
                                    ?>
                                </div>
                                <input type="hidden" name="settingIdentifier"
                                    value="<?php echo $settingData[$i]['setting_id']; ?>" />
                                <select name="selectedAuthorizedUser" class="w-25 text-center form-select text-truncate">
                                    <option value="" selected>---Auto---</option>
                                    <?php
                                    if (!empty($employees)) {
                                        foreach ($employees as $employee) {
                                            ?>
                                            <option value="<?php echo $employee['employee_id']; ?>">
                                                <?php echo $employee['lastName'] . ' ' . $employee['firstName']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="submit" name="changeSetting" class="w-25 custom-regular-button text-truncate" value="Change" />
                                <?php
                            }
                        }
                        ?>
                    </form>

                    <form action="<?php echo $action_update_system_setting; ?>" method="post" class="d-flex flex-row gap-2 align-items-center">
                        <div class="w-25 font-weight-bold text-truncate">Municipal Mayor:</div>
                        <?php
                        for ($i = 0; $i < count($settingData); $i++) {
                            if ($settingData[$i]['settingType'] == "Authorized User" && $settingData[$i]['settingSubject'] == "Municipal Mayor") {
                                ?>
                                <div class="w-25 text-truncate">
                                    <?php
                                    echo $settingData[$i]['lastName'] . ' ' . $settingData[$i]['firstName'];
                                    echo $settingData[$i]['middleName'] ? ' ' . substr($settingData[$i]['middleName'], 0, 1) . '.' : $settingData[$i]['middleName'];
                                    echo $settingData[$i]['suffix'] ? ' ' . $settingData[$i]['suffix'] : '';
                                    ?>
                                </div>
                                <input type="hidden" name="settingIdentifier"
                                    value="<?php echo $settingData[$i]['setting_id']; ?>" />
                                <select name="selectedAuthorizedUser" class="w-25 text-center form-select text-truncate">
                                    <option value="" selected>---Auto---</option>
                                    <?php
                                    if (!empty($employees)) {
                                        foreach ($employees as $employee) {
                                            ?>
                                            <option value="<?php echo $employee['employee_id']; ?>">
                                                <?php echo $employee['lastName'] . ' ' . $employee['firstName']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="submit" name="changeSetting" class="w-25 custom-regular-button text-truncate" value="Change" />
                                <?php
                            }
                        }
                        ?>
                    </form>

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