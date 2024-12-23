<?php
include('session.php');
include('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = trim($_POST['userId']);
    $password = trim($_POST['password']);

    try {
        $query = "SELECT `UserID`, `Password`, `role` FROM `user` WHERE `UserID` = :UserID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':UserID', $userID);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userPasswordHash = $user['Password'];
            $userType = $user['role'];

            if (password_verify($password, $userPasswordHash)) {
                $_SESSION['UserID'] = $user['UserID'];

                if ($user['UserID'] >= 1 && $user['UserID'] <= 9) {
                    header('Location: AdminDashboard.php');
                    exit();
                } elseif ($user['UserID'] >= 11 && $user['UserID'] <= 20) {
                    header('Location: accountantDashboard.php');
                    exit();
                } elseif ($user['UserID'] >= 21 && $user['UserID'] <= 40) {
                    header('Location: moderatorDashboard.php');
                    exit();
                } elseif (strlen($user['UserID']) === 3) {
                    header('Location: teacherDashboard.php');
                    exit();
                } elseif (strlen($user['UserID']) === 5) {
                    header('Location: studentDashboard.php');
                    exit();
                } else {
                    $_SESSION['error'] = 'Invalid UserID';
                    header('Location: login.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Incorrect password';
                header('Location: login.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'User not found!';
            header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database Error: ' . $e->getMessage();
        header('Location: login.php');
        exit();
    }
}
?>
