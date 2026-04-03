<?php
$conn = new mysqli("localhost", "root", "", "cozyhome");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    foreach ($data as $item) {
        $tracking = $conn->real_escape_string($item['tracking']);

        $sql = "UPDATE parcel_user SET status='received' WHERE tracking='$tracking'";
        $conn->query($sql);
    }
}

echo json_encode(["status" => "success"]);
$conn->close();
?>