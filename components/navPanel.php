<div class='tab-nav-container custom-scrollbar'>
    <a title="Back" href="
    <?php
    if (isset($_SESSION['departmentlabel'])) {
        echo $location_admin_departments_office . '/' . $_SESSION['departmentlabel'] . '/';
    } else {
        echo $location_admin_departments_office;
    }
    ?>" style="width: 10%; text-align: center;" class="tab-nav-button">
        Back
    </a>
    <a title="Employee Information" href="<?php echo $location_admin_departments_employee . '/' . $empId . '/'; ?>"
        class="tab-nav-button <?php echo ($_SERVER['SCRIPT_NAME'] === $location_admin_departments_employee . '/index.php') ? 'active-tab-nav' : ''; ?>">
        Employee Information
    </a>
    <a title="Leave Data Form"
        href="<?php echo $location_admin_departments_employee_leavedataform . '/' . $empId . '/'; ?>"
        class="tab-nav-button <?php echo ($_SERVER['SCRIPT_NAME'] === $location_admin_departments_employee_leavedataform . '/index.php') ? 'active-tab-nav' : ''; ?>">
        Leave Data Form
    </a>
</div>