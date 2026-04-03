<?php
require_once 'db_config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$room = $_POST['room'] ?? "";
$email = $_POST['email'] ?? "";
$phone = $_POST['phone'] ?? "";
$line = $_POST['line'] ?? "";
$image = $_POST['image'] ?? "";

// hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// check ซ้ำ
$check = $conn->prepare("SELECT id FROM users WHERE username=?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "duplicate";
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (username, password, role, room, image, email, phone, line) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $username, $hash, $role, $room, $image, $email, $phone, $line);

if ($stmt->execute()) {
    echo "success";
} else {
    echo $stmt->error;
}

$conn->close();
?>