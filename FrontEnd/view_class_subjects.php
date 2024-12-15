<?php
include 'connect_db.php';

$classId = $_GET['classId'] ?? '';
if (!$classId) {
    echo json_encode(['status' => 'error', 'message' => 'Class ID is required.']);
    exit();
}
try {
    $classStmt = $pdo->prepare("SELECT ClassID, ClassName FROM class WHERE ClassID = :classId");
    $classStmt->execute(['classId' => $classId]);
    $classInfo = $classStmt->fetch(PDO::FETCH_ASSOC);

    if (!$classInfo) {
        echo json_encode(['status' => 'error', 'message' => 'Class not found.']);
        exit();
    }
    $subjectStmt = $pdo->prepare("
        SELECT cs.SubjectID, s.SubjectName 
        FROM class_subject cs
        INNER JOIN subject s ON cs.SubjectID = s.SubjectID
        WHERE cs.ClassID = :classId
    ");
    $subjectStmt->execute(['classId' => $classId]);
    $subjects = $subjectStmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'classInfo' => $classInfo,
        'subjects' => $subjects,
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
