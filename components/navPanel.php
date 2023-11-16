<div class='tab-nav-container custom-scrollbar'>
    <a href="<?php echo $location_admin_employeelist_user . '/' . $empId . '/'; ?>"
        class="tab-nav-button <?php echo ($_SERVER['SCRIPT_NAME'] === $location_admin_employeelist_user . '/index.php') ? 'active-tab-nav' : ''; ?>">
        Employee Information
    </a>
    <a href="<?php echo $location_admin_employeelist_leavedataform . '/' . $empId . '/'; ?>"
        class="tab-nav-button <?php echo ($_SERVER['SCRIPT_NAME'] === $location_admin_employeelist_leavedataform . '/index.php') ? 'active-tab-nav' : ''; ?>">
        Leave Data Form
    </a>
</div>