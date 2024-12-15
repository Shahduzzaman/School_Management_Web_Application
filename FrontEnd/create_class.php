<?php
session_start();
include('connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classID = trim($_POST['classID']);
    $className = trim($_POST['className']);
    

    if (empty($classID) || empty($className)) {
        $_SESSION['error'] = 'Class ID and Class Name are required.';
        header('Location: adminDashboard.php');
        exit();
    }

    try {
        $query = "INSERT INTO `class` (`ClassID`, `ClassName`) VALUES (:classID, :className)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':classID', $classID);
        $stmt->bindParam(':className', $className);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Class '$className' with ID '$classID' has been successfully created.";
            header('Location: adminDashboard.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to create class. Please try again.';
            header('Location: adminDashboard.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database Error: ' . $e->getMessage();
        header('Location: adminDashboard.php');
        exit();
    }
}
?>
