<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_authorized);
include ($constants_variables);

// Fetch data from the database
$query = "SELECT ua.employee_id, ua.firstName, ua.lastName, ua.middleName FROM tbl_useraccounts LEFT JOIN tbl_leavedataform ldata ON ldata.period WHERE UPPER(ua.archive) != 'DELETED'";
$result = $database->query($query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . $database->error);
}

// Create a temporary file in memory
$csvFile = tmpfile();
$csvPath = stream_get_meta_data($csvFile)['uri'];

// Write the header row
fputcsv($csvFile, ['EmployeeId', 'FullName', 'TotalLate']);

// Write the data rows
while ($row = $result->fetch_assoc()) {
    $employeeId = $row['EmployeeId'];
    $fullName = $row['LastName'] . ' ' . $row['FirstName'] . ' ' . $row['MiddleInitial'];
    $totalLate = ''; // Leaving TotalLate column empty

    // Write the customized row to the CSV file
    fputcsv($csvFile, [$employeeId, $fullName, $totalLate]);
}

// Rewind the file pointer to the beginning
rewind($csvFile);

// Set headers to initiate file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="employees.csv"');

// Output all remaining data on the file pointer
fpassthru($csvFile);

// Close the file and the database connection
fclose($csvFile);
?>
<!--  -->