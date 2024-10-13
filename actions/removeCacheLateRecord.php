<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['clearCacheLateRecord'])) {
    // Define the directory where the CSV files are stored using a relative path from htdocs
    $directory = realpath(dirname(__FILE__) . "/../files/upload/laterecords");

    $query = "SELECT fileOfRecord FROM tbl_laterecordfile";
    $result = mysqli_query($database, $query);

    if ($result) {
        // Store all file paths from the database in an array and convert to absolute paths
        $db_files = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if (!empty($row['fileOfRecord'])) {
                // Convert to absolute path and use forward slashes
                $db_files[] = str_replace('\\', '/', realpath(dirname(__FILE__) . "/../" . $row['fileOfRecord']));
            }
        }

        // Scan the directory for all .CSV files
        $all_files = glob($directory . "/*.csv");

        // Convert directory paths to use forward slashes
        foreach ($all_files as $key => $file) {
            $all_files[$key] = str_replace('\\', '/', $file);
        }

        // Debugging output: print the arrays
        // echo "Files in database:<br>";
        // echo "<pre>" . print_r($db_files, true) . "</pre>";

        // echo "Files in directory:<br>";
        // echo "<pre>" . print_r($all_files, true) . "</pre>";

        foreach ($all_files as $file) {
            echo "Checking file: " . $file . "<br>";

            if (!in_array($file, $db_files)) {
                echo "Will delete: " . $file . "<br>";

                // Delete the file
                if (unlink($file)) {
                    echo "Deleted: " . $file . "<br>";
                } else {
                    echo "Error deleting: " . $file . "<br>";
                }
            } else {
                echo "Will not delete: " . $file . "<br>";
            }
        }
        $_SESSION['alert_message'] = "Clearing Cache Files Success!";
        $_SESSION['alert_type'] = $success_color;
    } else {
        $_SESSION['alert_message'] = "Clearing of Unwanted Files Failed!";
        $_SESSION['alert_type'] = $error_color;
    }
}

header("Location: " . $location_admin_datamanagement_laterecords);
exit();
?>