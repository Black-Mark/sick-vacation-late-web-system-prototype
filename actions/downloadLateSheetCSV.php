<?php
include ("../constants/routes.php");
include ($constants_file_dbconnect);
include ($constants_file_session_authorized);
include ($constants_variables);

$accountRole = "";

if (isset($_SESSION['employeeId'])) {
    $accountRole = strtolower(getAccountRole($_SESSION['employeeId']));
}

// Check if the POST parameter monthYearName is set and not empty
if (isset($_POST['monthYearName']) && !empty($_POST['monthYearName'])) {
    $monthYearName = $_POST['monthYearName'];

    // Fetch data from the database
    $firstDayOfMonth = date('Y-m-01', strtotime($monthYearName));

    $query = "  SELECT ua.employee_id, ua.firstName, ua.lastName, ua.middleName, ua.suffix 
                FROM tbl_useraccounts ua
                LEFT JOIN tbl_leavedataform ldata ON ua.employee_id = ldata.employee_id
                WHERE UPPER(ua.archive) != 'DELETED' 
                AND UPPER(ua.status) != 'INACTIVE'
                AND UPPER(ua.status) != 'BANNED'
                AND UPPER(ua.role) != 'ADMIN'
                AND UPPER(ldata.archive) != 'DELETED'
                AND UPPER(ldata.recordType) = 'INITIAL RECORD' 
                AND (DATE_FORMAT(ldata.periodEnd, '%M %Y') = '$monthYearName' OR ldata.periodEnd <= '$firstDayOfMonth')
                ORDER BY ua.lastName ASC
            ";
    $result = $database->query($query);

    // Check if query was successful
    if (!$result) {
        die("Query failed: " . $database->error);

        if ($accountRole == "admin") {
            header("Location: " . $location_admin_datamanagement_laterecords);
            exit();
        } else if ($accountRole == "staff") {
            header("Location: " . $location_staff_laterecords);
            exit();
        } else {
            header("Location: " . $location_login);
            exit();
        }
    }

    // Create a temporary file in memory
    $csvFile = tmpfile();
    $csvPath = stream_get_meta_data($csvFile)['uri'];

    // Write the header row
    fputcsv($csvFile, [trim('EmployeeId'), 'FullName', 'TotalLate']);

    // Write the data rows
    while ($row = $result->fetch_assoc()) {
        $employeeId = $row['employee_id'];
        $fullName = organizeFullName($row['firstName'], $row['middleName'], $row['lastName'], $row['suffix'], 2);
        $totalLate = ''; // Leaving TotalLate column empty

        // Write the customized row to the CSV file
        fputcsv($csvFile, [$employeeId, $fullName, $totalLate]);
    }

    // Rewind the file pointer to the beginning
    rewind($csvFile);

    // Set headers to initiate file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $monthYearName . ' - Employee Late Record Sheet.csv"');

    // Output all remaining data on the file pointer
    fpassthru($csvFile);

    // Close the file and the database connection
    fclose($csvFile);
    $database->close();
    exit();
} else {
    $_SESSION['alert_message'] = "Month and Year Name are not provided!";
    $_SESSION['alert_type'] = $warning_color;

    // Redirect based on account role
    if ($accountRole == "admin") {
        header("Location: " . $location_admin_datamanagement_laterecords);
        exit();
    } else if ($accountRole == "staff") {
        header("Location: " . $location_staff_laterecords);
        exit();
    } else {
        header("Location: " . $location_login);
        exit();
    }
}
?>