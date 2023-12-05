<?php
include($constants_file_role_menu);

$selectedMenu = []; // Initialize the selectedMenu as an empty array

if (isset($_SESSION) && isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "Employee") {
        $selectedMenu = $employeeMenu;
    } else if ($_SESSION["role"] == "Admin") {
        $selectedMenu = $adminMenu;
    }
}

if (isset($_REQUEST['logout'])) {
    try {
        if ($_SESSION) {
            $_SESSION['employeeId'] = null;
            $_SESSION['role'] = null;
            $_SESSION['username'] = null;

            unset($_SESSION['employeeId']);
            unset($_SESSION['role']);
            unset($_SESSION['username']);
            session_unset();

            session_destroy();

            header("location: " . $location_login);
        } else {
            header("location: " . $location_login);
        }
    } catch (Exception $e) {
        echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
    }
}

?>

<nav id="top-nav" class="top-nav-container">

    <div class='top-nav-content'>
        <div id="menu-toggle" onclick="toggleMenu()" class='top-nav-menu-button'>
            <i class="fa fa-bars" aria-hidden="true"></i>
        </div>
        <div class="logo-container">
            <img src="<?php echo $assets_logo_png; ?>" alt="Web Page Logo" class="small-web-logo">
        </div>
        <div class="top-nav-head-content">
            <div class="top-nav-title-content top-nav-title">
                <div>Municipality of Indang</div>
                <div class="top-nav-title-content-props">-</div>
                <div>Cavite</div>
            </div>
            <div class="top-nav-title-abbre">HR - Indang</div>
            <div class="top-nav-section">
                <div class="top-nav-section-medium">
                    Human Resources
                </div>
                <div>
                    <?php
                    if ($_SESSION["role"] == 'Admin') {
                        echo "Admin";
                    } else {
                        echo "Employee";
                    }
                    ?>
                    Web Site
                </div>
            </div>
        </div>
    </div>
    <div class="top-nav-content">

        <?php
        if ($_SESSION['role'] == 'Admin') {
            ?>
            <div class="position-relative clickable-element toggle-notification">
                <i class="fa fa-bell text-white"></i>
                <span id="notifCount"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    0
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>

            <div id="notification-container"></div>

            <?php
        }
        ?>

        <div class="top-nav-username">
            <?php
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
            } else {
                echo 'Username';
            }
            ?>
        </div>
        <form method="post">
            <button type="submit" name="logout" class="top-nav-logout-button">
                <i class="fa fa-power-off" aria-hidden="true"></i> <span class="top-nav-logout-text">Logout</span>
            </button>
        </form>
    </div>

</nav>

<div id="sidebar">
    <div id="menu-toggle" class="menu-toggle-class" onclick="toggleMenu()"><i class="fa fa-bars" aria-hidden="true"></i>
    </div>

    <ul class='custom-scrollbar'>
        <?php
        foreach ($selectedMenu as $name => $data) {
            $icon = $data["icon"];
            $link = $data["link"];
            ?>
            <li>
                <a title="<?php echo $name; ?>" href="<?php echo $link; ?>">
                    <i class="<?php echo $icon; ?>" aria-hidden="true"></i>
                    <?php echo $name; ?>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>

</div>

<?php if ($_SESSION['role'] === 'Admin') {
    ?>
    <script>
        $(document).ready(function () {
            function fetchNotifications() {
                // Make an AJAX request to fetch new notifications
                $.ajax({
                    url: 'http://localhost/www.indang-municipal-hr.com.ph/actions/fetchNotification.php', // Create this file to fetch notifications
                    method: 'POST', // Change the method to POST
                    success: function (data) {
                        $('#notification-container').html(data);
                    }
                });
            }

            function fetchNotificationsCount() {
                // Make an AJAX request to fetch new notifications
                $.ajax({
                    url: 'http://localhost/www.indang-municipal-hr.com.ph/actions/fetchNotificationCount.php', // Create this file to fetch notifications
                    method: 'POST', // Change the method to POST
                    success: function (data) {
                        $('#notifCount').html(data);
                    }
                });
            }

            // Function to mark notifications as seen
            function markNotificationsAsSeen() {
                $.ajax({
                    url: 'http://localhost/www.indang-municipal-hr.com.ph/actions/markNotificationsAsSeen.php',
                    method: 'POST',
                    success: function (data) {
                        // You can handle the response if needed
                    }
                });
            }

            // Toggle the 'show' class on the notification container when clicking the bell icon
            $('.clickable-element').click(function (event) {
                $('#notification-container').toggleClass('show');

                // Mark notifications as seen when the bell is clicked
                markNotificationsAsSeen();

                event.stopPropagation(); // Prevent the click event from propagating to the document body
            });

            // Close the notification container when clicking outside of it
            $(document).on('click', function (event) {
                if (!$(event.target).closest('#notification-container, .clickable-element').length) {
                    $('#notification-container').removeClass('show');
                }
            });

            // Fetch notifications every 30 seconds (adjust the interval as needed)
            setInterval(fetchNotifications, 5000);
            setInterval(fetchNotificationsCount, 5000);

            // Initial fetch
            fetchNotifications();
            fetchNotificationsCount();
        });
    </script>
    <?php
}
?>

<script src="<?php echo $assets_script_topnav; ?>"></script>

<?php
include($constants_file_dbconnect);
?>