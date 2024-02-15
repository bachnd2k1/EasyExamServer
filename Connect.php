<?php
$conn = mysqli_connect("localhost", "root", "", "exam1");

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
