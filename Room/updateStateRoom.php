<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idRoom = isset($_POST['idRoom']) ? $_POST['idRoom'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';

    if (!empty($idRoom) && !empty($state)) {
    // Update the room state in your database
        $sql = "UPDATE room SET state = '$state' WHERE idRoom = '$idRoom'";
        if (mysqli_query($conn, $sql)) {
            $response = array("success" => true, "message" => "Room state updated successfully");
        } else {
            $response = array("success" => false, "message" => "Error updating room state: " . mysqli_error($conn));
        }
    }
    else {
        $response = array("success" => false, "message" => "Miss field");
    }

} else {
    $response = array("success" => false, "message" => "Invalid request method");
  
}
 echo json_encode($response);
?>


