<?php
include 'db_config.php';

// ดึงข้อมูลโพสต์เรียงจากใหม่ไปเก่า
$sql = "SELECT * FROM news_posts ORDER BY created_at DESC";
$result = $conn->query($sql);
$posts = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($posts);
?>