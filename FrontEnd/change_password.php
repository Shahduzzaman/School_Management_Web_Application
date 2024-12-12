<?php
session_start();
include('connect_db.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $currentPassword = trim($_POST['current-password']);
    $newPassword = trim($_POST['new-password']);
    $reEnterPassword = trim($_POST['re-enter-password']);
    $UserID = '44444';  // In a real-world scenario, replace this with session-based UserID

    try {
        // Fetch current password from the database
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

        // Verify the current password
        if (password_verify($currentPassword, $currentPasswordHash)) {
            // Check if new passwords match
            if ($newPassword === $reEnterPassword) {
                // Hash the new password before storing it
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update password in the database
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
