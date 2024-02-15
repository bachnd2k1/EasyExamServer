<?php
include '../Connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $refreshToken = $_POST['token'];

    // $decodedToken = refreshToken($accessToken);

    $conn->close();
}


// public static function refreshToken($refreshToken)
// {
//     $decodedRefreshToken = self::decodeRefreshToken($refreshToken);

//     if ($decodedRefreshToken) {
//         // Extract data from refresh token and generate a new access token
//         $data = $decodedRefreshToken['data'];
//         $newToken = self::generateToken($data);

//         return $newToken;
//     }

//     return null;
// }
