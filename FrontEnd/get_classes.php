<?php
include 'connect_db.php';

$response = ['status' => '', 'classes' => []];

try {
    $stmt = $pdo->query("SELECT ClassID, ClassName FROM class");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['status'] = 'success';
    $response['classes'] = $classes;
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
