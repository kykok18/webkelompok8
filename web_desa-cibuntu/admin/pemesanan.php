<?php
// 1. Load Config dulu
require_once __DIR__ . '/../inc/config.php';

// 2. Cek Login (duplikat dari header untuk keamanan sebelum output)
if (!is_admin()) {
    header('Location: ' . base_url('?page=admin_login'));
    exit;
}

$db = getDB();

// 3. Handle Status Update (PROSES SEBELUM OUTPUT HTML)
if (isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = sanitize($_POST['status']);
    $catatan_admin = sanitize($_POST['catatan_admin'] ?? '');

    $stmt = $db->prepare("UPDATE pemesanan SET status = ?, catatan_admin = ? WHERE id = ?");
    $stmt->execute([$status, $catatan_admin, $id]);
    set_flash('success', 'Status pemesanan berhasil diperbarui');
    header('Location: ' . base_url('?page=admin_pemesanan'));
    exit;
}

// 4. Handle Delete (PROSES SEBELUM OUTPUT HTML)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM pemesanan WHERE id = ?");
    $stmt->execute([$id]);
    set_flash('success', 'Pemesanan berhasil dihapus');
    header('Location: ' . base_url('?page=admin_pemesanan'));
    exit;
}

// 5. Baru set title dan panggil header (OUTPUT HTML DIMULAI)
$page_title = 'Manajemen Pemesanan';
require_once __DIR__ . '/includes/header.php';

// 6. Ambil Data untuk ditampilkan
$filter = $_GET['filter'] ?? 'semua';
$where = $filter !== 'semua' ? "WHERE status = ?" : "";
$order = "ORDER BY created_at DESC";

if ($filter !== 'semua') {
    $stmt = $db->prepare("SELECT * FROM pemesanan $where $order");
    $stmt->execute([$filter]);
} else {
    $stmt = $db->query("SELECT * FROM pemesanan $order");
}
$pemesanan = $stmt->fetchAll();

// Counts
$counts = [
    'semua' => $db->query("SELECT COUNT(*) FROM pemesanan")->fetchColumn(),
    'pending' => $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'pending'")->fetchColumn(),
    'confirmed' => $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'confirmed'")->fetchColumn(),
    'completed' => $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'completed'")->fetchColumn(),
    'cancelled' => $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'cancelled'")->fetchColumn(),
];
?>

<div class="d-flex flex-wrap gap-2 mb-4">
    <?php foreach (['semua', 'pending', 'confirmed', 'completed', 'cancelled'] as $f): ?>
        <a href="?page=admin_pemesanan&filter=<?= $f ?>"
            class="btn <?= $filter === $f ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill">
            <?= ucfirst($f) ?>
            <?php if ($counts[$f] > 0): ?>
                <span class="badge bg-light text-primary ms-1"><?= $counts[$f] ?></span>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (count($pemesanan) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Customer</th>
                            <th>Paket</th>
                            <th>Tgl. Kunjungan</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemesanan as $p): ?>
                            <tr>
                                <td><strong><?= sanitize($p['kode_pemesanan']) ?></strong></td>
                                <td>
                                    <?= sanitize($p['nama']) ?><br>
                                    <small class="text-muted"><?= sanitize($p['email']) ?></small>
                                </td>
                                <td><?= sanitize($p['paket_nama']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal_kunjungan'])) ?></td>
                                <td><?= $p['jumlah_orang'] ?> orang</td>
                                <td><strong><?= format_harga($p['total_harga']) ?></strong></td>
                                <td><span class="badge badge-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal<?= $p['id'] ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="https://wa.me/<?= sanitize($p['wa']) ?>?text=Halo <?= urlencode($p['nama']) ?>, terkait reservasi Anda (Kode: <?= $p['kode_pemesanan'] ?>) di Desa Wisata Cibuntu..."
                                            class="btn btn-whatsapp-admin btn-sm" target="_blank" title="Chat WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="modal<?= $p['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pemesanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Kode Pemesanan</p>
                                                    <h5><?= sanitize($p['kode_pemesanan']) ?></h5>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <p class="mb-1 text-muted">Status</p>
                                                    <span class="badge badge-<?= $p['status'] ?> fs-6"><?= ucfirst($p['status']) ?></span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Nama</p>
                                                    <p class="fw-semibold"><?= sanitize($p['nama']) ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Email</p>
                                                    <p class="fw-semibold"><?= sanitize($p['email']) ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">WhatsApp</p>
                                                    <p class="fw-semibold"><?= sanitize($p['wa']) ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Paket</p>
                                                    <p class="fw-semibold"><?= sanitize($p['paket_nama']) ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Tanggal Kunjungan</p>
                                                    <p class="fw-semibold"><?= date('d F Y', strtotime($p['tanggal_kunjungan'])) ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Jumlah Orang</p>
                                                    <p class="fw-semibold"><?= $p['jumlah_orang'] ?> orang</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="mb-1 text-muted">Total Harga</p>
                                                    <h4 class="text-primary"><?= format_harga($p['total_harga']) ?></h4>
                                                </div>
                                                <?php if ($p['catatan']): ?>
                                                    <div class="col-12">
                                                        <p class="mb-1 text-muted">Catatan Customer</p>
                                                        <p><?= nl2br(sanitize($p['catatan'])) ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <hr>
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Ubah Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="pending" <?= $p['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="confirmed" <?= $p['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                            <option value="completed" <?= $p['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                                            <option value="cancelled" <?= $p['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Catatan Admin</label>
                                                        <input type="text" name="catatan_admin" class="form-control" value="<?= sanitize($p['catatan_admin'] ?? '') ?>">
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" name="update_status" class="btn btn-primary">
                                                        <i class="bi bi-check me-1"></i>Update Status
                                                    </button>
                                                    <a href="?page=admin_pemesanan&delete=<?= $p['id'] ?>"
                                                        class="btn btn-outline-danger"
                                                        onclick="return confirm('Hapus pemesanan ini?')">
                                                        <i class="bi bi-trash me-1"></i>Hapus
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="https://wa.me/<?= sanitize($p['wa']) ?>?text=Halo <?= urlencode($p['nama']) ?>, terkait reservasi Anda (Kode: <?= $p['kode_pemesanan'] ?>) di Desa Wisata Cibuntu..."
                                                class="btn btn-success" target="_blank">
                                                <i class="bi bi-whatsapp me-1"></i>Chat WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <p class="mt-3 text-muted">Tidak ada data pemesanan</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>