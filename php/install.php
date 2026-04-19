<?php
require_once __DIR__ . '/config/config.php';

$messages = [];
$errors   = [];
$error    = null;
$success  = false;
$already_installed = false;

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

try {
    $check = $conn->query("SHOW TABLES LIKE 'users'");
    if (!$check || $check->num_rows === 0) {
        throw new Exception("Tabel 'users' tidak ditemukan. Import dulu file database.sql melalui phpMyAdmin.");
    }

    $count_res = $conn->query("SELECT COUNT(*) AS c FROM users");
    $user_count = (int) $count_res->fetch_assoc()['c'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
        $username = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $confirm  = (string) ($_POST['confirm'] ?? '');

        if ($user_count > 0) {
            $errors[] = 'Admin sudah pernah dibuat. Gunakan halaman login.';
        }
        if ($username === '' || strlen($username) < 3 || strlen($username) > 50) {
            $errors[] = 'Username wajib diisi (3-50 karakter).';
        }
        if (!preg_match('/^[A-Za-z0-9_.-]+$/', $username)) {
            $errors[] = 'Username hanya boleh huruf, angka, titik, underscore, atau strip.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Konfirmasi password tidak cocok.';
        }

        if (!$errors) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $errors[] = 'Username sudah dipakai.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $ins->bind_param('ss', $username, $hash);
                $ins->execute();
                $success = true;
                $user_count = 1;
                $messages[] = 'Akun admin berhasil dibuat dengan username <b>' . e($username) . '</b>. Silakan login.';
            }
        }
    }

    if ($user_count > 0) {
        $already_installed = true;
    }

    if (!is_dir(UPLOAD_DIR)) {
        @mkdir(UPLOAD_DIR, 0775, true);
    }
    if (is_dir(UPLOAD_DIR) && is_writable(UPLOAD_DIR)) {
        $messages[] = 'Folder upload <code>' . e(UPLOAD_DIR) . '</code> siap digunakan.';
    } else {
        $messages[] = "<span style='color:#b45309'>Perhatian:</span> folder upload belum writable. Jalankan: <code>chmod -R 775 " . e(UPLOAD_DIR) . "</code>";
    }

} catch (Exception $ex) {
    $error = $ex->getMessage();
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Install - Portfolio Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/admin_style.css">
</head>
<body class="install-body">
<div class="container" style="max-width:640px; padding-top:70px;">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="mb-3">Instalasi Portfolio Admin</h3>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
      <?php else: ?>

        <?php foreach ($errors as $er): ?>
          <div class="alert alert-danger"><?= e($er) ?></div>
        <?php endforeach; ?>

        <?php foreach ($messages as $m): ?>
          <div class="alert alert-info"><?= $m ?></div>
        <?php endforeach; ?>

        <?php if ($already_installed): ?>
          <div class="alert alert-success">Admin sudah terdaftar. Silakan login.</div>
          <div class="d-flex gap-2 flex-wrap">
            <a href="login.php" class="btn btn-primary">Ke Halaman Login</a>
            <a href="index.php" class="btn btn-outline-secondary">Lihat Portfolio</a>
          </div>
        <?php else: ?>
          <p class="text-muted">Buat akun admin pertama untuk mengelola portfolio.</p>
          <form method="post" autocomplete="off" class="mt-3">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required
                     minlength="3" maxlength="50"
                     pattern="[A-Za-z0-9_.\-]+"
                     value="<?= e($_POST['username'] ?? '') ?>">
              <div class="form-text">3-50 karakter. Huruf, angka, titik, underscore, strip.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required minlength="6">
              <div class="form-text">Minimal 6 karakter.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="confirm" class="form-control" required minlength="6">
            </div>
            <button type="submit" name="create_admin" value="1" class="btn btn-primary">
              Buat Akun Admin
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Batal</a>
          </form>
        <?php endif; ?>

        <hr>
        <small class="text-muted">
          Setelah semuanya beres, sebaiknya hapus atau rename file <code>install.php</code>
          agar tidak bisa diakses publik.
        </small>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
