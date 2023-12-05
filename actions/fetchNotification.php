<?php
// Include database connection and any necessary constants
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);

// Assuming you're using POST to send data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing code to fetch unread notifications
    $queryUnreadNotifications = "SELECT * FROM tbl_notifications WHERE empIdTo = '@Admin' AND seen = 'unread' ORDER BY dateCreated DESC LIMIT 5";
    $resultUnreadNotifications = mysqli_query($database, $queryUnreadNotifications);

    // Fetch up to 5 unread notifications
    $unreadNotifications = [];
    while ($rowUnread = mysqli_fetch_assoc($resultUnreadNotifications)) {
        $unreadNotifications[] = $rowUnread;
    }

    // If the count of unread notifications is less than 5, fetch additional seen notifications
    $remainingLimit = 5 - count($unreadNotifications);
    if ($remainingLimit > 0) {
        $querySeenNotifications = "SELECT * FROM tbl_notifications WHERE empIdTo = '@Admin' AND seen = 'seen' ORDER BY dateCreated DESC LIMIT $remainingLimit";
        $resultSeenNotifications = mysqli_query($database, $querySeenNotifications);

        // Fetch remaining seen notifications
        while ($rowSeen = mysqli_fetch_assoc($resultSeenNotifications)) {
            $unreadNotifications[] = $rowSeen;
        }
    }

    echo '<div class="notification-header bg-primary text-white">Notifications</div><div class="overflow-auto custom-scrollbar">';

    // Check if any notifications were fetched
    if (!empty($unreadNotifications)) {
        // Display notifications
        foreach ($unreadNotifications as $notification) {
            echo '<div class="notification text-center"><div class="notification-subject-text font-weight-bold">' . $notification['subject'] . '</div><div class="notification-message-text">' . $notification['message'] . '</div></div>';
        }
    } else {
        // Display a message when no notifications are found
        echo '<div class="notification text-center font-italic">There are no recent notification.</div>';
    }
    echo '</div><div class="notification-footer bg-primary text-white"><a href="' . $location_admin_leaveapplist . '">See all Leave Application Form</a></div>';

    // Close the database connection
    mysqli_close($database);
} else {
    // Handle other cases if needed
    echo "Invalid request method";
}
?>