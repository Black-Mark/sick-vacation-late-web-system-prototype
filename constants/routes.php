<?php
$webhostpath = 'C:\xampp\htdocs\www.indang-municipal-hr.com.ph';
$webhostpage = '/www.indang-municipal-hr.com.ph';

$components_file_error_handler = $webhostpath.'/components/error_handler.php';
$components_file_topnav = $webhostpath.'/components/topnavigation.php';
$components_file_footer = $webhostpath.'/components/footer.php';

$constants_file_dbconnect = $webhostpath.'/constants/dbconnect.php';
$constants_file_session_login = $webhostpath.'/constants/loginSession.php';
$constants_file_session_admin = $webhostpath.'/constants/adminSession.php';
$constants_file_session_employee = $webhostpath.'/constants/employeeSession.php';

$constants_file_role_menu = $webhostpath.'/constants/roleMenu.php';

$constants_file_html_credits = $webhostpath.'/constants/htmlHead.php';

// Web Host Page - Assets
$assets_script_topnav = $webhostpage.'/assets/js/topnav.js';
$assets_logo_png = $webhostpage.'/assets/images/indang-logo.png';

// Web Host Page - Pages
$location_login = $webhostpage;

$location_admin = $webhostpage.'/admin';
$location_admin_profile = $webhostpage.'/admin/profile';
$location_admin_employeelist = $webhostpage.'/admin/employee-list';
$location_admin_departments = $webhostpage.'/admin/departments';
$location_admin_datamanagement = $webhostpage.'/admin/data-management';

$location_employee = $webhostpage.'/employee';
?>