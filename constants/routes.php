<?php
$webhostpath = 'C:\xampp\htdocs\www.indang-municipal-hr.com.ph';
$webhostpage = '/www.indang-municipal-hr.com.ph';

$action_add_employee = $webhostpage.'/actions/addEmployee.php';
$action_edit_employee = $webhostpage.'/actions/editEmployee.php';
$action_delete_employee = $webhostpage.'/actions/deleteEmployee.php';

$action_add_department = $webhostpage.'/actions/addDepartment.php';
$action_edit_department = $webhostpage.'/actions/editDepartment.php';
$action_delete_department = $webhostpage.'/actions/deleteDepartment.php';

$action_add_leaverecorddata = $webhostpage.'/actions/addLeaveDataRecord.php';
$action_edit_leaverecorddata = $webhostpage.'/actions/editLeaveDataRecord.php';
$action_delete_leaverecorddata = $webhostpage.'/actions/deleteLeaveDataRecord.php';

$components_file_error_handler = $webhostpath.'/components/error_handler.php';
$components_file_topnav = $webhostpath.'/components/topnavigation.php';
$components_file_footer = $webhostpath.'/components/footer.php';
$components_file_toastify = $webhostpath.'/components/toastifyAlert.php';
$components_file_navpanel = $webhostpath.'/components/navPanel.php';

$constants_file_dbconnect = $webhostpath.'/constants/dbconnect.php';
$constants_file_session_login = $webhostpath.'/constants/loginSession.php';
$constants_file_session_admin = $webhostpath.'/constants/adminSession.php';
$constants_file_session_employee = $webhostpath.'/constants/employeeSession.php';
$constants_file_role_menu = $webhostpath.'/constants/roleMenu.php';
$constants_file_html_credits = $webhostpath.'/constants/htmlHead.php';
$constants_variables = $webhostpath.'/constants/globalVariable.php';

// Web Host Page - Assets
$assets_script_topnav = $webhostpage.'/assets/js/topnav.js';
$assets_logo_png = $webhostpage.'/assets/images/indang-logo.png';
$assets_logo_icon = $webhostpage.'/assets/images/indang-logo.ico';
$assets_bootstrap_vcss = $webhostpage.'/assets/bootstrap-5.0.2-dist/css/bootstrap.min.css';
$assets_bootstrap_vjs = $webhostpage.'/assets/bootstrap-5.0.2-dist/js/bootstrap.min.js';
$assets_bootstrap_css = $webhostpage.'/assets/bootstrap/dist/css/bootstrap.min.css';
$assets_bootstrap_js = $webhostpage.'/assets/bootstrap/dist/js/bootstrap.min.js';
$assets_jquery = $webhostpage.'/assets/bootstrap/assets/js/vendor/jquery-slim.min.js';
$assets_popper = $webhostpage.'/assets/bootstrap/assets/js/vendor/popper.min.js';
$assets_fontawesome = $webhostpage.'/assets/font-awesome/css/font-awesome.min.css';
$assets_css_styles = $webhostpage.'/assets/css/style.css';
$assets_datatable_css = $webhostpage.'/assets/datatables/datatables.min.css';
$assets_datatable_js = $webhostpage.'/assets/datatables/datatables.min.js';
$assets_datatable_bootstrap = $webhostpage.'/assets/datatables/DataTables-1.13.7/css/dataTables.bootstrap.css';
$assets_datatable_css_select = $webhostpage.'/assets/datatables/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css';
$assets_datatable_js_select = $webhostpage.'/assets/datatables/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.min.js';
$assets_toastify_css = $webhostpage.'/assets/toastify/toastify.css';
$assets_toastify_js = $webhostpage.'/assets/toastify/toastify.js';
$assets_tailwind = $webhostpage.'/assets/js/tailwind.js';
$assets_file_leavedataform = $webhostpage.'/assets/js/leaveDataForm.js';

// Web Host Page - Pages
$location_login = $webhostpage;

$location_admin = $webhostpage.'/admin';
$location_admin_profile = $webhostpage.'/admin/profile';
$location_admin_employeelist = $webhostpage.'/admin/employee-list';
$location_admin_employeelist_user = $webhostpage.'/admin/employee-list/user-info';
$location_admin_employeelist_leavedataform = $webhostpage.'/admin/employee-list/leave-data-form';
$location_admin_departments = $webhostpage.'/admin/departments';
$location_admin_departments_office = $webhostpage.'/admin/departments/office';
$location_admin_datamanagement = $webhostpage.'/admin/data-management';

$location_employee = $webhostpage.'/employee';
?>