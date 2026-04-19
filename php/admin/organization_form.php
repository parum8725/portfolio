<?php
$page_title = 'Organization Form';
require __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = $id > 0;
$row = ['id' => 0, 'title' => '', 'role' => '', 'items' => '', 'sort_order' => 0];

if ($is_edit) {
    $stmt = $conn->prepare("SELECT * FROM organizations WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) {
        flash_set('Data tidak ditemukan.', 'danger');
        header('Location: organizations.php');
        exit;
    }
}
?>

<h3 class="mb-3">
  <i class="bi bi-building"></i>
  <?= $is_edit ? 'Edit' : 'Tambah' ?> Organization
</h3>

<div class="card">
  <div class="card-body">
    <form method="post" action="../crud/organization_save.php">
      <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
      <div class="mb-3">
        <label class="form-label">Nama Organisasi / Title</label>
        <input type="text" name="title" class="form-control" required
               value="<?= e($row['title']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Role / Posisi</label>
        <input type="text" name="role" class="form-control" required
               value="<?= e($row['role']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Items (1 item per baris)</label>
        <textarea name="items" rows="10" class="form-control" required
                  placeholder="Tulis job desc/tugas, satu baris satu item"><?= e($row['items']) ?></textarea>
        <small class="text-muted">Setiap baris akan menjadi satu bullet point di portfolio.</small>
      </div>
      <div class="mb-3">
        <label class="form-label">Urutan (semakin kecil semakin awal)</label>
        <input type="number" name="sort_order" class="form-control" value="<?= (int)$row['sort_order'] ?>">
      </div>
      <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="organizations.php" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
