<?php
include 'connect_db.php';

$response = ['status' => '', 'subjects' => []];

try {
    // Use DISTINCT to avoid duplicates in the result set
    $stmt = $pdo->query("SELECT DISTINCT SubjectID, SubjectName FROM subject");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['status'] = 'success';
    $response['subjects'] = $subjects;
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
