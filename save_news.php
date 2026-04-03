<?php
include 'db_config.php';

// รับข้อมูลจาก FormData
$content = $_POST['content'] ?? '';
$author = "แอดมินนิติ"; // กำหนดชื่อผู้โพสต์ไว้เลย

if (!empty($content)) {
    $sql = "INSERT INTO news_posts (author_name, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $author, $content);

    if ($stmt->execute()) {
        echo "ประกาศข่าวสารเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
} else {
    echo "กรุณากรอกข้อความประกาศ";
}
?>