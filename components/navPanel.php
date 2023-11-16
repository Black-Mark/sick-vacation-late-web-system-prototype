<div class='tab-nav-container custom-scrollbar'>
    <a title="Back" href="<?php echo $location_admin_employeelist; ?>" style="width: 10%; text-align: center;" class="tab-nav-button">
        Back
    </a>
    <a title="Employee Information" href="<?php echo $location_admin_employeelist_user . '/' . $empId . '/'; ?>"
        class="tab-nav-button <?php echo ($_SERVER['SCRIPT_NAME'] === $location_admin_employeelist_user . '/index.php') ? 'active-tab-nav' : ''; ?>">
        Employee Information
    </a>
    <a title="Leave Data Form" href="<?php echo $location_admin_employeelist_leavedataform . '/' . $empId . '/'; ?>"
        class="tab-nav-button <?php echo ($_SERVER['SCRIPT_NAME'] === $location_admin_employeelist_leavedataform . '/index.php') ? 'active-tab-nav' : ''; ?>">
        Leave Data Form
    </a>
</div>