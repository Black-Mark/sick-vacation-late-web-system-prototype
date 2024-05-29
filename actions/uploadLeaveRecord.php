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

            $period_start = trim($csv[2]); //Third column of csv
            $period_end = trim($csv[3]); //Fourth column of csv

            $type = 'Late';

            $formatted_duration = getFormattedDurationInMinutes($total_minutes);

            $days = $formatted_duration['days'];
            $hours = $formatted_duration['hours'];
            $minutes = $formatted_duration['minutes'];

            $date_of_action = date('Y-m-d');

            //TODO Do the code logic here on adding leave data record

        }

    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}

function getFormattedDurationInMinutes(int $totalMinutes): array
{
    $days = floor($totalMinutes / 1440); // 1440 minutes in a day
    $hours = floor(($totalMinutes % 1440) / 60); // Remaining minutes divided by 60 to get hours
    $minutes = $totalMinutes % 60; // Remaining minutes after accounting for days and hours

    return [
        'days' => $days,
        'hours' => $hours,
        'minutes' => $minutes,
    ];
}
