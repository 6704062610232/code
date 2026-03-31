<?php
include 'db_config.php';

// ดึงข้อมูลมิเตอร์เรียงตามเลขห้อง
$sql = "SELECT * FROM meters ORDER BY room_no ASC";
$result = mysqli_query($conn, $sql);

$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id' => $row['room_no'],
        'floor' => $row['floor'],
        'oldW' => $row['old_water'],
        'oldE' => $row['old_elec'],
        'newW' => $row['new_water'],
        'newE' => $row['new_elec']
    );
}

echo json_encode($data);
mysqli_close($conn);
?>