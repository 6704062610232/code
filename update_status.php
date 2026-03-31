<?php
include 'db_config.php';

if(isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // คำสั่งแก้ไขข้อมูลตาม ID ที่เลือก
    $sql = "UPDATE repair_tasks SET status='$status' WHERE id=$id";

    if(mysqli_query($conn, $sql)) {
        echo "อัปเดตสถานะสำเร็จ";
    }
}

mysqli_close($conn);
?>