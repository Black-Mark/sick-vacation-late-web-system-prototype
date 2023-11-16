<?php
include("../../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

$departmentLabel = isset($_GET['departmentlabel']) ? filter_var($_GET['departmentlabel'], FILTER_SANITIZE_STRING) : null;

if ($departmentLabel === 'index.php' || $departmentLabel === 'index.html' || $departmentLabel === null) {
    $departmentLabel = null;
} else {
    $sql = "SELECT d.*, u.firstName AS headFirstName, u.lastName AS headLastName
            FROM tbl_departments d
            LEFT JOIN tbl_useraccounts u ON d.departmentHead = u.employee_id
            WHERE d.department_id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("s", $departmentLabel);
    $stmt->execute();

    $departmentData = $stmt->get_result();

    $stmt->close();
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
            <?php

            if ($departmentLabel) {
                if ($departmentData->num_rows > 0) {
                    while ($deptData = $departmentData->fetch_assoc()) {
                        ?>
                        <div>Department ID:
                            <?php echo $deptData["department_id"]; ?>
                        </div>
                        <div>Department Name:
                            <?php echo $deptData["departmentName"]; ?>
                        </div>
                        <div>Department Head:
                            <?php echo $deptData['headFirstName'].' '.$deptData['headLastName'].' ('.$deptData["departmentHead"].')'; ?>
                        </div>
                        <?php
                    }
                } else {
                    echo "No records found for departmentlabel: " . $departmentLabel;
                }
            } else {
                ?>
                Welcome to the Office!
                <?php
            }
            ?>
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