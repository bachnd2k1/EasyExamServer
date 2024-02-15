<?php
include '../Connect.php';
include 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    // Your login logic here
    // Verify email and password against your user table
    $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // User credentials are valid
        $user = $result->fetch_assoc();
        $tokens = generateTokens($user['email'], $user['password'], $user['role'], $user['idClass'], $user['name'], $user['idStudent']);
        $response['success'] = true;
        $response['accessToken'] = $tokens['accessToken'];
        $response['refreshToken'] = $tokens['refreshToken'];
    } else {
        header("HTTP/1.1 401 Unauthorized");
        $response['success'] = false;
        $response['accessToken'] = '';
        $response['refreshToken'] = '';
    }
    echo json_encode($response);
    $conn->close();
}

function generateTokens($email, $password, $role, $idClass, $name,$idStudent) {
    $secretKey = 'key';

    // Access Token
    $accessTokenPayload = array(
        "email" => $email,
        "password" => $password,
        "role" => $role,
        "idClass" => $idClass,
        "name" => $name,
        "idStudent" => $idStudent,
        "exp" => time() + 3600
    );
    $accessToken = jwt_encode($accessTokenPayload, $secretKey);

    // Refresh Token
    $refreshTokenPayload = array(
        "email" => $email,
        "password" => $password,
        "role" => $role,
        "idClass" => $idClass,
        "name" => $name,
        "idStudent" => $idStudent,
        "exp" => time() + (3 * 30 * 24 * 60 * 60) // 3 months validity
    );
    $refreshToken = jwt_encode($refreshTokenPayload, $secretKey);

    return array(
        "accessToken" => $accessToken,
        "refreshToken" => $refreshToken
    );
}

function jwt_encode($payload, $key) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $header = base64UrlEncode($header);
    $payload = base64UrlEncode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload", $key, true);
    $signature = base64UrlEncode($signature);

    return "$header.$payload.$signature";
}

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
?>
