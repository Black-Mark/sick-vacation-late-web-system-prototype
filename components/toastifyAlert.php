<?php
function showToast($message, $type = 'success')
{
    echo "<script>
            Toastify({
                text: '$message',
                duration: 3000,
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
    $alert_message = $_SESSION['alert_message'];
    $alert_type = isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : 'info';
    $cleaned_alert_message = str_replace(["'", '"'], '', $alert_message);
    showToast($cleaned_alert_message, $alert_type);
    unset($_SESSION['alert_message']);
    unset($_SESSION['alert_type']);
}

?>