<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();

    if ($r) {
        if (!empty($r['image'])) {
            delete_image($r['image']);
        }
        $d = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $d->bind_param('i', $id);
        $d->execute();
        flash_set('Project dihapus.', 'success');
    } else {
        flash_set('Project tidak ditemukan.', 'warning');
    }
} else {
    flash_set('ID tidak valid.', 'danger');
}
header('Location: ../admin/projects.php');
exit;
