<?php
include 'db_config.php';
header('Content-Type: application/json');

// ดึงข้อมูลเรียงจากใหม่ไปเก่า (ล่าสุดอยู่บน)
$sql = "SELECT * FROM news_posts ORDER BY created_at DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>