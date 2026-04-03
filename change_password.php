<?php
require_once 'db_config.php';

$username = $_POST['username'];
$old = $_POST['oldpass'];
$new = password_hash($_POST['newpass'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($old, $user['password'])) {
    $up = $conn->prepare("UPDATE users SET password=? WHERE username=?");
    $up->bind_param("ss", $new, $username);
    $up->execute();
    echo "success";
} else {
    echo "fail";
}
?>