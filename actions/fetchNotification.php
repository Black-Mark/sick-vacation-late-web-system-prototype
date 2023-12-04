<?php
// Include database connection and any necessary constants
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);

// Assuming you're using POST to send data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing code to fetch notifications
    $queryFetchNotification = "SELECT * FROM tbl_notifications WHERE empIdTo = '@Admin' AND seen = 'unread' ORDER BY dateCreated DESC LIMIT 5";
    $resultFetchNotification = mysqli_query($database, $queryFetchNotification);

    // Display notifications
    echo '<div class="notification-header bg-primary text-white">Notifications</div><div class="overflow-auto custom-scrollbar">';
    while ($rowNotif = mysqli_fetch_assoc($resultFetchNotification)) {
        echo '<div class="notification text-center"><div class="notification-subject-text font-weight-bold">'.$rowNotif['subject'].'</div><div class="notification-message-text">' . $rowNotif['message'] . '</div></div>';
    }
    echo '</div><div class="notification-footer bg-primary text-white"><a href="'.$location_admin_leaveapplist.'">See all Leave Application Form</a></div>';

    // Close the database connection
    mysqli_close($database);
} else {
    // Handle other cases if needed
    echo "Invalid request method";
}
?>
