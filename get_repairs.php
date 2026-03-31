<?php
include 'db_config.php';

// ดึงข้อมูลเรียงจากใหม่ไปเก่า
$sql = "SELECT * FROM repair_tasks ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// ส่งค่ากลับเป็นรูปแบบ JSON ที่ JavaScript เข้าใจ
echo json_encode($data);

mysqli_close($conn);
?>