<?php
include '../Connect.php';
include 'RecordTest.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idStudent = isset($_POST['idStudent']) ? trim($_POST['idStudent']) : null;
 
    if ($idStudent !== null) {
        // $query = "SELECT recordtest.*, room.nameRoom 
        //           FROM recordtest 
        //           LEFT JOIN room ON recordtest.idRoom = room.idRoom 
        //           WHERE recordtest.idStudent = '$idStudent'";

        $query = "SELECT recordtest.*, room.nameRoom, room.isViewed
        FROM recordtest 
        LEFT JOIN room ON recordtest.idRoom = room.idRoom 
        WHERE recordtest.idStudent = '$idStudent'";         
      
        $data = mysqli_query($conn, $query);

        if ($data) {
            $rows = mysqli_fetch_all($data, MYSQLI_ASSOC);

            if (!empty($rows)) {
                $response['message'] = "done";
                $response['data'] = array();

                foreach ($rows as $row) {
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
                        $row['questions'],
                        $row['day'],
                        (int)$row['isViewed']
                    );

                    $response['data'][] = array(
                        'recordTest' => $recordTest,
                        'nameRoom' => $row['nameRoom']
                    );
                }
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
