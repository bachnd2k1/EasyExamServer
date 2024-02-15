<?php
include '../Connect.php';
include 'RecordTest.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRoom = isset($_POST['idRoom']) ? $_POST['idRoom'] : null;
    $idQuestion = isset($_POST['idQuestion']) ? $_POST['idQuestion'] : null;
    $idStudent = isset($_POST['idStudent']) ? $_POST['idStudent'] : null;
    $nameStudent = isset($_POST['nameStudent']) ? $_POST['nameStudent'] : null;
    $currentQuestion = isset($_POST['currentQuestion']) ? $_POST['currentQuestion'] : null;
    $answer = isset($_POST['answer']) ? $_POST['answer'] : null;

    // Convert the PHP array to a JSON string
    // $answer = json_encode($answerArray);

    if ($idRoom !== null && $idQuestion !== null && $idStudent !== null && $nameStudent !== null && $currentQuestion !== null) {
        
        // Get the current date in the format dd/mm/yyyy
        $currentDay = date('d-m-Y');

        // Pass null as the questions parameter when constructing RecordTest
        // function __construct($idRoom, $idQuestion, $idStudent, $nameStudent, $point, $time, $correctQuestion, $currentQuestion, $answer, $state, $questions, $day,$isViewed)
        $recordTest = new RecordTest($idRoom, $idQuestion, $idStudent, $nameStudent, 0, 0, 0, $currentQuestion, $answer, "N/A", "Waiting", $currentDay, 0);

        $query = "INSERT INTO recordtest (idRoom, idQuestion, idStudent, nameStudent, currentQuestion, answer, day)
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters including the current date
            $stmt->bind_param('sssssss', $idRoom, $idQuestion, $idStudent, $nameStudent, $currentQuestion, $answer, $currentDay);

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
