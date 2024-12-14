<?php
// Include the database connection file
include 'connect_db.php';

// Initialize response array
$response = [
    'status' => '',
    'message' => ''
];

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $subjectId = isset($_POST['subjectId']) ? trim($_POST['subjectId']) : '';
    $subjectName = isset($_POST['subjectName']) ? trim($_POST['subjectName']) : '';

    // Validate the input fields
    if (empty($subjectId) || empty($subjectName)) {
        $response['status'] = 'error';
        $response['message'] = 'Both Subject ID and Subject Name are required.';
    } else {
        try {
            // Prepare the SQL statement for insertion
            $stmt = $pdo->prepare("INSERT INTO `subject`(`SubjectID`, `SubjectName`) VALUES (:subjectId, :subjectName)");
            
            // Bind parameters
            $stmt->bindParam(':subjectId', $subjectId);
            $stmt->bindParam(':subjectName', $subjectName);

            // Execute the query
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

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
