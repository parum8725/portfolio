<?php
$page_title = 'Dashboard';
require __DIR__ . '/../includes/header.php';

$stats = [
    'organizations' => count_rows($conn, 'organizations'),
    'projects'      => count_rows($conn, 'projects'),
    'messages'      => count_rows($conn, 'messages'),
    'unread'        => (int)($conn->query("SELECT COUNT(*) AS c FROM messages WHERE is_read = 0")->fetch_assoc()['c'] ?? 0),
];

$recent_messages = $conn->query("SELECT id, name, email, LEFT(message, 80) AS snippet, is_read, created_at FROM messages ORDER BY created_at DESC LIMIT 5");
?>

<h3 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h3>

<div class="row g-3 mb-4">
  <div class="col-md-3 col-6">
    <div class="stat-card bg-a">
      <div class="num"><?= $stats['organizations'] ?></div>
      <div><i class="bi bi-building"></i> Organizations</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="stat-card bg-b">
      <div class="num"><?= $stats['projects'] ?></div>
      <div><i class="bi bi-kanban"></i> Projects</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="stat-card bg-c">
      <div class="num"><?= $stats['messages'] ?></div>
      <div><i class="bi bi-envelope"></i> Total Messages</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="stat-card bg-d">
      <div class="num"><?= $stats['unread'] ?></div>
      <div><i class="bi bi-envelope-exclamation"></i> Unread Messages</div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header"><i class="bi bi-lightning"></i> Quick Actions</div>
      <div class="card-body d-flex flex-wrap gap-2">
        <a href="profile.php" class="btn btn-outline-primary"><i class="bi bi-person"></i> Edit Profile</a>
        <a href="about.php" class="btn btn-outline-primary"><i class="bi bi-card-text"></i> Edit About</a>
        <a href="organization_form.php" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Add Organization</a>
        <a href="project_form.php" class="btn btn-outline-primary"><i class="bi bi-plus"></i> Add Project</a>
        <a href="../index.php" target="_blank" class="btn btn-primary"><i class="bi bi-eye"></i> View Portfolio</a>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card">
      <div class="card-header"><i class="bi bi-envelope"></i> Pesan Terbaru</div>
      <div class="card-body p-0">
        <?php if ($recent_messages && $recent_messages->num_rows): ?>
          <ul class="list-group list-group-flush">
            <?php while ($m = $recent_messages->fetch_assoc()): ?>
              <li class="list-group-item">
                <div class="d-flex justify-content-between">
                  <b><?= e($m['name']) ?></b>
                  <?php if (!$m['is_read']): ?><span class="badge badge-unread text-white">baru</span><?php endif; ?>
                </div>
                <div class="small text-muted"><?= e($m['email']) ?> &middot; <?= e(fmt_date($m['created_at'])) ?></div>
                <div class="small"><?= e($m['snippet']) ?>...</div>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <div class="p-3 text-muted">Belum ada pesan masuk.</div>
        <?php endif; ?>
      </div>
      <div class="card-footer text-end">
        <a href="messages.php" class="btn btn-sm btn-primary">Lihat semua <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
