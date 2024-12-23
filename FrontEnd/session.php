<?php
session_start();
include('connect_db.php');

$inactive = 10;

if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $inactive) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

$_SESSION['last_activity'] = time();
?>