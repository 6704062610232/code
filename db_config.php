<?php
// ตั้งค่าการเชื่อมต่อ (Server, User, Password, ชื่อ Database)
$conn = mysqli_connect("localhost", "root", "", "cozyhome_db");

// เช็คว่าเชื่อมต่อได้ไหม
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตั้งค่าให้รองรับภาษาไทย
mysqli_set_charset($conn, "utf8mb4");
?>