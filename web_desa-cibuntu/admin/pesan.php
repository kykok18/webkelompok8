<?php
$page_title = 'Manajemen Pesan';
require_once 'includes/header.php';

$db = getDB();

if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'read') {
        $stmt = $db->prepare("UPDATE kontak_messages SET status = 'dibaca' WHERE id = ?");
        $stmt->execute([$id]);
        set_flash('success', 'Pesan ditandai sudah dibaca.');
    } elseif ($_GET['action'] === 'delete') {
        $stmt = $db->prepare("DELETE FROM kontak_messages WHERE id = ?");
        $stmt->execute([$id]);
        set_flash('success', 'Pesan berhasil dihapus.');
    }
    header('Location: ' . base_url('?page=admin_pesan'));
    exit;
}

if (isset($_GET['mark_all'])) {
    $db->exec("UPDATE kontak_messages SET status = 'dibaca' WHERE status = 'baru'");
    set_flash('success', 'Semua pesan ditandai sudah dibaca.');
    header('Location: ' . base_url('?page=admin_pesan'));
    exit;
}

$filter = $_GET['filter'] ?? 'semua';
if ($filter === 'baru') {
    $stmt = $db->query("SELECT * FROM kontak_messages WHERE status = 'baru' ORDER BY created_at DESC");
} else {
    $stmt = $db->query("SELECT * FROM kontak_messages ORDER BY created_at DESC");
}
$messages = $stmt->fetchAll();
$baru = $db->query("SELECT COUNT(*) FROM kontak_messages WHERE status = 'baru'")->fetchColumn();
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div class="btn-group me-2 mb-2 mb-md-0">
        <a href="?page=admin_pesan" class="btn <?= $filter === 'semua' ? 'btn-primary' : 'btn-outline-primary' ?>">Semua</a>
        <a href="?page=admin_pesan&filter=baru" class="btn <?= $filter === 'baru' ? 'btn-primary' : 'btn-outline-primary' ?>">Baru (<?= $baru ?>)</a>
    </div>
    <?php if ($baru > 0): ?>
        <a href="?page=admin_pesan&mark_all=1" class="btn btn-success"><i class="bi bi-check-all me-1"></i>Tandai Semua Dibaca</a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (count($messages) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="180">Info</th>
                            <th>Pesan</th>
                            <th width="100">Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $m): ?>
                            <tr class="<?= $m['status'] === 'baru' ? 'table-warning' : '' ?>">
                                <td>
                                    <strong><?= sanitize($m['nama']) ?></strong><br>
                                    <small class="text-muted"><?= sanitize($m['email']) ?></small><br>
                                    <small class="text-muted"><i class="bi bi-clock"></i> <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></small>
                                </td>
                                <td>
                                    <strong><?= sanitize($m['subjek']) ?></strong><br>
                                    <div style="white-space: pre-wrap; max-height: 60px; overflow: hidden;"><?= sanitize($m['pesan']) ?></div>
                                </td>
                                <td>
                                    <?= $m['status'] === 'baru' ? '<span class="badge bg-warning text-dark">Baru</span>' : '<span class="badge bg-secondary">Dibaca</span>' ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#modal<?= $m['id'] ?>"><i class="bi bi-eye"></i></button>
                                    <a href="?page=admin_pesan&action=delete&id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger mb-1" onclick="return confirm('Hapus pesan ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal<?= $m['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pesan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Dari:</strong> <?= sanitize($m['nama']) ?> (<?= sanitize($m['email']) ?>)</p>
                                            <p><strong>Subjek:</strong> <?= sanitize($m['subjek']) ?></p>
                                            <p><strong>Tanggal:</strong> <?= date('d M Y, H:i', strtotime($m['created_at'])) ?></p>
                                            <hr>
                                            <p style="white-space: pre-wrap;"><?= sanitize($m['pesan']) ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <?php if ($m['status'] === 'baru'): ?>
                                                <a href="?page=admin_pesan&action=read&id=<?= $m['id'] ?>" class="btn btn-success">Tandai Dibaca</a>
                                            <?php endif; ?>
                                            <a href="mailto:<?= sanitize($m['email']) ?>" class="btn btn-primary"><i class="bi bi-reply me-1"></i>Balas Email</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted"><i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">Tidak ada pesan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>