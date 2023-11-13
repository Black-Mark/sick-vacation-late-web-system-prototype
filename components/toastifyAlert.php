<?php
function showToast($message, $type = 'success')
{
    echo "<script>
            Toastify({
                text: '$message',
                duration: 3000,
                destination: 'https://github.com/apvarun/toastify-js',
                newWindow: true,
                close: true,
                gravity: 'top',
                position: 'center',
                backgroundColor: '$type',
                stopOnFocus: true,
            }).showToast();
        </script>";
}

if (isset($_SESSION['alert_message'])) {
    $message = $_SESSION['alert_message'];
    $cleaned_message = str_replace(["'", '"'], '', $message);
    showToast($cleaned_message, 'info');
    unset($_SESSION['alert_message']);
}

?>