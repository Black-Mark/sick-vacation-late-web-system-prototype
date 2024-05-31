<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['retrieveDesignation']) && isset($_POST['designationNum'])) {
    $designationNum = strip_tags(mysqli_real_escape_string($database, $_POST['designationNum']));

    $archiveDesignationQuery = "UPDATE tbl_designations SET archive = '' WHERE designation_id = ?";
    $archiveDesignationStatement = mysqli_prepare($database, $archiveDesignationQuery);

    if ($archiveDesignationStatement) {
        mysqli_stmt_bind_param($archiveDesignationStatement, "s", $designationNum);
        mysqli_stmt_execute($archiveDesignationStatement);
        if (mysqli_stmt_affected_rows($archiveDesignationStatement) > 0) {
            $_SESSION['alert_message'] = "Designation Successfully Restored!";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error Restoring Designation: " . mysqli_stmt_error($archiveDesignationStatement);
            $_SESSION['alert_type'] = $error_color;
        }
        mysqli_stmt_close($archiveDesignationStatement);
    } else {
        $_SESSION['alert_message'] = "Error Restoring Designation!";
        $_SESSION['alert_type'] = $error_color;
    }

    header("Location: " . $location_admin_datamanagement);
    exit();

}else {
    header("Location: " . $location_admin_datamanagement);
    exit();
}

?>