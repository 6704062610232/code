<?php
require_once 'db_config.php';

$title = $_POST['title'];
$desc = $_POST['desc'];

$imagePath = "";

// รับไฟล์
if (isset($_FILES['imageFile'])) {
    $fileName = time() . "_" . $_FILES['imageFile']['name'];
    $target = "uploads/" . $fileName;

    move_uploaded_file($_FILES['imageFile']['tmp_name'], $target);
    $imagePath = $target;
}

$stmt = $conn->prepare("INSERT INTO news_posts (title, description, image_path) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $desc, $imagePath);

if ($stmt->execute()) {
    echo "success";
} else {
    echo $stmt->error;
}

$conn->close();
?>