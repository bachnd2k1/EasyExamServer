<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idRoom']) ) {
       $idRoom = $_POST['idRoom'];

    // Fetch the current value of numOfUser for the room
    $query = "SELECT numOfUser FROM room WHERE idRoom = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $idRoom);
        $stmt->execute();
        $stmt->bind_result($currentNumOfUser);
        $stmt->fetch();
        $stmt->close();

        // Increment the current value of numOfUser by 1
        $newNumOfUser = $currentNumOfUser + 1;

        // Update the numOfUser value in the database for the specified room
        $updateQuery = "UPDATE room SET numOfUser = ? WHERE idRoom = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("is", $newNumOfUser, $idRoom)


        if ($stmt->execute()) {
            // Successfully updated the numOfUser value
            $response['message'] = "User joined the room";
        } else {
            $response['message'] = "Error updating the numOfUser value";
        }
        $stmt->close();


        // if (!$stmt) {
        //     $response['message'] = "Prepared statement error: " . $conn->error;
        // } else {
        //     // Bind parameters and execute the query
        //     $stmt->bind_param("ssisss", $idRoom, $nameRoom, $numOfUser, $time, $idTest, $idCreateUser);

        //     if ($stmt->execute()) {
        //         $response['message'] = "done";
        //     } else {
        //         $response['message'] = "Execute error: " . $stmt->error;
        //     }
        //     $stmt->close();
        // }
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
