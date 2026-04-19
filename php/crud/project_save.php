<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/projects.php');
    exit;
}

$id          = (int)($_POST['id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$sort_order  = (int)($_POST['sort_order'] ?? 0);

try {
    if ($title === '' || $description === '') {
        throw new Exception('Title dan description wajib diisi.');
    }

    $image = null;
    if ($id > 0) {
        $old = $conn->query("SELECT image FROM projects WHERE id = $id LIMIT 1")->fetch_assoc();
        $image = $old['image'] ?? null;
    }

    if (!empty($_POST['remove_image']) && $image) {
        delete_image($image);
        $image = null;
    }

    $uploaded = upload_image('image', !empty($_POST['remove_image']) ? null : $image);
    if ($uploaded) {
        $image = $uploaded;
    }

    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, image=?, sort_order=? WHERE id=?");
        $stmt->bind_param('sssii', $title, $description, $image, $sort_order, $id);
        $stmt->execute();
        flash_set('Project berhasil diupdate.', 'success');
    } else {
        $stmt = $conn->prepare("INSERT INTO projects (title, description, image, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $title, $description, $image, $sort_order);
        $stmt->execute();
        flash_set('Project baru berhasil ditambahkan.', 'success');
    }
    header('Location: ../admin/projects.php');
    exit;
} catch (Exception $ex) {
    flash_set('Gagal: ' . $ex->getMessage(), 'danger');
    if ($id > 0) {
        header('Location: ../admin/project_form.php?id=' . $id);
    } else {
        header('Location: ../admin/project_form.php');
    }
    exit;
}
