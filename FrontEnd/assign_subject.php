<?php
include 'connect_db.php';

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classId = isset($_POST['classId']) ? trim($_POST['classId']) : '';
    $subjectId = isset($_POST['subjectId']) ? trim($_POST['subjectId']) : '';

    if (empty($classId) || empty($subjectId)) {
        $response['status'] = 'error';
        $response['message'] = 'Class ID and Subject ID are required.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO class_subject (ClassID, SubjectID) VALUES (:classId, :subjectId)");
            $stmt->bindParam(':classId', $classId);
            $stmt->bindParam(':subjectId', $subjectId);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Subject assigned successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to assign subject.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $response['status'] = 'error';
                $response['message'] = 'Subject is already assigned to this class.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Database error: ' . $e->getMessage();
            }
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
