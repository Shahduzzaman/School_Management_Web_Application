<?php
session_start();
include('connect_db.php');

$inactive = 600;

if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $inactive) {
        echo "<script>
            alert('Your session has expired. You will be redirected to the login page.');
            window.location.href = 'login.php';
        </script>";
        session_unset();
        session_destroy();
        exit();
    }
}

$_SESSION['last_activity'] = time();
?>
