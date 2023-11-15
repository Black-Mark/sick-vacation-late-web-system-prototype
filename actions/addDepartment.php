<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['addDepartment'])) {
    $departmentName = strip_tags(mysqli_real_escape_string($database, $_POST['departmentName']));
    $departmentHead = strip_tags(mysqli_real_escape_string($database, $_POST["departmentHead"]));

    try {
        $query = "INSERT INTO tbl_departments 
                  (departmentName, departmentHead) 
                  VALUES (?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($database, $query);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $departmentName, $departmentHead);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "New Department Successfully Created";
            $_SESSION['alert_type'] = $success_color;
            header("Location: " . $_SERVER['PHP_SELF']);
            header("Location: " . $location_admin_departments);
            exit();
        } else {
            $_SESSION['alert_message'] = "Department Creation Successfully Failed: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }
    } catch (Exception $e) {
        $_SESSION['alert_message'] = "An error occurred: " . $e->getMessage();
        $_SESSION['alert_type'] = $error_color;
        header("Location: " . $_SERVER['PHP_SELF']);
        header("Location: " . $location_admin_departments);
        exit();
        // throw new Exception("Database query failed: " . mysqli_error($database));
    }
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    header("Location: " . $location_admin_departments);
    exit();
}
?>