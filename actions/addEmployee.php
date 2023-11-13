<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

if (isset($_POST['addEmployee'])) {
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
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

    try {
        // Insert data into the database (Assuming you have a table named 'your_table_name')
        $query = "INSERT INTO tbl_useraccounts (employee_id, role, email, password, firstName, middleName, lastName, age, sex, civilStatus, department, jobPosition, dateStarted, dateCreated) 
    VALUES ('$employeeId', '$role', '$email', '$password', '$firstName', '$middleName', '$lastName', '$age', '$sex', '$civilStatus', '$department', '$jobPosition', '$dateStarted', NOW())";

        // Execute the query
        $result = mysqli_query($database, $query);
        if ($result === false) {
            $_SESSION['alert_message'] = "An error occurred: " . mysqli_error($database);
            header("Location: " . $_SERVER['PHP_SELF']);
            header("Location: " . $location_admin_employeelist);
            exit();

            // throw new Exception("Database query failed: " . mysqli_error($database));
        }else{
            $_SESSION['alert_message'] = "New Employee Successfully Created";
        }
    } catch (Exception $e) {
        $_SESSION['alert_message'] = "An error occurred: " . $e->getMessage();

        // echo '<script type="text/javascript">window.history.back();</script>';
        // exit();

        header("Location: " . $_SERVER['PHP_SELF']);
        header("Location: " . $location_admin_employeelist);
        exit();

        // throw new Exception("Database query failed: " . mysqli_error($database));
    }
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    header("Location: " . $location_admin_employeelist);
}
?>