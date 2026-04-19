<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    flash_set('Pesan dihapus.', 'success');
}
header('Location: ../admin/messages.php');
exit;
