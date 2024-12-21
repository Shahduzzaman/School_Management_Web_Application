<?php
include('connect_db.php');

if (!isset($_GET['UserID'])) {
    http_response_code(400); // Bad Request
    echo "User ID is required.";
    exit();
}

$UserID = (int)$_GET['UserID'];

try {
    // Fetch image data from the database
    $query = "SELECT `Picture` FROM `user` WHERE `UserID` = :UserID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':UserID', $UserID);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['Picture'])) {
        // Verify and serve only JPEG/JPG images
        $imageData = $user['Picture'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($imageData);

        if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
            header("Content-Type: image/jpeg");
            echo $imageData;
        } else {
            // Serve a default image if the MIME type is invalid
            header("Content-Type: image/jpeg");
            readfile('path/to/default-profile.jpg');
        }
    } else {
        // Serve a default image if no picture exists
        header("Content-Type: image/jpeg");
        readfile('path/to/default-profile.jpg');
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo "Error fetching image: " . $e->getMessage();
}
?>
