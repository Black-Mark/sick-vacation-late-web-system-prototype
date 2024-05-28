<?php
include("../constants/routes.php");
include($constants_file_dbconnect);
include($constants_file_session_admin);
include($constants_variables);

if (isset($_POST['upload'])) {
    $fileName = $_FILES['file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    if ($file_ext != 'csv') {
        die(422);
    }

    $inputFileNamePath = $_FILES['file']['tmp_name'];

    try {
        $file = new SplFileObject($inputFileNamePath);

        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        foreach ($file as $key => $csv) {
            if ($key == 0) {
                continue; //Skips csv header
            }

            $employee_id = trim($csv[0]); //First column of csv
            $total_minutes = trim($csv[1]); //Second column of csv



        }

    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}
?>