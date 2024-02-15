<?php
    include '../Connect.php';
    include 'User.php';

    $response = array();
    
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name']) && isset($_POST['password'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            // Prepare a SQL query with a prepared statement
            $query = "SELECT * FROM user WHERE name = ? AND password = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $name, $password);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    $response['success'] = true;
                    $response['message'] = "User found";
                    $response['user'] = $user;
                } else {
                    $response['success'] = false;
                    $response['message'] = "User not found";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Query execution error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Required fields are missing";
        }
     } else {
        $response['success'] = false;
        $response['message'] = "Invalid Request";
    }

// Close the database connection
$conn->close();

// Encode the response array as JSON and send it as the response
header('Content-Type: application/json');
echo json_encode($response);
?>