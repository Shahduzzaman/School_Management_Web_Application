<?php
// Include the database connection file
include 'connect_db.php';

// Initialize response array
$response = [
    'status' => '',
    'message' => '',
    'user_name' => ''
];

// Check if the form is submitted for a search
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $userId = $_POST['userId'];

        // Search for the user
        if ($action === 'search' && !empty($userId)) {
            try {
                $stmt = $pdo->prepare("SELECT name FROM user WHERE UserID = :id");
                $stmt->execute(['id' => $userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $response['status'] = 'success';
                    $response['user_name'] = $user['name'];
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'User not found.';
                }
            } catch (PDOException $e) {
                $response['status'] = 'error';
                $response['message'] = 'Database error: ' . $e->getMessage();
            }
        }

        // Delete the user
        if ($action === 'delete' && !empty($userId)) {
            try {
                $stmt = $pdo->prepare("DELETE FROM user WHERE UserID = :id");
                $stmt->execute(['id' => $userId]);

                if ($stmt->rowCount() > 0) {
                    $response['status'] = 'success';
                    $response['message'] = 'User deleted successfully.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'User not found or already deleted.';
                }
            } catch (PDOException $e) {
                $response['status'] = 'error';
                $response['message'] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
