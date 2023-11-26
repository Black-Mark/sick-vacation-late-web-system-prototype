<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['addEmployee'])) {
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
    $departmentlabel = strip_tags(mysqli_real_escape_string($database, $_POST['departmentlabel']));
    $role = strip_tags(mysqli_real_escape_string($database, $_POST["role"]));
    $email = strip_tags(mysqli_real_escape_string($database, $_POST["email"]));
    $password = strip_tags(mysqli_real_escape_string($database, $_POST['password']));
    $firstName = strip_tags(mysqli_real_escape_string($database, $_POST["firstName"]));
    $middleName = strip_tags(mysqli_real_escape_string($database, $_POST["middleName"]));
    $lastName = strip_tags(mysqli_real_escape_string($database, $_POST["lastName"]));
    $age = strip_tags(mysqli_real_escape_string($database, $_POST["age"]));
    $sex = strip_tags(mysqli_real_escape_string($database, $_POST["sex"]));
    $civilStatus = strip_tags(mysqli_real_escape_string($database, $_POST["civilStatus"]));
    $department = strip_tags(mysqli_real_escape_string($database, $_POST["department"]));
    $jobPosition = strip_tags(mysqli_real_escape_string($database, $_POST["jobPosition"]));
    $dateStarted = strip_tags(mysqli_real_escape_string($database, $_POST["dateStarted"]));

    // if ($departmentlabel) {
    //     $_SESSION['departmentlabel'] = $departmentlabel;
    // }

    try {
        $query = "INSERT INTO tbl_useraccounts 
                  (employee_id, role, email, password, firstName, middleName, lastName, age, sex, civilStatus, department, jobPosition, dateStarted, dateCreated) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        // Prepare the statement
        $stmt = mysqli_prepare($database, $query);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssssisssss", $employeeId, $role, $email, $password, $firstName, $middleName, $lastName, $age, $sex, $civilStatus, $department, $jobPosition, $dateStarted);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "New Employee Successfully Created";
            $_SESSION['alert_type'] = $success_color;
            header("Location: " . $_SERVER['PHP_SELF']);
            if ($departmentlabel) {
                header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
            } else {
                header("Location: " . $location_admin_departments_office);
            }
            exit();
        } else {
            $_SESSION['alert_message'] = "Error updating employee with ID $employeeId: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }
    } catch (Exception $e) {
        $_SESSION['alert_message'] = "An error occurred: " . $e->getMessage();
        $_SESSION['alert_type'] = $error_color;
        header("Location: " . $_SERVER['PHP_SELF']);
        if ($departmentlabel) {
            header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
        } else {
            header("Location: " . $location_admin_departments_office);
        }
        exit();
        // throw new Exception("Database query failed: " . mysqli_error($database));
    }
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    if ($departmentlabel) {
        header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
    exit();
}
?>