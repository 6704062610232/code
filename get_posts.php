<?php
require_once 'db_config.php';

$sql = "SELECT * FROM news_posts ORDER BY id DESC";
$result = $conn->query($sql);

$posts = [];

while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);

$conn->close();
?>