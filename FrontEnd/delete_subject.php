<?php
include 'connect_db.php';

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subjectId = isset($_POST['subjectId']) ? trim($_POST['subjectId']) : '';

    if (empty($subjectId)) {
        $response['status'] = 'error';
        $response['message'] = 'Subject ID is required.';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM subject WHERE SubjectID = :subjectId");
            $stmt->bindParam(':subjectId', $subjectId);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Subject deleted successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to delete the subject.';
            }
        } catch (PDOException $e) {
            $response['status'] = 'error';
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
