<?php
include 'db_config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action == 'login') {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $u, $p, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        echo json_encode(["status" => "success", "user" => $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"]);
    }
}

if ($action == 'register') {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $role = $_POST['role'];
    $fullname = $_POST['fullname'] ?? '';
    $room = $_POST['room'] ?? '';
    
    // ตรวจสอบว่าชื่อซ้ำไหม
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $u);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "ชื่อผู้ใช้นี้มีในระบบแล้ว"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, room_number, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $u, $p, $fullname, $room, $role);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการลงทะเบียน"]);
    }
}
?>