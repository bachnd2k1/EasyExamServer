<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if (isset($_GET['idRoom'])) {
    $idRoom = $_GET['idRoom'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT currentNumUser FROM room WHERE idRoom = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $idRoom);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $response['currentNumUser'] = $row['currentNumUser'];
        $response['message'] = "done";
    } else {
        $response['message'] = "error";
    }
} else {
    $response['error'] = "Missing idRoom parameter";
}

// Close the connection
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($response);
?>
