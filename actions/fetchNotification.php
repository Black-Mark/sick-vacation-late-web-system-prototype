<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
// include($constants_file_session_admin);
include($constants_variables);

@ob_start();
@session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userData = [];
    $empId = null;
    if (isset($_SESSION['employeeId'])) {
        $empId = sanitizeInput($_SESSION['employeeId']);
        $userData = getEmployeeData($empId);

        if (!empty($userData)) {
            if (strcasecmp($userData['role'], "Admin") == 0) {
                // Your existing code to fetch unread notifications
                $queryUnreadNotifications = "SELECT * FROM tbl_notifications WHERE empIdTo = '@Admin' AND status = 'unseen' ORDER BY dateCreated DESC LIMIT 5";
                $resultUnreadNotifications = mysqli_query($database, $queryUnreadNotifications);

                // Fetch up to 5 unread notifications
                $unreadNotifications = [];
                while ($rowUnseen = mysqli_fetch_assoc($resultUnreadNotifications)) {
                    $unreadNotifications[] = $rowUnseen;
                }

                // If the count of unread notifications is less than 5, fetch additional seen notifications
                $remainingLimit = 5 - count($unreadNotifications);
                if ($remainingLimit > 0) {
                    $querySeenNotifications = "SELECT * FROM tbl_notifications WHERE empIdTo = '@Admin' ORDER BY dateCreated DESC LIMIT $remainingLimit";
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
                    $classStatusType = "";
                    foreach ($unreadNotifications as $notification) {
                        if ($notification['status'] == 'unseen') {
                            $classStatusType = "notif-unseen";
                        } else if ($notification['status'] == 'unread') {
                            $classStatusType = "notif-unread";
                        }

                        echo '<a href="' . $location_admin_leaveapplist_view . '/' . $notification['subjectKey'] . '/' . '"><div class="notification text-center ' . $classStatusType . '">
                            <div class="notification-subject-text font-weight-bold">'
                            . $notification['subject'] . '</div><div class="notification-message-text">' . $notification['message'] .
                            '</div>
                            </div></a>';
                    }
                } else {
                    // Display a message when no notifications are found
                    echo '<div class="notification text-center font-italic">There are no recent notification.</div>';
                }
                echo '</div><div class="notification-footer bg-primary text-white"><a href="' . $location_admin_leaveapplist . '">See all Leave Application Form</a></div>';

                mysqli_close($database);
            } else if (strcasecmp($userData['role'], "Employee") == 0) {
                // Your existing code to fetch unread notifications
                $queryUnreadNotifications = "SELECT * FROM tbl_notifications WHERE empIdTo = '$empId' AND status = 'unseen' ORDER BY dateCreated DESC LIMIT 5";
                $resultUnreadNotifications = mysqli_query($database, $queryUnreadNotifications);

                // Fetch up to 5 unread notifications
                $unreadNotifications = [];
                while ($rowUnseen = mysqli_fetch_assoc($resultUnreadNotifications)) {
                    $unreadNotifications[] = $rowUnseen;
                }

                // If the count of unread notifications is less than 5, fetch additional seen notifications
                $remainingLimit = 5 - count($unreadNotifications);
                if ($remainingLimit > 0) {
                    $querySeenNotifications = "SELECT * FROM tbl_notifications WHERE empIdTo = '$empId' ORDER BY dateCreated DESC LIMIT $remainingLimit";
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
                    $classStatusType = "";
                    foreach ($unreadNotifications as $notification) {
                        if ($notification['status'] == 'unseen') {
                            $classStatusType = "notif-unseen";
                        } else if ($notification['status'] == 'unread') {
                            $classStatusType = "notif-unread";
                        }

                        echo '<a href="' . $location_employee_leave_form_record_view . '/' . $notification['subjectKey'] . '/' . '"><div class="notification text-center ' . $classStatusType . '">
                            <div class="notification-subject-text font-weight-bold">'
                            . $notification['subject'] . '</div><div class="notification-message-text">' . $notification['message'] .
                            '</div>
                            </div></a>';
                    }
                } else {
                    // Display a message when no notifications are found
                    echo '<div class="notification text-center font-italic">There are no recent notification.</div>';
                }
                echo '</div><div class="notification-footer bg-primary text-white"><a href="' . $location_employee_leave_form_record . '">See all Leave Application Form</a></div>';

                mysqli_close($database);
            }
        }
    }
} else {
    echo "Invalid request method";
}
?>