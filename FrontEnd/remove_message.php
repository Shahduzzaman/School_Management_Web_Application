<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    if ($type === 'error' && isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    if ($type === 'success' && isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    echo json_encode(['status' => 'success']);
}
?>
