<?php
include '../Connect.php';
include '../Room/Room.php';
include 'Test.php';
include 'Question.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if idCreate exists in both POST and GET parameters
    $idTest = isset($_POST['idTest']) ? $_POST['idTest'] : (isset($_GET['idTest']) ? $_GET['idTest'] : '');
    $idRoom = isset($_POST['idRoom']) ? $_POST['idRoom'] : (isset($_GET['idRoom']) ? $_GET['idRoom'] : '');
    
    if (!empty($idTest) && !empty($idRoom)) {
        // Prepare the SQL query with JOIN and WHERE clauses
        $query = "SELECT *
                  FROM question q
                  INNER JOIN test t ON q.idTest = t.id
                  INNER JOIN room r ON t.id = r.idTest
                  WHERE r.idRoom = ? AND t.id = ?";

        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind the parameters to the prepared statement
            $stmt->bind_param('ss', $idRoom, $idTest);

            // Execute the query
            if ($stmt->execute()) {
                // Get the result set from the executed statement
                $result = $stmt->get_result();

                // Create an array to hold the questions
                $questions = array();

                // Fetch the data and add to the questions array
                while ($row = mysqli_fetch_assoc($result)) {
                    // Convert comma-separated string to array and shuffle
                    $answers_array = explode(",", $row['answers']);
                    $value = $answers_array[$row['correctNum']];
                    // shuffle($answers_array);

                  
                
                    // Find the correct answer in the shuffled array
                    // $correct_answer = $answers_array[$row['correctNum']];
                
                    // Build a new array with correct order and index
                    $shuffled_answers = array_map(function ($index) use ($answers_array) {
                         return $answers_array[$index];
                    }, array_keys($answers_array));
                
                    // Find the new index of the correct answer in the shuffled array
                    $index = array_search($value, $shuffled_answers);
                    //$correct_answer_index = array_search($correct_answer, $shuffled_answers);
                
                    // Add shuffled data to the questions array
                    $question = array(
                        "id" => $row['idQuestion'],
                        "question" => $row['question'],
                        "answers" => $shuffled_answers,
                        "correctNum" => $index,
                        "idTest" => $row['idTest'],
                        "image" => $row['image']
                    );
                
                    array_push($questions, $question);
                }
                
                // Shuffle the order of questions
                shuffle($questions);
                
                // Create the response array
                $response = array(
                    "message" => "done",
                    "questions" => $questions
                );

            } else {
                $response['message'] = "error: " . htmlspecialchars($stmt->error);
            }
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

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
