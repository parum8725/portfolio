<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/organizations.php');
    exit;
}

$id         = (int)($_POST['id'] ?? 0);
$title      = trim($_POST['title'] ?? '');
$role       = trim($_POST['role'] ?? '');
$items      = trim($_POST['items'] ?? '');
$sort_order = (int)($_POST['sort_order'] ?? 0);

if ($title === '' || $role === '' || $items === '') {
    flash_set('Semua field wajib diisi.', 'danger');
    if ($id > 0) {
        header('Location: ../admin/organization_form.php?id=' . $id);
    } else {
        header('Location: ../admin/organization_form.php');
    }
    exit;
}

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE organizations SET title=?, role=?, items=?, sort_order=? WHERE id=?");
    $stmt->bind_param('sssii', $title, $role, $items, $sort_order, $id);
    $stmt->execute();
    flash_set('Organisasi berhasil diupdate.', 'success');
} else {
    $stmt = $conn->prepare("INSERT INTO organizations (title, role, items, sort_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssi', $title, $role, $items, $sort_order);
    $stmt->execute();
    flash_set('Organisasi baru berhasil ditambahkan.', 'success');
}

header('Location: ../admin/organizations.php');
exit;
