<?php
// Include database connection and any necessary constants
include("../constants/routes.php");
include($constants_file_dbconnect);

// Assuming you're using POST to send data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing code to fetch notifications
    $queryFetchNotification = "SELECT * FROM tbl_notifications WHERE empIdTo = '@Admin' AND seen = 'unread' ORDER BY dateCreated DESC LIMIT 5";
    $resultFetchNotification = mysqli_query($database, $queryFetchNotification);

    // Display notifications
    while ($rowNotif = mysqli_fetch_assoc($resultFetchNotification)) {
        echo '<div class="notification">' . $rowNotif['subject'] . '</div>';
    }

    // Close the database connection
    mysqli_close($database);
} else {
    // Handle other cases if needed
    echo "Invalid request method";
}
?>
