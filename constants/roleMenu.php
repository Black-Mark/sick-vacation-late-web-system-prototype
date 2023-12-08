<?php

$adminMenu = array(
    "Home" => array("icon" => "fa fa-home", "link" => $location_admin),
    "Profile" => array("icon" => "fa fa-user", "link" => $location_admin_profile),
    "Department List" => array("icon" => "fa fa-align-justify", "link" => $location_admin_departments),
    "Leave Transaction" => array("icon" => "fa fa-align-justify", "link" => $location_admin_leaveapplist),
);

$employeeMenu = array(
    "Home" => array("icon" => "fa fa-home", "link" => $location_employee),
    "Profile" => array("icon" => "fa fa-user", "link" => $location_employee_profile),
    "Leave Form" => array("icon" => "fa fa-align-justify", "link" => $location_employee_leave_form),
    "Leave Form Record" => array("icon" => "fa fa-align-justify", "link" => $location_employee_leave_form_record),
    "Leave Data Form" => array("icon" => "fa fa-align-justify", "link" => $location_employee_leave_data_form),
);

?>