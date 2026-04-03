<?php
$conn = new mysqli("localhost", "root", "", "cozyhome_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room = "402";
$name = "คุณสมชาย ใจดี";

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    foreach ($data as $item) {
        $courier = $item['courier'];
        $tracking = $item['tracking'];

        $stmt = $conn->prepare("INSERT INTO parcels (room, name, courier, tracking) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $room, $name, $courier, $tracking);
        $stmt->execute();
    }
    echo "success";
} else {
    echo "no_data";
}

$conn->close();
?>