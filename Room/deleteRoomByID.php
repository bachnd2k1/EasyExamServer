<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $idRoom = $_GET['idRoom'];

    // Prepare the SQL query using a prepared statement
    $query = "DELETE FROM room WHERE idRoom = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $response['message'] = "Prepared statement error: " . $conn->error;
    } else {
        // Bind parameters and execute the query
        $stmt->bind_param("s", $idRoom);
        if ($stmt->execute()) {
            $response['message'] = "done";
        } else {
            $response['message'] = "Execute error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
