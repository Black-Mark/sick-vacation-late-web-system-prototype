<?php
@ob_start();
session_start();

if ($_SESSION) {
    $employeeId = $_SESSION['employeeId'];
    if ($employeeId) {
        $sql = "SELECT * FROM tbl_useraccounts WHERE employee_id= '$employeeId'";
        $result = $database->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['role'] == "Admin") {
                    header("location: ".$location_admin);
                } else if ($row['role'] == "Employee") {
                    header("location: ".$location_employee);
                } else {
                    ?>
                        <script>alert("Error: There is no such role!");</script>
                    <?php
                }
            }
        } else {
            ?>
            <script>alert("An error has occurred: There is no registered employee ID");</script>
            <?php
        }
    }
}

?>