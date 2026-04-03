<?php
include 'db_config.php';
header('Content-Type: application/json');

// รับค่าจาก FormData (ต้องสะกดให้ตรงกับ Javascript)
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$image_path = "";

// จัดการรูปภาพ (แปลงเป็น Base64)
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $base64 = base64_encode($imageData);
    $mimeType = $_FILES['image']['type'];
    $image_path = 'data:' . $mimeType . ';base64,' . $base64;
}

if (!empty($title) && !empty($description)) {
    $sql = "INSERT INTO news_posts (title, description, image_path) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $description, $image_path);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบ"]);
}
?>