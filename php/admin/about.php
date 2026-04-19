<?php
$page_title = 'Edit About';
require __DIR__ . '/../includes/header.php';

$row = $conn->query("SELECT * FROM about ORDER BY id ASC LIMIT 1")->fetch_assoc();
if (!$row) {
    $conn->query("INSERT INTO about (content) VALUES ('')");
    $row = $conn->query("SELECT * FROM about ORDER BY id ASC LIMIT 1")->fetch_assoc();
}
?>

<h3 class="mb-3"><i class="bi bi-card-text"></i> Edit About Me</h3>
<p class="text-muted">Gunakan baris kosong untuk memisahkan paragraf.</p>

<div class="card">
  <div class="card-body">
    <form method="post" action="../crud/about_save.php">
      <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
      <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content" rows="18" class="form-control" required><?= e($row['content']) ?></textarea>
      </div>
      <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
