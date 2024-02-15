<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if (isset($_POST['idRoom']) && isset($_POST['isViewed'])) {
    $idRoom = $_POST['idRoom'];
    $isViewed = $_POST['isViewed'];

    // Convert the boolean value to 0 or 1 for tinyint(1)
    $isViewed = ($isViewed) ? 1 : 0;

    // Use prepared statement to prevent SQL injection
    $query = "UPDATE room SET isViewed = ? WHERE idRoom = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $isViewed, $idRoom);

    if (mysqli_stmt_execute($stmt)) {
        $response['message'] = "done";
    } else {
        $response['message'] = "error";
    }
} else {
    $response['error'] = "Missing idRoom or isViewed parameter";
}

// Close the connection
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($response);
?>
