<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['addEmployeeInfo'])) {
    $birthplace = sanitizeInput($_POST['birthplace'] ?? '');
    $spousesurname = sanitizeInput($_POST['spouseSurname'] ?? '');
    echo $birthplace;    
    echo $spousesurname;
}


?>