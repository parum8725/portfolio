<?php
$page_title = 'Messages';
require __DIR__ . '/../includes/header.php';

$res = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<h3 class="mb-3"><i class="bi bi-envelope"></i> Pesan Masuk</h3>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th style="width:50px">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pesan</th>
            <th>Tanggal</th>
            <th style="width:90px">Status</th>
            <th style="width:180px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($res && $res->num_rows): $no = 1; ?>
            <?php while ($m = $res->fetch_assoc()): ?>
              <tr class="<?= !$m['is_read'] ? 'table-warning' : '' ?>">
                <td><?= $no++ ?></td>
                <td><b><?= e($m['name']) ?></b></td>
                <td><a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a></td>
                <td><small><?= nl2br(e($m['message'])) ?></small></td>
                <td><small><?= e(fmt_date($m['created_at'])) ?></small></td>
                <td>
                  <?php if ($m['is_read']): ?>
                    <span class="badge bg-secondary">Dibaca</span>
                  <?php else: ?>
                    <span class="badge badge-unread text-white">Baru</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!$m['is_read']): ?>
                    <a href="../crud/message_mark_read.php?id=<?= (int)$m['id'] ?>"
                       class="btn btn-sm btn-outline-primary" title="Tandai dibaca">
                      <i class="bi bi-check2"></i>
                    </a>
                  <?php endif; ?>
                  <a href="../crud/message_delete.php?id=<?= (int)$m['id'] ?>"
                     onclick="return confirm('Hapus pesan ini?');"
                     class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center text-muted p-4">Belum ada pesan masuk.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
