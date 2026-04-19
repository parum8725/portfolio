<?php
$page_title = 'Project Form';
require __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = $id > 0;
$row = ['id' => 0, 'title' => '', 'description' => '', 'image' => null, 'sort_order' => 0];

if ($is_edit) {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) {
        flash_set('Project tidak ditemukan.', 'danger');
        header('Location: projects.php');
        exit;
    }
}
?>

<h3 class="mb-3">
  <i class="bi bi-kanban"></i>
  <?= $is_edit ? 'Edit' : 'Tambah' ?> Project / Certificate
</h3>

<div class="card">
  <div class="card-body">
    <form method="post" action="../crud/project_save.php" enctype="multipart/form-data" class="row g-3">
      <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">

      <div class="col-md-4 text-center">
        <?php if (!empty($row['image'])): ?>
          <img src="<?= e(IMG_URL_ADMIN . $row['image']) ?>" class="thumb-lg mb-2" alt="">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remove_image" id="rm" value="1">
            <label class="form-check-label small" for="rm">Hapus gambar</label>
          </div>
        <?php else: ?>
          <div class="text-muted mb-2">Belum ada gambar.</div>
        <?php endif; ?>

        <label class="form-label mt-2">Upload gambar</label>
        <input type="file" name="image" accept="image/*" class="form-control">
        <small class="text-muted">JPG/PNG/GIF/WebP, max 5 MB.</small>
      </div>

      <div class="col-md-8">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required
                 value="<?= e($row['title']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" rows="4" class="form-control" required><?= e($row['description']) ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Urutan</label>
          <input type="number" name="sort_order" class="form-control" value="<?= (int)$row['sort_order'] ?>">
        </div>
      </div>

      <div class="col-12">
        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="projects.php" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
