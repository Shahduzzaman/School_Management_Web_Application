<?php
session_start();
include('connect_db.php');

// Set session timeout duration in seconds
$inactive = 10;

// Update the last activity timestamp
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $inactive) {
        session_unset();
        session_destroy();
        exit();
    }
}
$_SESSION['last_activity'] = time();
?>


