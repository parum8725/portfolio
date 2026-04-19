<?php
// Header shared untuk semua halaman di /php/admin/
require_once __DIR__ . '/functions.php';
require_login();

$current = basename($_SERVER['PHP_SELF']);
function nav_active($file) {
    global $current;
    return $current === $file ? 'active' : '';
}
$flash = flash_get();
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= isset($page_title) ? e($page_title) . ' - ' : '' ?>Admin Portfolio</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/admin_style.css">
</head>
<body>
<nav class="navbar navbar-admin navbar-expand-lg navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">
      <i class="bi bi-speedometer2"></i> Admin Portfolio
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link <?= nav_active('dashboard.php') ?>" href="dashboard.php"><i class="bi bi-house"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('profile.php') ?>" href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('about.php') ?>" href="about.php"><i class="bi bi-card-text"></i> About</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('organizations.php') ?><?= nav_active('organization_form.php') ?>" href="organizations.php"><i class="bi bi-building"></i> Organizations</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('projects.php') ?><?= nav_active('project_form.php') ?>" href="projects.php"><i class="bi bi-kanban"></i> Projects</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('messages.php') ?>" href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
        <li class="nav-item"><a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-eye"></i> View Site</a></li>
        <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-4">
  <?php if ($flash): ?>
    <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show">
      <?= e($flash['message']) ?>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
