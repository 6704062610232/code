error_reporting(E_ALL);
ini_set('display_errors', 1);
<?php
include 'db_config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);
    $cycle = date("Y-m");

    if (!isset($input['data'])) {
        echo json_encode(["status" => "error", "message" => "No data"]);
        exit;
    }

    foreach ($input['data'] as $row) {

        $room = $row['room'];
        $water = (int)$row['water'];
        $electric = (int)$row['electric'];

        // 🔥 ตรวจว่ามีข้อมูลเดือนนี้หรือยัง
        $check = $conn->prepare("
            SELECT id FROM meters 
            WHERE room_no = ? AND cycle = ?
        ");
        $check->bind_param("ss", $room, $cycle);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            // ✅ UPDATE
            $stmt = $conn->prepare("
                UPDATE meters 
                SET new_water = ?, new_elec = ?, cycle = ?
                WHERE room_no = ?
            ");
            $stmt->bind_param("iiss", $water, $electric, $cycle, $room);

        } else {

            // ✅ INSERT
            $stmt = $conn->prepare("
                INSERT INTO meters (room_no, new_water, new_elec, cycle)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("siis", $room, $water, $electric, $cycle);
        }

        $stmt->execute();
    }

    echo json_encode(["status" => "success"]);
}

mysqli_close($conn);
?>