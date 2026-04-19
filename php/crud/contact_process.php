<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    flash_set('Semua field wajib diisi.', 'danger');
    header('Location: ../index.php#contact');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('Format email tidak valid.', 'danger');
    header('Location: ../index.php#contact');
    exit;
}

$stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $name, $email, $message);
$stmt->execute();

flash_set('Terima kasih! Pesan kamu sudah terkirim.', 'success');
header('Location: ../index.php#contact');
exit;
