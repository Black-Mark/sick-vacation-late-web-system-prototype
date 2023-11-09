<?php

@ob_start();
session_start();

$employeeId = $_SESSION['employeeId'];

if ($employeeId) {
    $sql = "SELECT * FROM tbl_useraccounts WHERE employee_id= '$employeeId'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['role'] != "Admin") {
                if ($row['role'] == "employee") {
                    header("location: ".$location_employee);
                } else {
                    ?>
                    <script>alert("Error: There is no such role!");</script>
                    <?php
                }
            }
        }
    } else {
        ?>
        <script>alert("An error has occurred: There is no registered employee ID.");</script>
        <?php
    }
} else {
    header("location: ".$location_login);
}
?>