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


    if ($password !== $reEnterPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
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
            VALUES ('$userId', '$name', '$dob', '$fatherName', '$motherName', '$guardianContact', '$presentAddress', '$permanentAddress', '$picturePath', '$birthCertificatePath', '$fathersNidPath', '$mothersNidPath', '$hashedPassword', 'user')";

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
