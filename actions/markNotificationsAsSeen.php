<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mark the latest 5 notifications as seen
    $updateQuery = "UPDATE tbl_notifications SET seen = 'seen' WHERE empIdTo = '@Admin' AND seen = 'unread' ORDER BY dateCreated DESC LIMIT 5";

    if (mysqli_query($database, $updateQuery)) {
        echo "Latest 5 notifications marked as seen successfully!";
    } else {
        echo "Error updating notifications: " . mysqli_error($database);
    }

    mysqli_close($database);
} else {
    echo "Invalid request method";
}
?>