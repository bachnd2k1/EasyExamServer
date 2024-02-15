<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCreateUser = isset($_POST['idCreateUser']) ? $_POST['idCreateUser'] : '';

    error_log('Received idCreateUser: ' . $idCreateUser);

    $query = "SELECT * FROM room WHERE state = 'Finished' AND idCreateUser = ?";
    error_log('SQL Query: ' . $query);
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $idCreateUser);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            error_log('Number of rows returned: ' . $result->num_rows);

            if ($result->num_rows > 0) {
                $roomData = array();
                while ($row = $result->fetch_assoc()) {
                    error_log('Constructing Room object with values: ' . $row['idRoom'] . ', ' . $row['nameRoom'] . ', ...');

                    $roomData[] = new Room(
                        $row['idRoom'],
                        $row['nameRoom'],
                        $row['idTest'],
                        $row['idCreateUser'],
                        $row['numOfUser'],
                        $row['time'],
                        $row['currentNumUser'],
                        $row['state'],
                        $row['createTime'],
                        $row['isViewed'],
                        $row['startTime']
                    );
                }
                $response['data'] = $roomData;
                $response['message'] = "done";
            } else {
                $response['error'] = true;
                $response['message'] = "No rooms found for the specified idCreateUser";
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Error: " . htmlspecialchars($stmt->error);
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Preparation failed: " . htmlspecialchars($conn->error);
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// Close the connection
$conn->close();
// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
