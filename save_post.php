<?php
include 'db_config.php';

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$image_path = '';

// ถ้ามีการอัปโหลดรูป
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $file_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    }
}

$sql = "INSERT INTO news_posts (title, description, image_path) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $description, $image_path);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>