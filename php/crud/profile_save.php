<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/profile.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    flash_set('ID tidak valid.', 'danger');
    header('Location: ../admin/profile.php');
    exit;
}

$row = $conn->query("SELECT * FROM profile WHERE id = $id LIMIT 1")->fetch_assoc();
if (!$row) {
    flash_set('Data profil tidak ditemukan.', 'danger');
    header('Location: ../admin/profile.php');
    exit;
}

try {
    $brand_name  = trim($_POST['brand_name'] ?? '');
    $name        = trim($_POST['name'] ?? '');
    $subtitle    = trim($_POST['subtitle'] ?? '');
    $instagram   = trim($_POST['instagram'] ?? '');
    $linkedin    = trim($_POST['linkedin'] ?? '');
    $footer_text = trim($_POST['footer_text'] ?? '');

    if ($brand_name === '' || $name === '' || $subtitle === '') {
        throw new Exception('Brand, nama, dan subtitle wajib diisi.');
    }

    $photo = $row['photo'];

    if (!empty($_POST['remove_photo']) && $photo) {
        delete_image($photo);
        $photo = null;
    }

    $uploaded = upload_image('photo', !empty($_POST['remove_photo']) ? null : $photo);
    if ($uploaded) {
        $photo = $uploaded;
    }

    $stmt = $conn->prepare("UPDATE profile SET brand_name=?, name=?, subtitle=?, photo=?, instagram=?, linkedin=?, footer_text=? WHERE id=?");
    $stmt->bind_param('sssssssi', $brand_name, $name, $subtitle, $photo, $instagram, $linkedin, $footer_text, $id);
    $stmt->execute();

    flash_set('Profil berhasil disimpan.', 'success');
} catch (Exception $ex) {
    flash_set('Gagal: ' . $ex->getMessage(), 'danger');
}

header('Location: ../admin/profile.php');
exit;
