<?php
include('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];

    $sql = "SELECT `Name`, `UserID` FROM `user` WHERE `UserID` = '$userId'";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'name' => $user['Name'],
                'userId' => $user['UserID']
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $conn->close();
}
?>
