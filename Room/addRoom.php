<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');

    // Decode the JSON data to a PHP associative array
    $data = json_decode($json_data, true);

    // Check if all required fields are present
    if (isset($data['idRoom']) && isset($data['nameRoom']) && isset($data['numOfUser']) && isset($data['time']) && isset($data['idTest']) && isset($data['idCreateUser'])) {
        // Extract data from the decoded array
        $idRoom = $data['idRoom'];
        $nameRoom = $data['nameRoom'];
        $numOfUser = $data['numOfUser'];
        $time = $data['time'];
        $idTest = $data['idTest'];
        $idCreateUser = $data['idCreateUser'];
        $state = "Waiting";
        $createTime = $data['createTime'];
        // Prepare the SQL query using a prepared statement
        $query = "INSERT INTO room (idRoom, nameRoom, numOfUser, time, idTest, idCreateUser, state,createTime) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            $response['message'] = "Prepared statement error: " . $conn->error;
        } else {
            // Bind parameters and execute the query
             $stmt->bind_param("ssisssss", $idRoom, $nameRoom, $numOfUser, $time, $idTest, $idCreateUser, $state,$createTime);
            if ($stmt->execute()) {
                $response['message'] = "done";
            } else {
                $response['message'] = "Execute error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request"; 
}

echo json_encode($response);
?>
