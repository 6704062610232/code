<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $floor = $_POST['floor'];
    $room_num = $_POST['room_number'];

    $room_id = $floor . $room_num;

    $sql = "INSERT INTO rooms (id, floor, status) VALUES ('$room_id', '$floor', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo $conn->error;
    }
}

$conn->close();
?>