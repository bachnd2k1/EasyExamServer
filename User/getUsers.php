<?php
    include '../Connect.php';
    include 'User.php';

    $response = array();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Prepare an SQL query to fetch all users
        $query = "SELECT * FROM user";
        $result = $conn->query($query);
        if ($result) {
            $users = array(); // Initialize an array to hold user data
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            $response['success'] = true;
            $response['message'] = "Users found";
            $response['users'] = $users;
        } else {
            $response['success'] = false;
            $response['message'] = "Query execution error: " . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Invalid Request";
    }

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>