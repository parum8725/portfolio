<?php
require_once __DIR__ . '/includes/functions.php';

$error = '';

if (!empty($_SESSION['user_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            flash_set('Selamat datang, ' . $user['username'] . '!', 'success');
            header('Location: admin/dashboard.php');
            exit;
        }
        $error = 'Username atau password salah.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Admin - Portfolio</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/admin_style.css">
</head>
<body class="login-body">
<div class="container" style="max-width:420px; padding-top:80px;">
  <div class="card shadow">
    <div class="card-body p-4">
      <div class="text-center mb-4">
        <i class="bi bi-person-circle" style="font-size:3rem; color: rgb(171,91,208);"></i>
        <h4 class="mt-2 mb-0">Login Admin</h4>
        <small class="text-muted">Portfolio Sarah Ika</small>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required autofocus
                 value="<?= e($_POST['username'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
      </form>
      <hr>
      <div class="text-center">
        <a href="index.php" class="text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke Portfolio</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
