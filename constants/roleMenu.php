<?php

$adminMenu = array(
    "Home" => array("icon" => "fa fa-home", "link" => $location_admin),
    "Profile" => array("icon" => "fa fa-user", "link" => $location_admin_profile),
    "Department List" => array("icon" => "fa fa-folder-open", "link" => $location_admin_departments),
    "Leave Transaction" => array("icon" => "fa fa-envelope", "link" => $location_admin_leaveapplist),
    "Data Management" => array("icon" => "fa fa-database", "link" => $location_admin_datamanagement),
);

$employeeMenu = array(
    "Home" => array("icon" => "fa fa-home", "link" => $location_employee),
    "Profile" => array("icon" => "fa fa-user", "link" => $location_employee_profile),
    "Leave App Form" => array("icon" => "fa fa-file-text", "link" => $location_employee_leave_form),
    "Leave App Record" => array("icon" => "fa fa-history", "link" => $location_employee_leave_form_record),
    "Leave Data Form" => array("icon" => "fa fa-list-ul", "link" => $location_employee_leave_data_form),
);

?>