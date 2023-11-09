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

            header("location: ".$location_login);
        } else {
            header("location: ".$location_login);
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
                if($_SESSION["role"] == 'Admin'){
                    echo "Admin";
                }else{
                    echo "Employee";
                }
                ?>
                Web Site
                </div>
            </div>
        </div>
    </div>
    <div class="top-nav-content">
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

<script src="<?php echo $assets_script_topnav; ?>"></script>

<?php
include($constants_file_dbconnect);
?>