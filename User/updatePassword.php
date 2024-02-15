<?php
include '../Connect.php';
include 'User.php';

$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $userId = $_POST['userId'];

    // Use a prepared statement to avoid SQL injection
    $sql = "SELECT password FROM user WHERE idStudent = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Print the SQL query and the error
        echo "Error preparing statement: " . $conn->error;
        exit; // Terminate the script
    }

    // Bind parameters
    $stmt->bind_param("s", $userId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Check if the new password is equal to the current password
        if ($newPassword === $storedPassword) {
            $response['message'] = "New password is the same as the current password";
        } else {
            // Check if the current password matches
            if ($currentPassword === $storedPassword) {
                // Update the password
                $updateSql = "UPDATE user SET password = ? WHERE idStudent = ?";
                $updateStmt = $conn->prepare($updateSql);

                if ($updateStmt === false) {
                    $response['message'] = "Error preparing update statement: " . $conn->error;
                } else {
                    // Bind parameters for the update statement
                    $updateStmt->bind_param("ss", $newPassword, $userId);

                    // Execute the update statement
                    if ($updateStmt->execute()) {
                        $response['message'] = "Update password successfully";
                    } else {
                        $response['message'] = "Error updating password: " . $conn->error;
                    }

                    // Close the update statement
                    $updateStmt->close();
                }
            } else {
                $response['message'] = "Incorrect current password";
            }
        }
    } else {
        $response['message'] = "User not found";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
