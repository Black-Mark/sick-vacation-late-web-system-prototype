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
$assets_logo_icon = $webhostpage.'/assets/images/indang-logo.ico';
$assets_bootstrap_vcss = $webhostpage.'/assets/bootstrap-5.0.2-dist/css/bootstrap.min.css';
$assets_bootstrap_css = $webhostpage.'/assets/bootstrap/dist/css/bootstrap.min.css';
$assets_bootstrap_js = $webhostpage.'/assets/bootstrap/dist/js/bootstrap.min.js';
$assets_jquery = $webhostpage.'/assets/bootstrap/assets/js/vendor/jquery-slim.min.js';
$assets_popper = $webhostpage.'/assets/bootstrap/assets/js/vendor/popper.min.js';
$assets_fontawesome = $webhostpage.'/assets/font-awesome/css/font-awesome.min.css';
$assets_css_styles = $webhostpage.'/assets/css/style.css';
$assets_datatable_css = $webhostpage.'/assets/datatables/datatables.min.css';
$assets_datatable_js = $webhostpage.'/assets/datatables/datatables.min.js';

// Web Host Page - Pages
$location_login = $webhostpage;

$location_admin = $webhostpage.'/admin';
$location_admin_profile = $webhostpage.'/admin/profile';
$location_admin_employeelist = $webhostpage.'/admin/employee-list';
$location_admin_departments = $webhostpage.'/admin/departments';
$location_admin_datamanagement = $webhostpage.'/admin/data-management';

$location_employee = $webhostpage.'/employee';
?>