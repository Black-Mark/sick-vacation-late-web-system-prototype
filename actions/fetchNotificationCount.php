<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Counts the unread notifications
    $countQuery = "SELECT COUNT(*) as count FROM tbl_notifications WHERE empIdTo = '@Admin' AND seen = 'unread'";
    $countResult = mysqli_query($database, $countQuery);
    $countRow = mysqli_fetch_assoc($countResult);
    $unreadCount = $countRow['count'];
    
    echo $unreadCount;
    mysqli_close($database);
} else {
    echo "Invalid request method";
}
?>
