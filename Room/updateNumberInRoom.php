<?php
include '../Connect.php';
include 'Room.php';

$response = array();

if (isset($_GET['idRoom'])) {
    $idRoom = $_GET['idRoom'];

    // Use a prepared statement to retrieve the currentNumUser
    $selectQuery = "SELECT currentNumUser FROM room WHERE idRoom = ?";
    $stmtSelect = mysqli_prepare($conn, $selectQuery);
    mysqli_stmt_bind_param($stmtSelect, "s", $idRoom);
    mysqli_stmt_execute($stmtSelect);
    $resultSelect = mysqli_stmt_get_result($stmtSelect);

    if ($resultSelect) {
        $row = mysqli_fetch_assoc($resultSelect);
        $currentNumUser = $row['currentNumUser'];

        // Increment the currentNumUser by 1
        $updatedNumUser = $currentNumUser + 1;

        // Use another prepared statement to update the currentNumUser
        $updateQuery = "UPDATE room SET currentNumUser = ? WHERE idRoom = ?";
        $stmtUpdate = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmtUpdate, "ss", $updatedNumUser, $idRoom);

        if (mysqli_stmt_execute($stmtUpdate)) {
            $response['currentNumUser'] = $updatedNumUser;
            $response['message'] = "done";
        } else {
            $response['message'] = "Error updating currentNumUser";
        }
    } else {
        $response['message'] = "Error fetching currentNumUser";
    }
} else {
    $response['error'] = "Missing idRoom parameter";
}

// Close the connection
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($response);
?>
