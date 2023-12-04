<?php
// Include database connection and any necessary constants
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);

// Assuming you're using POST to send data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Query to count unread notifications
    $countQuery = "SELECT COUNT(*) as count FROM tbl_notifications WHERE empIdTo = '@Admin' AND seen = 'unread'";
    $countResult = mysqli_query($database, $countQuery);
    $countRow = mysqli_fetch_assoc($countResult);
    $unreadCount = $countRow['count'];
    
    echo $unreadCount;
    // Close the database connection
    mysqli_close($database);
} else {
    // Handle other cases if needed
    echo "Invalid request method";
}
?>
