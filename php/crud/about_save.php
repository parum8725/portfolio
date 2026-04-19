<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/about.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$content = trim($_POST['content'] ?? '');

if ($id <= 0) {
    flash_set('ID tidak valid.', 'danger');
} elseif ($content === '') {
    flash_set('Konten About tidak boleh kosong.', 'danger');
} else {
    $stmt = $conn->prepare("UPDATE about SET content = ? WHERE id = ?");
    $stmt->bind_param('si', $content, $id);
    $stmt->execute();
    flash_set('Konten About berhasil disimpan.', 'success');
}

header('Location: ../admin/about.php');
exit;
