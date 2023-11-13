<?php
include("./constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_login);

if (isset($_REQUEST['login'])) {
    $employeeId = strip_tags(mysqli_real_escape_string($database, $_POST['employeeId']));
    $password = strip_tags(mysqli_real_escape_string($database, $_POST['password']));

    if (!empty($employeeId) && !empty($password)) {
        try {
            $query = "SELECT * FROM tbl_useraccounts WHERE employee_id='$employeeId' AND BINARY password='$password'";

            $result = mysqli_query($database, $query);
            if ($result === false) {
                throw new Exception("Database query failed: " . mysqli_error($database));
            }

            $count = mysqli_num_rows($result);

            if ($count > 0) {
                $user_data = mysqli_fetch_assoc($result);

                session_regenerate_id();
                $_SESSION['employeeId'] = $employeeId;
                $_SESSION['role'] = $user_data['role'];
                $_SESSION['username'] = $user_data['firstName'] . " " . $user_data['lastName'];

                if ($_SESSION['role'] == 'Admin') {
                    header("Location: " . $location_admin);
                } elseif ($_SESSION['role'] == 'Employee') {
                    header("Location: " . $location_employee);
                } else {
                    session_destroy();
                }
            } else {
                echo '<script>alert("Incorrect username or password. Please try again.");</script>';
            }
        } catch (Exception $e) {
            echo '<script>alert("An error occurred: ' . $e->getMessage() . '");</script>';
        } finally {
            // Redirect to the same page to clear the form fields
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        echo '<script>alert("Please fill in both Employee ID and Password fields.");</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Login Page">
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
    <link rel="stylesheet" href="<?php echo $assets_css_styles; ?>">

    <!-- <script src="<?php
    // echo $assets_tailwind; 
    ?>"></script> -->
</head>

<body class="login-body">
    <div class="login-page-content custom-scrollbar">
        <div class="login-container">
            <div class="logo-container">
                <img src="./assets/images/indang-logo.png" alt="Web Logo" class="web-logo">
            </div>
            <h1 class="login-title">Log In</h1>
            <form method="POST" autoComplete="off" class="login-form">
                <div class="input-container">
                    <div class='inputs-group'>
                        <input type="text" autofocus id="employeeId" name="employeeId" placeholder="Employee ID..."
                            class="login-text-input" required>
                        <input type="password" id="password" name="password" placeholder="Enter Password..."
                            class="login-text-input" required>
                        <label class="login-password-toggle">
                            <input type="checkbox" id="showPassword"> Show Password
                        </label>
                    </div>
                    <input type="submit" name="login" value="Login" class="login-button">
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            var passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>

</body>

</html>