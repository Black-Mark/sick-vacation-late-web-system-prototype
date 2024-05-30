<?php
include ("../constants/routes.php");
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['upload'])) {
    if (!isset($_FILES['file'])) {
        die('File not uploaded');
    }

    $fileName = $_FILES['file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    if ($file_ext != 'csv') {
        die('Invalid file type');
    }

    $inputFileNamePath = $_FILES['file']['tmp_name'];

    try {
        $file = new SplFileObject($inputFileNamePath);

        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);

        foreach ($file as $key => $csv) {
            if ($key == 0) {
                continue; // Skips csv header
            }

            $employee_id = trim($csv[0]); // First column of csv
            $total_minutes = trim($csv[1]); // Second column of csv

            if (!empty($employee_id)) {
                // Ensure total_minutes is an integer
                $total_minutes = (int) $total_minutes;
                $type = 'Late';

                $formatted_duration = getFormattedDurationInMinutes($total_minutes);

                $days = $formatted_duration['days'];
                $hours = $formatted_duration['hours'];
                $minutes = $formatted_duration['minutes'];

                $date_of_action = date('Y-m-d');

                error = 0
                failed = 0
                notExist = 0
                noInitialRecord = 0
                update = 0
                
                select the employee id if existing in the tbl_useraccounts employee_id
                if(existing){
                    get the periodEnd from tbl_leavedataform where recordType = "Initial Record" and employee_id = $employeeId if existing
                    if(there is a initial record and there is periodENd){
                        if (check the periodEnd if month and year are > periodEnd){
                            period_start = firstday of month Year and period_end = end of month Year
                            if(Check in the tbl_leavedataform if particular = "Late" and period = $period_start and periodEnd = $period_end if there is update only){
                                update + 1
                            }else{
                                insert into tbl_leavedataform
                                employee_id = $employee_id
                            }
                        }else if(check the periodEnd if month and year are < periodEnd and has the same month){
                            sample if January 01, 2024 (month year) < January 10, 2024(periodEnd){
                                Make the period_start January 10, 2024 and period end to end date of January
                            }
                        }else if(check the periodEnd if month and year are < periodEnd){
                            failed + 1;
                        }else{
                            error + 1
                        }
                    }else{
                        noInitialRecord + 1
                    }
                }else{
                    notExist + 1;
                }
                // // Echo the result
                // echo "Eal Minutes: $total_minutes<br>";
                // echo "Daymployee ID: $employee_id<br>";
                // echo "Tots: $days, Hours: $hours, Minutes: $minutes<br>";
                // echo "Date of Action: $date_of_action<br>";
                // echo "Type: $type<br><br>";
            }
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
?>