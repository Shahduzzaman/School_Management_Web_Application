<?php
include('connect_db.php');

session_start();
if (!isset($_SESSION['UserID'])) {
    echo "Please log in to view your profile.";
    exit();
}

$UserID = $_SESSION['UserID'];

try {
    $query = "SELECT `UserID`, `Name`, `DateOfBirth`, `FatherName`, `MotherName`, `GuardianPhoneNumber`, 
                     `PresentAddress`, `PermanentAddress`, `Picture` 
              FROM `user` 
              WHERE `UserID` = :UserID";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':UserID', $UserID);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching user data: " . $e->getMessage();
    exit();
}
?>
