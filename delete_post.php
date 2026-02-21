<?php
require_once __DIR__ . '/../includes/config.php';
$id = intval($_GET['id'] ?? 0);
if($id > 0){
    $stmt = $conn->prepare("DELETE FROM posts WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: dashboard.php');
exit;