<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['editEmployee'])) {
    $oldEmployeeID = strip_tags(mysqli_real_escape_string($database, $_POST['oldEmployeeId']));
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
    $departmentlabel = strip_tags(mysqli_real_escape_string($database, $_POST['departmentlabel']));
    $role = strip_tags(mysqli_real_escape_string($database, $_POST['role']));
    $email = strip_tags(mysqli_real_escape_string($database, $_POST['email']));
    $password = strip_tags(mysqli_real_escape_string($database, $_POST['password']));
    $firstName = strip_tags(mysqli_real_escape_string($database, $_POST['firstName']));
    $middleName = strip_tags(mysqli_real_escape_string($database, $_POST['middleName']));
    $lastName = strip_tags(mysqli_real_escape_string($database, $_POST['lastName']));
    $suffix = strip_tags(mysqli_real_escape_string($database, $_POST["suffix"]));
    $birthdate = strip_tags(mysqli_real_escape_string($database, $_POST['birthdate']));
    $sex = strip_tags(mysqli_real_escape_string($database, $_POST['sex']));
    $civilStatus = strip_tags(mysqli_real_escape_string($database, $_POST['civilStatus']));
    $department = strip_tags(mysqli_real_escape_string($database, $_POST['department']));
    $jobPosition = strip_tags(mysqli_real_escape_string($database, $_POST['jobPosition']));
    $dateStarted = strip_tags(mysqli_real_escape_string($database, $_POST['dateStarted']));
    $accountStatus = strip_tags(mysqli_real_escape_string($database, $_POST['status']));

    $accountRole = "";
    $accountRole = getAccountRole($employeeId);
    if (strcasecmp($accountRole, "Admin") == 0) {
        $role = "Admin";
    }

    $query = "UPDATE tbl_useraccounts SET
              employee_id = ?,
              role = ?,
              email = ?,
              password = ?,
              firstName = ?,
              middleName = ?,
              lastName = ?,
              suffix = ?,
              sex = ?,
              civilStatus = ?,
              birthdate = ?,
              department = ?,
              jobPosition = ?,
              dateStarted = ?,
              status = ?
              WHERE employee_id = ?";

    $stmt = mysqli_prepare($database, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $employeeId, $role, $email, $password, $firstName, $middleName, $lastName, $suffix, $sex, $civilStatus, $birthdate, $department, $jobPosition, $dateStarted, $accountStatus, $oldEmployeeID);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_message'] = "Employee with ID $employeeId successfully updated";
            $_SESSION['alert_type'] = $success_color;
        } else {
            $_SESSION['alert_message'] = "Error updating employee with ID $employeeId: " . mysqli_stmt_error($stmt);
            $_SESSION['alert_type'] = $error_color;
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['alert_message'] = "Error preparing update statement: " . mysqli_error($database);
        $_SESSION['alert_type'] = $error_color;
    }

    if ($departmentlabel) {
        header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
    exit();

} else if (isset($_POST['editMultipleEmployee']) && isset($_POST['selectedEmpID'])) {
    try {
        $selectedEmpID = $_POST['selectedEmpID'];
        $departmentlabel = strip_tags(mysqli_real_escape_string($database, $_POST['departmentlabel']));
        // $role = mysqli_real_escape_string($database, strip_tags($_POST['role']));
        // $dateStarted = mysqli_real_escape_string($database, strip_tags($_POST['dateStarted']));
        // $age = mysqli_real_escape_string($database, strip_tags($_POST['age']));
        // $sex = mysqli_real_escape_string($database, strip_tags($_POST['sex']));
        // $civilStatus = mysqli_real_escape_string($database, strip_tags($_POST['civilStatus']));
        // $password = mysqli_real_escape_string($database, strip_tags($_POST['password']));
        // $department = mysqli_real_escape_string($database, strip_tags($_POST['department']));
        // $jobPosition = mysqli_real_escape_string($database, strip_tags($_POST['jobPosition']));

        // Decode the JSON string into an array
        $decodedArray = json_decode($selectedEmpID[0], true);

        $fieldsToUpdate = array('role', 'dateStarted', 'sex', 'civilStatus', 'password', 'department', 'jobPosition', 'status');

        if ($decodedArray !== null) {
            $allUpdated = true; // Flag to track if all employees are updated successfully

            foreach ($decodedArray as $value) {
                $empId = mysqli_real_escape_string($database, strip_tags($value));

                // Check if the corresponding POST field is empty, if not, update the value
                foreach ($fieldsToUpdate as $field) {
                    if (!empty($_POST[$field])) {
                        $sanitizedField = mysqli_real_escape_string($database, strip_tags($_POST[$field]));
                        $query = "UPDATE tbl_useraccounts SET $field = ? WHERE employee_id = ?";
                        $stmt = mysqli_prepare($database, $query);
                        $stmt->bind_param("ss", $sanitizedField, $empId);
                        $result = $stmt->execute();
                        if (!$result) {
                            $allUpdated = false;
                        }
                        $stmt->close();
                    }
                }

                // if (!empty($_POST['role'])) {
                //     $query = "UPDATE tbl_useraccounts SET role = ? WHERE employee_id = ?";
                //     $stmt = mysqli_prepare($database, $query);
                //     $stmt->bind_param("si", $role, $value);
                //     $result = $stmt->execute();
                //     if (!$result) {
                //         $allUpdated = false;
                //     }
                //     $stmt->close();
                // }

                if ($allUpdated) {
                    $_SESSION['alert_message'] = "All Employee Data Updated Successfully";
                    $_SESSION['alert_type'] = $success_color;
                } else {
                    $_SESSION['alert_message'] = "Error updating some employee data";
                    $_SESSION['alert_type'] = $error_color;
                }
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            if ($departmentlabel) {
                header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
            } else {
                header("Location: " . $location_admin_departments_office);
            }
            exit();
        } else {
            $_SESSION['alert_message'] = "Error decoding JSON String";
            $_SESSION['alert_type'] = $error_message;
            header("Location: " . $_SERVER['PHP_SELF']);
            if ($departmentlabel) {
                header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
            } else {
                header("Location: " . $location_admin_departments_office);
            }
            exit();
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
    }

    if ($departmentlabel) {
        header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
    exit();
} else {
    if ($departmentlabel) {
        header("Location: " . $location_admin_departments_office . '/' . $departmentlabel . '/');
    } else {
        header("Location: " . $location_admin_departments_office);
    }
    exit();
}
?>