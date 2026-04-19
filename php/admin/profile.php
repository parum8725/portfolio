<?php
$page_title = 'Edit Profile';
require __DIR__ . '/../includes/header.php';

$row = $conn->query("SELECT * FROM profile ORDER BY id ASC LIMIT 1")->fetch_assoc();
if (!$row) {
    $conn->query("INSERT INTO profile (brand_name, name, subtitle) VALUES ('Sarah Ika', 'Nama Anda', 'Subtitle di sini')");
    $row = $conn->query("SELECT * FROM profile ORDER BY id ASC LIMIT 1")->fetch_assoc();
}
?>

<h3 class="mb-3"><i class="bi bi-person"></i> Edit Profile</h3>

<div class="card">
  <div class="card-body">
    <form method="post" action="../crud/profile_save.php" enctype="multipart/form-data" class="row g-3">
      <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">

      <div class="col-md-4 text-center">
        <?php if ($row['photo']): ?>
          <img src="<?= e(IMG_URL_ADMIN . $row['photo']) ?>" class="thumb-lg rounded-circle mb-2" alt="Foto">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remove_photo" id="rm" value="1">
            <label class="form-check-label small" for="rm">Hapus foto saat ini</label>
          </div>
        <?php else: ?>
          <div class="text-muted">Belum ada foto.</div>
        <?php endif; ?>

        <label class="form-label mt-3">Foto baru</label>
        <input type="file" name="photo" accept="image/*" class="form-control">
        <small class="text-muted">JPG/PNG/GIF/WebP, max 5 MB.</small>
      </div>

      <div class="col-md-8">
        <div class="mb-3">
          <label class="form-label">Brand (Navbar)</label>
          <input type="text" name="brand_name" class="form-control" required
                 value="<?= e($row['brand_name']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" required
                 value="<?= e($row['name']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Subtitle / Jurusan</label>
          <input type="text" name="subtitle" class="form-control" required
                 value="<?= e($row['subtitle']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Instagram URL</label>
          <input type="url" name="instagram" class="form-control"
                 value="<?= e($row['instagram']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">LinkedIn URL</label>
          <input type="url" name="linkedin" class="form-control"
                 value="<?= e($row['linkedin']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Footer Text</label>
          <input type="text" name="footer_text" class="form-control"
                 value="<?= e($row['footer_text']) ?>">
        </div>
      </div>

      <div class="col-12">
        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
