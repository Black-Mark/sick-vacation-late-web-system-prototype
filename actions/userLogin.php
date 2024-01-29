<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
// include($constants_file_session_login);
include($constants_variables);

@ob_start();
session_start();

if (isset($_REQUEST['login'])) {
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
    $password = strip_tags(mysqli_real_escape_string($database, $_POST['password']));

    if (!empty($employeeId) && !empty($password)) {
        try {
            $query = "SELECT * FROM tbl_useraccounts WHERE employee_id='$employeeId' AND BINARY password='$password' AND UPPER(archive) != 'DELETED'";

            $result = mysqli_query($database, $query);
            if ($result === false) {
                throw new Exception("Database query failed: " . mysqli_error($database));
            }

            $count = mysqli_num_rows($result);

            if ($count > 0) {
                $user_data = mysqli_fetch_assoc($result);

                session_regenerate_id();
                $_SESSION['employeeId'] = $employeeId;
                $_SESSION['role'] = $user_data['role'];

                if ($_SESSION['role'] == 'Admin') {
                    $_SESSION['alert_message'] = "Logged In Successful!";
                    $_SESSION['alert_type'] = $success_color;
                    $_SESSION['alert_pass'] = 'Logged In';
                    header("Location: " . $location_admin);
                } elseif ($_SESSION['role'] == 'Employee') {
                    $_SESSION['alert_message'] = "Logged In Successful!";
                    $_SESSION['alert_type'] = $success_color;
                    $_SESSION['alert_pass'] = 'Logged In';
                    header("Location: " . $location_employee);
                } else {
                    session_destroy();
                    $_SESSION['alert_message'] = "Logged In Failed!";
                    $_SESSION['alert_type'] = $error_color;
                }
            } else {
                $_SESSION['alert_message'] = "Incorrect username or password. Please try again!";
                $_SESSION['alert_type'] = $warning_color;
            }
        } catch (Exception $e) {
            $error_message = "An error occurred: " . $e->getMessage();
            $_SESSION['alert_message'] = $error_message;
            $_SESSION['alert_type'] = $error_color;
        } finally {
            header("Location: " . $location_login);
            exit();
        }
    } else {
        $_SESSION['alert_message'] = "Please fill in both Employee ID and Password fields.";
        $_SESSION['alert_type'] = $warning_color;
    }

    header("Location: " . $location_login);
    exit();
} else {
    header("Location: " . $location_login);
    exit();
}

?>