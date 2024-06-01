<?php
include ("../constants/routes.php");
// include($components_file_error_handler);
include ($constants_file_dbconnect);
include ($constants_file_session_admin);
include ($constants_variables);

if (isset($_POST['addEmployeeInfo'])) {
    $employeeId = sanitizeInput($_POST['employeeId'] ?? '');
    // tbl_personal_info
    $birthplace = sanitizeInput($_POST['birthplace'] ?? '');
    $height = sanitizeInput($_POST['height'] ?? '');
    $weight = sanitizeInput($_POST['weight'] ?? '');
    $bloodtype = sanitizeInput($_POST['bloodtype'] ?? '');
    $gsis = sanitizeInput($_POST['gsis'] ?? '');
    $pagibig = sanitizeInput($_POST['pagibig'] ?? '');
    $philhealth = sanitizeInput($_POST['philhealth'] ?? '');
    $sss = sanitizeInput($_POST['sss'] ?? '');
    $tin = sanitizeInput($_POST['tin'] ?? '');
    $agency = sanitizeInput($_POST['agency'] ?? '');
    $citizenship = sanitizeInput($_POST['citizenship'] ?? '');
    $houseNo = sanitizeInput($_POST['houseNo'] ?? '');
    $street = sanitizeInput($_POST['street'] ?? '');
    $subdivision = sanitizeInput($_POST['subdivision'] ?? '');
    $city = sanitizeInput($_POST['city'] ?? '');
    $province = sanitizeInput($_POST['province'] ?? '');
    $zipCode = sanitizeInput($_POST['zipCode'] ?? '');
    $telephone = sanitizeInput($_POST['telephone'] ?? '');
    $mobile = sanitizeInput($_POST['mobile'] ?? '');
    // tbl_family_background
    $spousesurname = sanitizeInput($_POST['spouseSurname'] ?? '');
    $spousename = sanitizeInput($_POST['spouseName'] ?? '');
    $spousemiddlename = sanitizeInput($_POST['spouseMiddleName'] ?? '');
    $spousenameExtension = sanitizeInput($_POST['spouseNameExtension'] ?? '');
    $spouseOccupation = sanitizeInput($_POST['spouseOccupation'] ?? '');
    $spouseEmployer = sanitizeInput($_POST['spouseEmployer'] ?? '');
    $spouseBusinessAddress = sanitizeInput($_POST['spouseBusinessAddress'] ?? '');
    $spouseTelephone = sanitizeInput($_POST['spouseTelephone'] ?? '');
    $numberOfChildren = sanitizeInput($_POST['numberOfChildren'] ?? '');
    $fathersSurname = sanitizeInput($_POST['fathersSurname'] ?? '');
    $fathersFirstname = sanitizeInput($_POST['fathersFirstname'] ?? '');
    $fathersMiddlename = sanitizeInput($_POST['fathersMiddlename'] ?? '');
    $fathersnameExtension = sanitizeInput($_POST['fathersnameExtension'] ?? '');
    $MSurname = sanitizeInput($_POST['MSurname'] ?? '');
    $MName = sanitizeInput($_POST['MName'] ?? '');
    $MMName = sanitizeInput($_POST['MMName'] ?? '');
    // tbl_educational_background
    $graduateStudies = sanitizeInput($_POST['graduateStudies'] ?? '');
    $elemschoolName = sanitizeInput($_POST['elemschoolName'] ?? '');
    $elembasicEducation = sanitizeInput($_POST['elembasicEducation'] ?? '');
    $elemhighestLevel = sanitizeInput($_POST['elemhighestLevel'] ?? '');
    $elemScholarship = sanitizeInput($_POST['elemScholarship'] ?? '');
    $elemPeriod = sanitizeInput($_POST['elemPeriod'] ?? '');
    $elemperiodEnd = sanitizeInput($_POST['elemperiodEnd'] ?? '');
    $secondschoolName = sanitizeInput($_POST['secondschoolName'] ?? '');
    $secondbasicEducation = sanitizeInput($_POST['secondbasicEducation'] ?? '');
    $secondhighestLevel = sanitizeInput($_POST['secondhighestLevel'] ?? '');
    $secondScholarship = sanitizeInput($_POST['secondScholarship'] ?? '');
    $secondPeriod = sanitizeInput($_POST['secondPeriod'] ?? '');
    $secondperiodEnd = sanitizeInput($_POST['secondperiodEnd'] ?? '');
    $vocationalschoolName = sanitizeInput($_POST['vocationalschoolName'] ?? '');
    $vocationalbasicEducation = sanitizeInput($_POST['vocationalbasicEducation'] ?? '');
    $vocationalhighestLevel = sanitizeInput($_POST['vocationalhighestLevel'] ?? '');
    $vocationalScholarship = sanitizeInput($_POST['vocationalScholarship'] ?? '');
    $vocationalPeriod = sanitizeInput($_POST['vocationalPeriod'] ?? '');
    $vocationalperiodEnd = sanitizeInput($_POST['vocationalperiodEnd'] ?? '');
    $collegeschoolName = sanitizeInput($_POST['collegeschoolName'] ?? '');
    $collegebasicEducation = sanitizeInput($_POST['collegebasicEducation'] ?? '');
    $collegehighestLevel = sanitizeInput($_POST['collegehighestLevel'] ?? '');
    $collegeScholarship = sanitizeInput($_POST['collegeScholarship'] ?? '');
    $collegePeriod = sanitizeInput($_POST['collegePeriod'] ?? '');
    $collegeperiodEnd = sanitizeInput($_POST['collegeperiodEnd'] ?? '');

    if (!empty($employeeId) && trim($employeeId) != '') {
        $personalsuccess = 0;
        $familysuccess = 0;
        $educationalsuccess = 0;

        // tbl_personal_info
        // check if has a record
        $sql = "SELECT * FROM tbl_personal_info WHERE employee_id = ?";
        $personalStmt = $database->prepare($sql);
        $personalStmt->bind_param("s", $employeeId);
        $personalStmt->execute();
        $result = $personalStmt->get_result();

        if ($result->num_rows > 0) {
            // Update the existing record
            $updateSql = "UPDATE tbl_personal_info SET birthplace=?, height=?, weight=?, bloodtype=?, gsis=?, pagibig=?, philhealth=?, sss=?, tin=?, agency=?, citizenship=?, houseNo=?, street=?, subdivision=?, city=?, province=?, zipCode=?, telephone=?, mobile=? WHERE employee_id=?";
            $updatepersonalStmt = $database->prepare($updateSql);
            $updatepersonalStmt->bind_param("siisiiiiisssssssiiss", $birthplace, $height, $weight, $bloodtype, $gsis, $pagibig, $philhealth, $sss, $tin, $agency, $citizenship, $houseNo, $street, $subdivision, $city, $province, $zipCode, $telephone, $mobile, $employeeId);
            $updatepersonalStmt->execute();
            // echo "Record updated successfully";
        } else {
            // Insert a new record
            $insertSql = "INSERT INTO tbl_personal_info (employee_id, birthplace, height, weight, bloodtype, gsis, pagibig, philhealth, sss, tin, agency, citizenship, houseNo, street, subdivision, city, province, zipCode, telephone, mobile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertpersonalStmt = $database->prepare($insertSql);
            $insertpersonalStmt->bind_param("ssiisiiiiisssssssiis", $employeeId, $birthplace, $height, $weight, $bloodtype, $gsis, $pagibig, $philhealth, $sss, $tin, $agency, $citizenship, $houseNo, $street, $subdivision, $city, $province, $zipCode, $telephone, $mobile);
            $insertpersonalStmt->execute();
            // echo "New record created successfully";
        }

        // tbl_personal_info
        // check if has a record
        $sql = "SELECT * FROM tbl_personal_info WHERE employee_id = ?";
        $personalStmt = $database->prepare($sql);
        $personalStmt->bind_param("s", $employeeId);
        $personalStmt->execute();
        $result = $personalStmt->get_result();

        if ($result->num_rows > 0) {
            // Update the existing record
            $updateSql = "UPDATE tbl_personal_info SET birthplace=?, height=?, weight=?, bloodtype=?, gsis=?, pagibig=?, philhealth=?, sss=?, tin=?, agency=?, citizenship=?, houseNo=?, street=?, subdivision=?, city=?, province=?, zipCode=?, telephone=?, mobile=? WHERE employee_id=?";
            $updatepersonalStmt = $database->prepare($updateSql);
            $updatepersonalStmt->bind_param("siisiiiiisssssssiiss", $birthplace, $height, $weight, $bloodtype, $gsis, $pagibig, $philhealth, $sss, $tin, $agency, $citizenship, $houseNo, $street, $subdivision, $city, $province, $zipCode, $telephone, $mobile, $employeeId);
            $updatepersonalStmt->execute();
            // echo "Record updated successfully";
        } else {
            // Insert a new record
            $insertSql = "INSERT INTO tbl_personal_info (employee_id, birthplace, height, weight, bloodtype, gsis, pagibig, philhealth, sss, tin, agency, citizenship, houseNo, street, subdivision, city, province, zipCode, telephone, mobile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertpersonalStmt = $database->prepare($insertSql);
            $insertpersonalStmt->bind_param("ssiisiiiiisssssssiis", $employeeId, $birthplace, $height, $weight, $bloodtype, $gsis, $pagibig, $philhealth, $sss, $tin, $agency, $citizenship, $houseNo, $street, $subdivision, $city, $province, $zipCode, $telephone, $mobile);
            $insertpersonalStmt->execute();
            // echo "New record created successfully";
        }


        $personalStmt->close();

    } else {
        $_SESSION['alert_message'] = "There is no Employee Id Received!";
        $_SESSION['alert_type'] = $warning_color;
        $redirect_location = $empId ? $location_admin_departments_employee . "/" . $empId . "/" : $location_admin_departments_employee;
        header("Location: $redirect_location");
        exit();
    }
} else {
    // echo '<script type="text/javascript">window.history.back();</script>';
    header("Location: $location_admin_departments_employee");
    exit();
}

?>