<?php
session_start();
include('connect_db.php');

if (!isset($_SESSION['UserID'])) {
    echo "Please log in to view your profile.";
    exit();
}

$UserID = $_SESSION['UserID'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = trim($_POST['current-password']);
    $newPassword = trim($_POST['new-password']);
    $reEnterPassword = trim($_POST['re-enter-password']);

    try {
        $query = "SELECT `Password` FROM `user` WHERE `UserID` = :UserID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':UserID', $UserID);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "User not found.";
            exit();
        }

        $currentPasswordHash = $user['Password'];

        if (password_verify($currentPassword, $currentPasswordHash)) {
            if ($newPassword === $reEnterPassword) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateQuery = "UPDATE `user` SET `Password` = :newPassword WHERE `UserID` = :UserID";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->bindParam(':newPassword', $newPasswordHash);
                $updateStmt->bindParam(':UserID', $UserID);

                if ($updateStmt->execute()) {
                    echo "Password changed successfully.";
                } else {
                    echo "Failed to change the password. Please try again.";
                }
            } else {
                echo "New passwords do not match. Please check your input.";
            }
        } else {
            echo "The current password is incorrect.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
