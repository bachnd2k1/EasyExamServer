<?php
include '../Connect.php';
include 'RecordTest.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRoom = isset($_POST['idRoom']) ? trim($_POST['idRoom']) : null;
    $idStudent = isset($_POST['idStudent']) ? trim($_POST['idStudent']) : null;
 
    if ($idRoom !== null) {
        $query = "SELECT * FROM recordtest WHERE idRoom = '$idRoom' and  idStudent = '$idStudent' ";
      
        $data = mysqli_query($conn, $query);

        if ($data) {
            $row = mysqli_fetch_assoc($data);

            if ($row) {
                $response['message'] = "done";
                $response['data'] = new RecordTest(
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
                    $row['questions'],
                    $row['day'],
                    0
                ); 
            } else {
                $response['error'] = true;
                $response['message'] = "No records found";
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
