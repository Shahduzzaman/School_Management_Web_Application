<?php
session_start();
include('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $userID = trim($_POST['userId']);
    $password = trim($_POST['password']);

    try {
        // Fetch user data from the database
        $query = "SELECT `UserID`, `Password`, `role` FROM `user` WHERE `UserID` = :UserID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':UserID', $userID);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userPasswordHash = $user['Password'];
            $userType = $user['role'];

            // Verify submitted password with stored hash
            if (password_verify($password, $userPasswordHash)) {
                $_SESSION['UserID'] = $user['UserID'];
                
                // Redirect to appropriate dashboard based on UserID range and length
                if ($user['UserID'] >= 1 && $user['UserID'] <= 9) {
                    header('Location: AdminDashboard.php');
                } elseif ($user['UserID'] >= 11 && $user['UserID'] <= 20) {
                    header('Location: accountantDashboard.php');
                } elseif ($user['UserID'] >= 21 && $user['UserID'] <= 40) {
                    header('Location: moderatorDashboard.php');
                } elseif (strlen($user['UserID']) === 3) {
                    header('Location: teacherDashboard.php');
                } elseif (strlen($user['UserID']) === 5) {
                    header('Location: studentDashboard.php');
                } else {
                    echo "Invalid UserID";
                    exit();
                }
                exit();

            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not found!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>