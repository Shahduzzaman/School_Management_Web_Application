<?php
include('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $sql = "DELETE FROM `user` WHERE `UserID` = '$userId'";

    if ($conn->query($sql)) {
        echo 'Account deleted successfully';
    } else {
        echo 'Error deleting account: ' . $conn->error;
    }
    
    $conn->close();
}
?>
