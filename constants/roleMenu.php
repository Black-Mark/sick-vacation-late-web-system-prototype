<?php

$adminMenu = array(
    "Home" => array("icon" => "fa fa-home", "link" => $location_admin),
    "Profile" => array("icon" => "fa fa-user", "link" => $location_admin_profile),
    "Employees" => array("icon" => "fa fa-users", "link" => $location_admin_employeelist),
    "Department List" => array("icon" => "fa fa-align-justify", "link" => $location_admin_departments),
    "Data Management" => array("icon" => "fa fa-database", "link" => $location_admin_datamanagement),
);

$employeeMenu = array(
    "Home" => array("icon" => "fa fa-home", "link" => $location_employee),
    "Profile" => array("icon" => "fa fa-user", "link" => $location_employee),
    "Leave Data Form" => array("icon" => "fa fa-align-justify", "link" => $location_employee),
);

?>