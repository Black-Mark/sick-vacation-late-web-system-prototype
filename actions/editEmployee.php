<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['editEmployee'])) {
    // Retrieve data from the form
    $oldEmployeeID = strip_tags(mysqli_real_escape_string($database, $_POST['oldEmployeeId']));
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
    $role = strip_tags(mysqli_real_escape_string($database, $_POST['role']));
    $email = strip_tags(mysqli_real_escape_string($database, $_POST['email']));
    $password = strip_tags(mysqli_real_escape_string($database, $_POST['password']));
    $firstName = strip_tags(mysqli_real_escape_string($database, $_POST['firstName']));
    $middleName = strip_tags(mysqli_real_escape_string($database, $_POST['middleName']));
    $lastName = strip_tags(mysqli_real_escape_string($database, $_POST['lastName']));
    $age = strip_tags(mysqli_real_escape_string($database, $_POST['age']));
    $sex = strip_tags(mysqli_real_escape_string($database, $_POST['sex']));
    $civilStatus = strip_tags(mysqli_real_escape_string($database, $_POST['civilStatus']));
    $department = strip_tags(mysqli_real_escape_string($database, $_POST['department']));
    $jobPosition = strip_tags(mysqli_real_escape_string($database, $_POST['jobPosition']));
    $dateStarted = strip_tags(mysqli_real_escape_string($database, $_POST['dateStarted']));

    // Use prepared statement to prevent SQL injection
    $query = "UPDATE tbl_useraccounts SET
              employee_id = ?,
              role = ?,
              email = ?,
              password = ?,
              firstName = ?,
              middleName = ?,
              lastName = ?,
              age = ?,
              sex = ?,
              civilStatus = ?,
              department = ?,
              jobPosition = ?,
              dateStarted = ?
              WHERE employee_id = ?";

    $stmt = mysqli_prepare($database, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssissssss", $employeeId, $role, $email, $password, $firstName, $middleName, $lastName, $age, $sex, $civilStatus, $department, $jobPosition, $dateStarted, $oldEmployeeID);

        if (mysqli_stmt_execute($stmt)) {
            // Update successful
            $_SESSION['alert_message'] = "Employee with ID $employeeId successfully updated";
            $_SESSION['alert_type'] = $success_color;
        } else {
            // Capture error message for later display
            $_SESSION['alert_message'] = "Error updating employee with ID $employeeId: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }

        mysqli_stmt_close($stmt);
    } else {
        // Capture error message for later display
        $_SESSION['alert_message'] = "Error preparing update statement: " . mysqli_error($database);
        $_SESSION['alert_type'] = $error_color;
    }

    // Redirect to the employee list page after update
    header("Location: " . $location_admin_employeelist);
    exit();
} else {
    // Redirect to the employee list page if no update request
    header("Location: " . $location_admin_employeelist);
    exit();
}
?>