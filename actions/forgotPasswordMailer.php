<?php
include("../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_login);
include($constants_variables);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require($assets_phpmailer_exception);
require($assets_phpmailer);
require($assets_phpmailer_smtp);

if (isset($_REQUEST['sendForgotPassword'])) {
    $emailToBeVerify = strip_tags(mysqli_real_escape_string($database, $_POST['emailToBeVerify']));

    $checkEmailExistQuery = "SELECT * FROM tbl_useraccounts WHERE email = ?";
    $checkEmailExistStatement = mysqli_prepare($database, $checkEmailExistQuery);

    mysqli_stmt_bind_param($checkEmailExistStatement, "s", $emailToBeVerify);
    mysqli_stmt_execute($checkEmailExistStatement);

    $checkEmailExistResult = mysqli_stmt_get_result($checkEmailExistStatement);

    $userData = mysqli_fetch_assoc($checkEmailExistResult);

    if ($userData) {

        // $_SESSION['alert_message'] = "Email exists. User ID: " . $userData['employee_id'] . ", Username: " . $userData['firstName'] . ", Email: " . $userData['email'];
        // $_SESSION['alert_type'] = $success_color;
        $token = bin2hex(random_bytes(50));
        // $_SESSION['resetToken'] = $token;

        $email_message = '<b>Hello! ' . $userData['firstName'] . ' ' . substr($userData['middleName'], 0, 1) . '. ' . $userData['lastName'] . '</b>
        <h3>We received a request to reset your password.</h3>
        <p>Kindly click the below link to reset your password</p>'
            .'http://localhost'. $location_resetpassword . '?resetToken=' . $token .
            '<br><br>
        <p>With regards,</p>
        <b>Human Resources System</b>';
        $email_nonhtml = "Reset Your Password In This Link: " . $location_resetpassword . '?resetToken=' . $token;

        $recordResetPasswordTokenQuery = "INSERT INTO tbl_passwordreset_tokens 
        (employee_id, email, resetTokenHash, resetTokenExpiration, status) 
        VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR), 1)";

        $recordResetPasswordTokenStatement = $database->prepare($recordResetPasswordTokenQuery);
        $recordResetPasswordTokenStatement->bind_param("sss", $userData['employee_id'], $emailToBeVerify, $token);
        $recordResetPasswordTokenStatement->execute();
        $recordResetPasswordTokenStatement->close();

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication

            $mail->Username = 'indang.mun.hr.sil@gmail.com';                     //SMTP username
            $mail->Password = 'pxec bzws ouce cehh';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('indang.mun.hr.sil@gmail.com', 'Human Resources Manager');
            $mail->addAddress($emailToBeVerify);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('indang.mun.hr.sil@gmail.com', 'Human Resources Manager');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body = $email_message;

            $mail->AltBody = $email_nonhtml;

            $mail->send();

            $_SESSION['alert_message'] = 'Password Reset Link has been Sent';
            $_SESSION['alert_type'] = $success_color;

        } catch (Exception $e) {
            $_SESSION['alert_message'] = "Password Reset Link could not be Sent. Mailer Error: {$mail->ErrorInfo}";
            $_SESSION['alert_type'] = $error_color;
        }

    } else {
        $_SESSION['alert_message'] = "Email does not exist";
        $_SESSION['alert_type'] = $warning_color;
    }

    mysqli_stmt_close($checkEmailExistStatement);

    header("Location: " . $location_forgotpassword);
    exit();
} else {
    header("Location: " . $location_forgotpassword);
    exit();
}

?>