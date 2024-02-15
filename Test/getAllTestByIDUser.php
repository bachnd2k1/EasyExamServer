<?php
include '../Connect.php';
include 'Test.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if idCreate exists in both POST and GET parameters
    $idCreate = isset($_POST['idCreate']) ? $_POST['idCreate'] : (isset($_GET['idCreate']) ? $_GET['idCreate'] : '');

    if (!empty($idCreate)) {
        // Prepare the SQL query with placeholders
        $query = "SELECT * FROM test WHERE idCreate = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind the parameter to the prepared statement
            $stmt->bind_param('s', $idCreate);

            // Execute the query
            if ($stmt->execute()) {
                // Get the result set from the executed statement
                $result = $stmt->get_result();

                // Fetch the data and add to the response array
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($response, new Test(
                        $row['id'], 
                        $row['name'], 
                        $row['createDate'],
                        $row['idCreate']
                    ));
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
