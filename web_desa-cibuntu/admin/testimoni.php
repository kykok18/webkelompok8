<?php
$page_title = 'Manajemen Testimoni';

$db = getDB();

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = sanitize($_POST['nama']);
    $lokasi = sanitize($_POST['lokasi']);
    $rating = (int)$_POST['rating'];
    $komentar = sanitize($_POST['komentar']);
    $status = sanitize($_POST['status']);

    $stmt = $db->prepare("INSERT INTO testimoni (nama, lokasi, rating, komentar, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $lokasi, $rating, $komentar, $status]);
    set_flash('success', 'Testimoni berhasil ditambahkan');
    header('Location: ' . base_url('?page=admin_testimoni'));
    exit;
}

// Handle Status
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $stmt = $db->prepare("UPDATE testimoni SET status = 'approved' WHERE id = ?");
    $stmt->execute([$id]);
    set_flash('success', 'Testimoni berhasil di-approve');
    header('Location: ' . base_url('?page=admin_testimoni'));
    exit;
}

// Handle Delete
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $db->prepare("DELETE FROM testimoni WHERE id = ?");
    $stmt->execute([$id]);
    set_flash('success', 'Testimoni berhasil dihapus');
    header('Location: ' . base_url('?page=admin_testimoni'));
    exit;
}

require_once __DIR__ . '/includes/header.php';

$testimoni = $db->query("SELECT * FROM testimoni ORDER BY created_at DESC")->fetchAll();
?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Testimoni</h5>
    </div>
    <div class="card-body">
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" placeholder="Jakarta">
            </div>
            <div class="col-md-2">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>" <?= $i === 5 ? 'selected' : '' ?>><?= $i ?> Bintang</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Komentar</label>
                <textarea name="komentar" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-12">
                <button type="submit" name="tambah" class="btn btn-primary-custom">
                    <i class="bi bi-plus me-1"></i>Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-chat-quote me-2"></i>Daftar Testimoni (<?= count($testimoni) ?>)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Komentar</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimoni as $t): ?>
                        <tr>
                            <td>
                                <strong><?= sanitize($t['nama']) ?></strong><br>
                                <small class="text-muted"><?= sanitize($t['lokasi']) ?></small>
                            </td>
                            <td style="max-width: 300px;">
                                <span style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-clamp: 2;">
                                    <?= sanitize($t['komentar']) ?>
                                </span>
                            </td>
                            <td>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?= $i <= $t['rating'] ? '-fill text-warning' : '' ?>"></i>
                                <?php endfor; ?>
                            </td>
                            <td>
                                <?php if ($t['status'] === 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($t['status'] === 'pending'): ?>
                                    <a href="?page=admin_testimoni&approve=<?= $t['id'] ?>" class="btn btn-sm btn-outline-success mb-1">
                                        <i class="bi bi-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="?page=admin_testimoni&hapus=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger mb-1" onclick="return confirm('Hapus testimoni ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>