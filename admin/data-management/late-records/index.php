<?php
include("../../../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

// Assuming $mostMinimalYear is set somewhere in your code
$mostMinimalYear = $systemStartDate;

// Handle form submission to get the selected year
$selectedYear = $_POST['selectedYear'] ?? date("Y");

// Fetch records for the selected year
$sql = "SELECT * FROM tbl_laterecordfile WHERE monthYearOfRecord LIKE '%$selectedYear%' ORDER BY monthYearOfRecord ASC";
$result = $database->query($sql);

$records = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[$row['monthYearOfRecord']] = $row;
    }
}

// Generate all months for the selected year
$months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
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

            <div class="box-container">
                <div>
                    <a href="<?php echo $location_admin_datamanagement; ?>"><button class="custom-regular-button">Back</button></a>
                    <div class="title-text">Employee Late Record</div>
                    <div class="title-text-caption">
                        <h6>Selected Year: <?php echo $selectedYear; ?></h6>
                    </div>
                </div>

                <div class="button-container component-container mb-2">
                    <form action="" method="post">
                        <label for="selectedYear">Select a Year:</label>
                        <select name="selectedYear" id="selectedYear" class="custom-regular-button" aria-label="Year Selection">
                            <?php
                            $currentYear = date("Y");

                            $start_year = $mostMinimalYear ?? $currentYear;

                            if (!$start_year || $start_year <= 1924) {
                                $start_year = $currentYear;
                            }

                            for ($year = $currentYear; $year >= $start_year; $year--) {
                                ?>
                                <option value="<?php echo $year; ?>" <?php echo ($year == $selectedYear) ? 'selected' : ''; ?>>
                                    <?php echo $year; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="submit" name="leaveTransactionYear" value="Load Year Record" class="custom-regular-button">
                    </form>
                </div>

                <div class="month-records">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($months as $month) {
                                $monthYear = "$month $selectedYear";
                                ?>
                                <tr>
                                    <td><?php echo $month; ?></td>
                                    <td>
                                        <?php
                                        if (isset($records[$monthYear])) {
                                            $file = $records[$monthYear]['fileOfRecord'];
                                            if (file_exists($file)) {
                                                ?>
                                                <a href="<?php echo $file; ?>" download>Download</a>
                                                <?php
                                            } else {
                                                ?>
                                                Missing file
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            No record
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
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
