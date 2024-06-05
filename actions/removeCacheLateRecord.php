<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_authorized);
include ($constants_variables);

if (isset($_POST['clearCacheLateRecord'])) {
    // Define the directory where the CSV files are stored using relative path
    $directory = "../files/upload/laterecords";

    // Fetch all file paths from the fileOfRecord column in the tbl_laterecordfile table
    $query = "SELECT fileOfRecord FROM tbl_laterecordfile";
    $result = mysqli_query($database, $query);

    if ($result) {
        // Store all file paths from the database in an array
        $db_files = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $db_files[] = str_replace('\\', '/', $row['fileOfRecord']);
        }

        // Scan the directory for all CSV files
        $all_files = glob($directory . "/*.csv");

        // Convert all files to relative paths
        foreach ($all_files as $key => $file) {
            $all_files[$key] = str_replace('\\', '/', str_replace(realpath('../'), '', realpath($file)));
        }

        // Debugging output: print the arrays
        echo "Files in database:<br>";
        echo "<pre>" . print_r($db_files, true) . "</pre>";

        echo "Files in directory:<br>";
        echo "<pre>" . print_r($all_files, true) . "</pre>";

        // Loop through all files in the directory
        foreach ($all_files as $file) {
            // Check if the file is not listed in the database
            if (!in_array($file, $db_files)) {
                // // Delete the file
                // if (unlink(realpath($directory . '/' . basename($file)))) {
                //     echo "Deleted: " . $file . "<br>";
                // } else {
                //     echo "Error deleting: " . $file . "<br>";
                // }
            }
        }
    } else {
        echo "Error fetching records from database.";
    }
}
?>
