<?php
include '../Connect.php';
include 'Test.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['createDate'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $createDate = $_POST['createDate'];
     

        // Prepare the SQL query with placeholders
        $query = "UPDATE test SET name=?, createDate=? WHERE id=?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters to the prepared statement
            $stmt->bind_param('sss', $name, $createDate, $id);

            // Execute the query
            if ($stmt->execute()) {
                $response['message'] = "done";
            } else {
                $response['message'] = "error: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $response['message'] = "Preparation failed: " . htmlspecialchars($conn->error);
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
