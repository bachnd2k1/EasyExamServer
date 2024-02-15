<?php
include '../Connect.php';
include 'RecordTest.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRoom = isset($_POST['idRoom']) ? trim($_POST['idRoom']) : null;

    if ($idRoom !== null) {
        $query = "SELECT * FROM recordtest WHERE idRoom = '$idRoom'";
        $data = mysqli_query($conn, $query);

        if ($data) {
            $response['message'] = "done";
            $response['data'] = array();

            while ($row = mysqli_fetch_assoc($data)) {
                $recordTest = new RecordTest(
                    $row['idRoom'],
                    $row['idQuestion'],
                    $row['idStudent'],
                    $row['nameStudent'],
                    $row['point'],
                    $row['time'],
                    $row['correctQuestion'],
                    $row['currentQuestion'],
                    $row['answer'],
                    $row['state'],
                    $row['day']
                );

                // Fetch questions for this test
                $questions = array();
                $idQuestion = $row['idQuestion'];

                $questionsQuery = "SELECT * FROM question WHERE idTest = '$idQuestion'";
                $questionsData = mysqli_query($conn, $questionsQuery);

                while ($questionRow = mysqli_fetch_assoc($questionsData)) {
                    $question = array(
                        "id" => $questionRow['idQuestion'],
                        "question" => $questionRow['question'],
                        "answers" => explode(",", $questionRow['answers']),
                        "correctNum" => $questionRow['correctNum']
                    );
                    $questions[] = $question;
                }

                $recordTest->questions = $questions;
                $response['data'][] = $recordTest;
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Error executing query: " . mysqli_error($conn);
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
