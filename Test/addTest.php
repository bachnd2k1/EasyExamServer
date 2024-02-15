<?php
include '../Connect.php';
include 'Test.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['createDate']) && isset($_POST['idCreate']) ) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $createDate = $_POST['createDate'];
        $idCreate = $_POST['idCreate'];

        // Prepare the SQL query with placeholders
        $query = "INSERT INTO test (id, name, createDate,idCreate) VALUES (?, ?, ?,?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters to the prepared statement
            $stmt->bind_param('ssss', $id, $name, $createDate,$idCreate);

            // Execute the query
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

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
