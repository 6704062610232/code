<?php
$conn = new mysqli("localhost", "root", "", "cozyhome_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าจากฟอร์ม
$room = "402"; // fix จากหน้า (หรือจะส่งมาก็ได้)
$name = "คุณสมชาย ใจดี";
$category = $_POST['category'];
$detail = $_POST['detail'];

// ===== อัปโหลดรูป =====
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imagePaths = [];

if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = time() . "_" . basename($_FILES['images']['name'][$key]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $imagePaths[] = $targetFile;
        }
    }
}

// เก็บเป็น string
$images = implode(",", $imagePaths);

// ===== insert DB =====
$sql = "INSERT INTO repairs (room, name, category, detail, images)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $room, $name, $category, $detail, $images);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>