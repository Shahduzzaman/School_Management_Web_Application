<?php
include('connect_db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $userId = $_POST['userId'];
    $dob = $_POST['dob'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $guardianContact = $_POST['guardianContact'];
    $presentAddress = $_POST['presentAddress'];
    $permanentAddress = $_POST['permanentAddress'];
    $password = $_POST['password'];
    $reEnterPassword = $_POST['reEnterPassword'];
    $role = $_POST['role'];

    if ($password !== $reEnterPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }
    
    if ($role === "Admin" && ($userId < 1 || $userId > 9)) {
        echo "<script>alert('Invalid UserId for Admin. It must be between 1 and 9.'); window.history.back();</script>";
        exit;
    } elseif ($role === "Accountant" && ($userId < 11 || $userId > 20)) {
        echo "<script>alert('Invalid UserId for Accountant. It must be between 11 and 20.'); window.history.back();</script>";
        exit;
    } elseif ($role === "Moderator" && ($userId < 21 || $userId > 40)) {
        echo "<script>alert('Invalid UserId for Moderator. It must be between 21 and 40.'); window.history.back();</script>";
        exit;
    } elseif ($role === "Teacher" && strlen((string)$userId) !== 3) {
        echo "<script>alert('Invalid UserId for Teacher. It must be 3 digits long.'); window.history.back();</script>";
        exit;
    } elseif ($role === "Student" && strlen((string)$userId) !== 5) {
        echo "<script>alert('Invalid UserId for Student. It must be 5 digits long.'); window.history.back();</script>";
        exit;
    }

    $picture = $_FILES['picture'];
    $birthCertificate = $_FILES['birthCertificate'];
    $fathersNid = $_FILES['fathersNid'];
    $mothersNid = $_FILES['mothersNid'];


    $uploadDir = './uploads';

    $picturePath = $uploadDir . basename($picture['name']);
    $birthCertificatePath = $uploadDir . basename($birthCertificate['name']);
    $fathersNidPath = $uploadDir . basename($fathersNid['name']);
    $mothersNidPath = $uploadDir . basename($mothersNid['name']);


    move_uploaded_file($picture['tmp_name'], $picturePath);
    move_uploaded_file($birthCertificate['tmp_name'], $birthCertificatePath);
    move_uploaded_file($fathersNid['tmp_name'], $fathersNidPath);
    move_uploaded_file($mothersNid['tmp_name'], $mothersNidPath);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `user` (`UserID`, `Name`, `DateOfBirth`, `FatherName`, `MotherName`, `GuardianPhoneNumber`, `PresentAddress`, `PermanentAddress`, `Picture`, `Birth Certificate`, `Father's NID`, `Mother's NID`, `Password`, `Role`) 
            VALUES ('$userId', '$name', '$dob', '$fatherName', '$motherName', '$guardianContact', '$presentAddress', '$permanentAddress', '$picturePath', '$birthCertificatePath', '$fathersNidPath', '$mothersNidPath', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created successfully!');</script>";
        header("Location: adminDashboard.php"); 
        exit; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    $conn->close();
}
?>
