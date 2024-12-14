<?php
session_start();
ob_start(); // Enable output buffering

include('connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize the input
    $selectClass = trim($_POST['selectClass']);

    // Check if class selection is empty
    if (empty($selectClass)) {
        $_SESSION['error'] = 'Class must be selected.';
        header('Location: adminDashboard.php');
        exit();
    }

    try {
        // Prepare the SQL query to delete the selected class
        $query = "DELETE FROM `class` WHERE `ClassID` = :classID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':classID', $selectClass, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Class '$selectClass' has been successfully deleted.";
        } else {
            $_SESSION['error'] = 'Failed to delete class. Please try again.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database Error: ' . $e->getMessage();
    }

    header('Location: adminDashboard.php');
    exit();
}
?>
