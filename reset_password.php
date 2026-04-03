<?php
require_once 'db_config.php';

$username = $_POST['username'];
$room = $_POST['room'];
$newpass = password_hash($_POST['newpass'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && ($user['role'] === 'ADMIN' || $user['room'] === $room)) {
    $up = $conn->prepare("UPDATE users SET password=? WHERE username=?");
    $up->bind_param("ss", $newpass, $username);
    $up->execute();
    echo "success";
} else {
    echo "fail";
}
?>