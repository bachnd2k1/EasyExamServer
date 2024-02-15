<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRoom = isset($_POST['idRoom']) ? $_POST['idRoom'] : '';

    error_log('Received idRoom: ' . $idRoom); 

    //if (!empty($idRoom)) {
        $query = "SELECT * FROM room WHERE idRoom = ? and state <> 'Finished'";
        error_log('SQL Query: ' . $query); 
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $idRoom);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                error_log('Number of rows returned: ' . $result->num_rows); 

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $roomData = new Room(
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
                    
                    $response['data'] = $roomData;
                    $response['message'] = "done";
                } else {
                    $response['error'] = true;
                    $response['message'] = "Room not found";
                }
            } else {
                $response['error'] = true;
                $response['message'] = "Error: " . htmlspecialchars($stmt->error);
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Preparation failed: " . htmlspecialchars($conn->error);
        }
    //} else {
      //  $response['error'] = true;
        //$response['message'] = "Required fields are missing";
    //}
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
