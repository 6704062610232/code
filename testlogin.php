<?php
require_once 'db_config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode([
        "status" => "success",
        "role" => $user['role'],
        "name" => $user['username']
    ]);
} else {
    echo json_encode(["status" => "fail"]);
}

$conn->close();
?>