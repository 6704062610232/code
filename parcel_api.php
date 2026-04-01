<?php
include 'db_config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

// 1. ดึงข้อมูลพัสดุทั้งหมด
if ($action == 'fetch') {
    $sql = "SELECT * FROM parcels ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

// 2. บันทึกพัสดุใหม่
if ($action == 'save') {
    $room = $_POST['room'];
    $carrier = $_POST['carrier'];
    $name = $_POST['name'];
    $img = $_POST['img']; // รับเป็น Base64 จากหน้าเว็บ

    $sql = "INSERT INTO parcels (room, carrier, receiver_name, image_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $room, $carrier, $name, $img);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// 3. อัปเดตสถานะพัสดุ (รับแล้ว)
if ($action == 'update_status') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE parcels SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    }
}
?>