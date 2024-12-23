<?php
include('session.php');
include 'connect_db.php';

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classId = isset($_POST['classId']) ? trim($_POST['classId']) : '';
    $subjectId = isset($_POST['subjectId']) ? trim($_POST['subjectId']) : '';

    if (empty($classId) || empty($subjectId)) {
        $_SESSION['error'] = 'Class ID and Subject ID are required.';
        header('Location: adminDashboard.php');
        exit();
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO class_subject (ClassID, SubjectID) VALUES (:classId, :subjectId)");
            $stmt->bindParam(':classId', $classId);
            $stmt->bindParam(':subjectId', $subjectId);

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Subject assigned successfully.';
                header('Location: adminDashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to assign subject.';
                header('Location: adminDashboard.php');
                exit();
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['error'] = 'Subject is already assigned to this class.';
                header('Location: adminDashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Database error: ' . $e->getMessage();
                header('Location: adminDashboard.php');
                exit();
            }
        }
    }
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: adminDashboard.php');
    exit();
}
?>
