<?php
include '../Connect.php';
include '../Room/Room.php';
include 'Test.php';
include 'Question.php';


$query = "SELECT idQuestion, idTest, question, answers FROM question";
$result = $conn->query($query);

// Array to store shuffled data
$shuffledData = array();

// Process each question
while ($row = $result->fetch_assoc()) {
    $question_id = $row['idQuestion'];
    $test_id = $row['idTest'];
    $question_text = $row['question'];
    $answers_str = $row['answers'];

    // Convert answers string to an array
    $answers_array = explode(',', $answers_str);

    // Shuffle the answers
    shuffle($answers_array);

    // Calculate the new correctNum based on the shuffled order of answers
    $correct_answer_index = array_search('1', $answers_array);
    $correct_num = ($correct_answer_index !== false) ? $correct_answer_index  : 0;

    // Add question data to the array
    $shuffledData[] = array(
        'id' => $question_id,
        'question' => $question_text,
        'answers' => $answers_array,
        'correctNum' => $correct_num,
        'idTest' => $test_id
    );
}

// Shuffle the order of questions
shuffle($shuffledData);

// Close the connection
$conn->close();

// Return the shuffled data as JSON with the desired structure
$response = array(
    'message' => 'done',
    'questions' => $shuffledData
);

header('Content-Type: application/json');
echo json_encode($response);
?>
