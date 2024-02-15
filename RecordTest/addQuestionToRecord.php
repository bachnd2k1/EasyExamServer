<?php
include '../Connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRoom = isset($_POST['idRoom']) ? $_POST['idRoom'] : null;
    $idStudent = isset($_POST['idStudent']) ? $_POST['idStudent'] : null;
    $updatedQuestions = isset($_POST['questions']) ? $_POST['questions'] : null;
    if ($idRoom !== null && $idStudent !== null && $updatedQuestions !== null) {

        $query = "UPDATE recordtest SET questions = ? WHERE idRoom = ? AND idStudent = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param('sss', $updatedQuestions, $idRoom, $idStudent);

            if ($stmt->execute()) {
                $response['message'] = "done";
            } else {
                $response['message'] = "error: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $response['message'] = "Preparation failed: " . htmlspecialchars($conn->error);
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

header('Content-Type: application/json');
echo json_encode($response);
?>