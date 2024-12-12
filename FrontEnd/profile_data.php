<?php
// Include database connection
include('connect_db.php');

// Hardcoded UserID for now. In a real-world scenario, replace with session-based UserID
$UserID = '44444';

try {
    // Fetch user data from the database
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
