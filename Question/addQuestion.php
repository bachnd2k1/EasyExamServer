<?php
include '../Connect.php';
include 'Test.php';
include 'Question.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $data = json_decode(file_get_contents("php://input"), true);

    if (is_array($data)) {
        
        $sql = "INSERT INTO question (idQuestion, question, correctNum, idTest, answers, image)
                VALUES (?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                question = VALUES(question),
                correctNum = VALUES(correctNum),
                idTest = VALUES(idTest),
                answers = VALUES(answers),
                image = IF(VALUES(image) IS NOT NULL, VALUES(image), image)";


        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssisss", $idQuestion, $question, $correctNum, $idTest, $answers, $image);
            
            foreach ($data as $questionData) {
                $idQuestion = $questionData['id'];
                $question = $questionData['question'];
                $correctNum = $questionData['correctNum'];
                $idTest = $questionData['idTest'];
                $answers = implode(",", $questionData['answers']);
                $image = $questionData['image'] ?? null; // Use null if 'image' is not present in the incoming data

                $stmt->execute();
            }
            
            $response['error'] = false;
            $response['message'] = "Successfully inserted or updated.";
            $stmt->close();
        } else {
            $response['error'] = true;
            $response['message'] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Invalid data format. Expecting an array of objects.";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
