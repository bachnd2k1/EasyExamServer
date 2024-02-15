<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idRoom']) && isset($_POST['currentNumUser']) && isset($_POST['startTime'])) {
        $idRoom = $_POST['idRoom'];
        $currentNumUser = $_POST['currentNumUser'];
        $startTime = $_POST['startTime'];

        // Prepare the SQL query with placeholders
        $query = "UPDATE Room SET currentNumUser=?, startTime=? WHERE idRoom=?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters to the prepared statement
            $stmt->bind_param('iss', $currentNumUser, $startTime, $idRoom);

            // Execute the query
            if ($stmt->execute()) {
                $response['message'] = "Record updated successfully";
            } else {
                $response['message'] = "Error updating record: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $response['message'] = "Preparation failed: " . htmlspecialchars($conn->error);
        }
    } else {
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['message'] = "Invalid Request";
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
