<?php
include 'db_config.php';
header('Content-Type: application/json');

// ปรับ Query ให้ตรงกับชื่อคอลัมน์ใหม่ (id) และชื่อผู้เช่า (tenant_name)
$sql = "SELECT r.id, r.floor, t.tenant_name, t.contract_id, t.start_date, t.contract_months, t.img_url 
        FROM rooms r 
        LEFT JOIN tenants t ON r.id = t.room_id 
        ORDER BY r.id ASC";

$result = $conn->query($sql);
$rooms = [];

if ($result) {
    while($row = $result->fetch_assoc()) {
        $room_id = $row['id'];
        if (!isset($rooms[$room_id])) {
            $rooms[$room_id] = [
                'id' => $room_id,
                'floor' => $row['floor'],
                'tenants' => []
            ];
        }
        if ($row['tenant_name']) {
            $rooms[$room_id]['tenants'][] = [
                'name' => $row['tenant_name'],
                'contractId' => $row['contract_id'],
                'startDate' => $row['start_date'],
                'contractMonths' => $row['contract_months'],
                'img' => $row['img_url']
            ];
        }
    }
}

echo json_encode(array_values($rooms));
?>