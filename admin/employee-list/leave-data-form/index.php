<?php
include("../../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

$empId = isset($_GET['empid']) ? filter_var($_GET['empid'], FILTER_SANITIZE_STRING) : null;

if ($empId === 'index.php' || $empId === 'index.html' || $empId === null) {
    $empId = null;
} else {
    // $formattedempId = ucwords(str_replace('-', ' ', $empId));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Admin Page">
    <?php
    include($constants_file_html_credits);
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $assets_logo_icon; ?>">

    <link rel="stylesheet" href="<?php echo $assets_bootstrap_vcss; ?>">
    <link rel="stylesheet" href="<?php echo $assets_bootstrap_css; ?>">
    <script src="<?php echo $assets_jquery; ?>"></script>
    <script src="<?php echo $assets_popper; ?>"></script>
    <script src='<?php echo $assets_bootstrap_js; ?>'></script>

    <link rel='stylesheet' href="<?php echo $assets_fontawesome; ?>">

    <link rel="stylesheet" href="<?php echo $assets_toastify_css; ?>">
    <script src="<?php echo $assets_toastify_js; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_datatable_css; ?>">
    <script src="<?php echo $assets_datatable_js; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_datatable_css_select; ?>">
    <script src="<?php echo $assets_datatable_js_select; ?>"></script>

    <link rel="stylesheet" href="<?php echo $assets_datatable_bootstrap; ?>">

    <link rel="stylesheet" href="<?php echo $assets_css_styles; ?>">

    <!-- <script src="<?php
    // echo $assets_tailwind; 
    ?>"></script> -->
</head>

<body class="webpage-background-cover-admin">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">

            <div>
                <?php include($components_file_navpanel); ?>
            </div>

            <div class='box-container'>
                <div class='data-form-detail-container'>
                    <div>Republic of the Philippines</div>
                    <div>Province of Cavite</div>
                    <div>Municipality of Indang</div>
                </div>

                <div>
                    <table class="data-form-detail-table" >
                        <thead>
                            <tr>
                                <th colSpan='8' class="table-head-base">
                                    <div>Name</div>
                                </th>
                                <th colSpan='6' class="table-head-base">
                                    <div>Division/Office</div>
                                </th>
                                <th colSpan='6' class="table-head-base">
                                    <div>1st. Day of Service</div>
                                </th>
                            </tr>
                            <tr>
                                <th rowSpan='2' colSpan='4' class="table-head-base">Period</th>
                                <th rowSpan='2' colSpan='4' class="table-head-base">Particulars</th>
                                <th colSpan='4' class="table-head-base">Vacation Leave</th>
                                <th colSpan='4' class="table-head-base">Sick Leave</th>
                                <th rowSpan='2' colSpan='4' class="table-head-base">
                                    <div>Date & Action Taken on Application For Leave </div>
                                </th>
                            </tr>
                            <tr>
                                <th class="table-head-base">Earned</th>
                                <th class="table-head-base">Abs. Und. W/P</th>
                                <th class="table-head-base">Bal.</th>
                                <th class="table-head-base">Abs. Und. W/O P</th>
                                <th class="table-head-base">Earned</th>
                                <th class="table-head-base">Abs. Und. W/P</th>
                                <th class="table-head-base">Bal.</th>
                                <th class="table-head-base">Abs. Und. W/O P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr key="">
                                <td colSpan="4" class="table-item-base">
                                    {itemData.period}
                                </td>
                                <td colSpan="4" class="table-item-base">
                                    {itemData.particulars}
                                </td>
                                <td class="table-item-base">
                                    {itemData.vacationEarned}
                                </td>
                                <td class="table-item-base">
                                    {itemData.vacationWithPay}
                                </td>
                                <td class="table-item-base">
                                    {itemData.vacationBalance}
                                </td>
                                <td class="table-item-base">
                                    {itemData.vacationWithoutPay}
                                </td>
                                <td class="table-item-base">
                                    {itemData.sickEarned}
                                </td>
                                <td class="table-item-base">
                                    {itemData.sickWithPay}
                                </td>
                                <td class="table-item-base">
                                    {itemData.sickBalance}
                                </td>
                                <td class="table-item-base">
                                    {itemData.sickWithoutPay}
                                </td>
                                <td colSpan="4" class="table-item-base">
                                    {itemData.dateAndAction}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    </div>

    <div>
        <?php
        include($components_file_footer);
        ?>
    </div>

    <?php include($components_file_toastify); ?>

</body>

</html>