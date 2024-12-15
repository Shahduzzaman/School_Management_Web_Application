<?php
include('connect_db.php');
header('Content-Type: application/json');
if (!isset($_GET['StudentID']) || !isset($_GET['ClassID'])) {
    echo json_encode(['error' => 'Student ID and Class ID are required']);
    exit();
}

$StudentID = $_GET['StudentID'];
$ClassID = $_GET['ClassID'];

try {
    $queryUser = "SELECT u.UserID, u.Name, u.DateOfBirth, u.FatherName, u.MotherName, 
                         u.GuardianPhoneNumber, u.PresentAddress, u.PermanentAddress, 
                         u.Picture, u.`Birth Certificate` AS BirthCertificate, 
                         u.`Father's NID` AS FathersNID, u.`Mother's NID` AS MothersNID
                  FROM user u
                  INNER JOIN student s ON u.UserID = s.UserID
                  WHERE s.RollNumber = :StudentID AND s.ClassID = :ClassID";
    $stmtUser = $pdo->prepare($queryUser);
    $stmtUser->bindParam(':StudentID', $StudentID);
    $stmtUser->bindParam(':ClassID', $ClassID);
    $stmtUser->execute();

    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo json_encode(['error' => 'Student not found']);
        exit();
    }
    $queryResults = "SELECT r.ResultID, r.Marks, r.TotalMarks, r.Grade, r.GPA, e.Term, s.SubjectName
                     FROM result r
                     INNER JOIN exam e ON r.ExamID = e.ExamID
                     INNER JOIN subject s ON s.SubjectID = r.ClassID
                     WHERE r.StudentID = :StudentID AND r.ClassID = :ClassID";

    $stmtResults = $pdo->prepare($queryResults);
    $stmtResults->bindParam(':StudentID', $StudentID);
    $stmtResults->bindParam(':ClassID', $ClassID);
    $stmtResults->execute();

    $results = $stmtResults->fetchAll(PDO::FETCH_ASSOC);
    $response = [
        'user' => $user,
        'results' => $results
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}
?>
