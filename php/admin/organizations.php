<?php
$page_title = 'Organizations';
require __DIR__ . '/../includes/header.php';

$res = $conn->query("SELECT * FROM organizations ORDER BY sort_order ASC, id ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><i class="bi bi-building"></i> Organizations</h3>
  <a href="organization_form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th style="width:50px">#</th>
            <th>Title</th>
            <th>Role</th>
            <th>Items</th>
            <th style="width:100px">Order</th>
            <th style="width:180px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($res && $res->num_rows): $no=1; ?>
            <?php while ($r = $res->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><b><?= e($r['title']) ?></b></td>
                <td><?= e($r['role']) ?></td>
                <td><small><?= count(array_filter(explode("\n", $r['items']))) ?> item</small></td>
                <td><?= (int)$r['sort_order'] ?></td>
                <td>
                  <a href="organization_form.php?id=<?= (int)$r['id'] ?>" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a href="../crud/organization_delete.php?id=<?= (int)$r['id'] ?>"
                     onclick="return confirm('Hapus organisasi ini?');"
                     class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="text-center text-muted p-4">Belum ada data.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
