<?php
include '../Connect.php';
include 'RecordTest.php';

// Read the raw input
$input = file_get_contents('php://input');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($input)) {
    // Decode the JSON data
    $data = json_decode($input, true);

    // Extract values from the JSON data
    $idRoom = isset($data['idRoom']) ? $data['idRoom'] : null;
    $idQuestion = isset($data['idQuestion']) ? $data['idQuestion'] : null;
    $idStudent = isset($data['idStudent']) ? $data['idStudent'] : null;
    $nameStudent = isset($data['nameStudent']) ? $data['nameStudent'] : null;
    $state = isset($data['state']) ? $data['state'] : null;
    $answer = isset($data['answer']) ? $data['answer'] : null;
    $point = isset($data['point']) ? $data['point'] : null;
    $time = isset($data['time']) ? $data['time'] : null;
    $correctQuestion = isset($data['correctQuestion']) ? $data['correctQuestion'] : null;
    $currentQuestion = isset($data['currentQuestion']) ? $data['currentQuestion'] : null;



    if ($idRoom && $idQuestion && $idStudent && $nameStudent && $currentQuestion) {
     
        $query = "UPDATE recordtest 
        SET nameStudent = ?, currentQuestion = ?, state = ?, answer = ?, point = ?, time = ?, correctQuestion = ?
        WHERE idRoom = ? AND idQuestion = ? AND idStudent = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssssssss', $nameStudent, $currentQuestion, $state, $answer, $point, $time, $correctQuestion, $idRoom, $idQuestion, $idStudent);


            if ($stmt->execute()) {
                $response['message'] = "Record updated successfully";
            } else {
                $response['message'] = "Error updating record: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
        } else {
            $response['message'] = "Preparation failed: " . htmlspecialchars($conn->error);
        }
    } 
    else {
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
