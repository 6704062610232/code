<?php
include 'db_config.php';

if(isset($_POST['room']) && isset($_POST['title'])) {
    $room = $_POST['room'];
    $title = $_POST['title'];

    // คำสั่งเพิ่มข้อมูล
    $sql = "INSERT INTO repair_tasks (room, title, status) VALUES ('$room', '$title', 'pending')";

    if(mysqli_query($conn, $sql)) {
        echo "บันทึกข้อมูลแจ้งซ่อมเรียบร้อย!";
    } else {
        echo "เกิดข้อผิดพลาด: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>