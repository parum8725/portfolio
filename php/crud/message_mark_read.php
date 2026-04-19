<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $conn->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: ../admin/messages.php');
exit;
