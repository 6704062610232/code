<?php
include 'db_config.php';

header('Content-Type: application/json; charset=utf-8');

// เช็คการเชื่อมต่อ
if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// ดึงข้อมูล
$sql = "SELECT * FROM meters ORDER BY room_no ASC";
$result = mysqli_query($conn, $sql);

$data = array();

if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row['room_no'],
            'floor' => (int)$row['floor'],
            'oldW' => (int)$row['old_water'],
            'oldE' => (int)$row['old_elec'],
            'newW' => isset($row['new_water']) ? (int)$row['new_water'] : 0,
            'newE' => isset($row['new_elec']) ? (int)$row['new_elec'] : 0
        );
    }
}

// ส่ง JSON กลับ
echo json_encode($data, JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
?>