<?php
include 'connect_db.php';

$response = [
    'status' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subjectId = isset($_POST['subjectId']) ? trim($_POST['subjectId']) : '';
    $subjectName = isset($_POST['subjectName']) ? trim($_POST['subjectName']) : '';

    if (empty($subjectId) || empty($subjectName)) {
        $response['status'] = 'error';
        $response['message'] = 'Both Subject ID and Subject Name are required.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO `subject`(`SubjectID`, `SubjectName`) VALUES (:subjectId, :subjectName)");
            
            $stmt->bindParam(':subjectId', $subjectId);
            $stmt->bindParam(':subjectName', $subjectName);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Subject created successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to create the subject.';
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
