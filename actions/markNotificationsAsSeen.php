<?php
// Include database connection and any necessary constants
include("../constants/routes.php");
include($constants_file_dbconnect);

// Assuming you're using POST to send data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your code to mark the latest 5 notifications as seen
    $updateQuery = "UPDATE tbl_notifications SET seen = 'seen' WHERE empIdTo = '@Admin' AND seen = 'unread' ORDER BY dateCreated DESC LIMIT 5";

    if (mysqli_query($database, $updateQuery)) {
        echo "Latest 5 notifications marked as seen successfully!";
    } else {
        echo "Error updating notifications: " . mysqli_error($database);
    }

    // Close the database connection
    mysqli_close($database);
} else {
    // Handle other cases if needed
    echo "Invalid request method";
}
?>