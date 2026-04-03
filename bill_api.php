<?php
$conn = new mysqli("localhost", "root", "", "cozyhome_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

// ================= FETCH BILL =================
if ($action == "fetch") {
    $result = $conn->query("SELECT * FROM bills ORDER BY id DESC");
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

// ================= SAVE BILL =================
if ($action == "save") {
    $stmt = $conn->prepare("
        INSERT INTO bills 
        (room,name,cycle,rent,water_units,water_price,elec_units,elec_price,total) 
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "sssiiiiii",
        $_POST['room'],
        $_POST['name'],
        $_POST['cycle'],
        $_POST['rent'],
        $_POST['w_units'],
        $_POST['w_price'],
        $_POST['e_units'],
        $_POST['e_price'],
        $_POST['total']
    );

    $stmt->execute();

    echo json_encode(["status"=>"success"]);
    exit;
}

// ================= UPDATE STATUS =================
if ($action == "update_status") {
    $stmt = $conn->prepare("UPDATE bills SET status=? WHERE id=?");
    $stmt->bind_param("si", $_POST['status'], $_POST['id']);
    $stmt->execute();

    echo json_encode(["status"=>"success"]);
    exit;
}

// ================= GET METERS =================
if ($action == "get_meter") {

    $cycle = $_GET['cycle'] ?? date("Y-m");

    $res = $conn->query("
        SELECT room_no, new_water, new_elec 
        FROM meters
        WHERE cycle = '$cycle'
    ");

    $data = [];

    while($row = $res->fetch_assoc()){

        if(is_numeric($row['room_no'])){
            $data[$row['room_no']] = [
                "w" => (int)$row['new_water'],
                "e" => (int)$row['new_elec']
            ];
        }
    }

    echo json_encode($data);
    exit;
}
?>