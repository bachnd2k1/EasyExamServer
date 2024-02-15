<?php
include '../Connect.php';
include 'Test.php';
include 'Question.php';

$response = array('questions' => array()); // Initialize 'data' key as an empty array

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if idCreate exists in both POST and GET parameters
    $idTest = isset($_POST['idTest']) ? $_POST['idTest'] : (isset($_GET['idTest']) ? $_GET['idTest'] : '');

    if (!empty($idTest)) {
        // Prepare the SQL query with placeholders
        $query = "SELECT * FROM question WHERE idTest = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind the parameter to the prepared statement
            $stmt->bind_param('s', $idTest);

            // Execute the query
            if ($stmt->execute()) {
                // Get the result set from the executed statement
                $result = $stmt->get_result();

                // Fetch the data and add to the response array
                while ($row = mysqli_fetch_assoc($result)) {
                    $questionData = array(
                        'id' => $row['idQuestion'],
                        'question' => $row['question'],
                        'correctNum' => $row['correctNum'],
                        'idTest' => $row['idTest'],
                        'answers' => explode(',', $row['answers']),
                        "image" => $row['image']
                    );
                    array_push($response['questions'], $questionData);
                }

                // Close the statement
                $stmt->close();

                $response['message'] = "done";
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
