<?php
$page_title = 'Dashboard';
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Stats
$total_pemesanan = $db->query("SELECT COUNT(*) FROM pemesanan")->fetchColumn();
$pending = $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'pending'")->fetchColumn();
$confirmed = $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'confirmed'")->fetchColumn();
$completed = $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'completed'")->fetchColumn();

// Revenue
$total_revenue = $db->query("SELECT COALESCE(SUM(total_harga), 0) FROM pemesanan WHERE status IN ('confirmed', 'completed')")->fetchColumn();

// Recent
$recent = $db->query("SELECT * FROM pemesanan ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="stats-grid">
    <div class="stat-card-admin">
        <div class="stat-icon bg-primary"><i class="bi bi-receipt"></i></div>
        <div class="stat-info">
            <h3><?= $total_pemesanan ?></h3>
            <p>Total Pemesanan</p>
        </div>
    </div>
    <div class="stat-card-admin">
        <div class="stat-icon bg-warning"><i class="bi bi-clock-history"></i></div>
        <div class="stat-info">
            <h3><?= $pending ?></h3>
            <p>Pending</p>
        </div>
    </div>
    <div class="stat-card-admin">
        <div class="stat-icon bg-success"><i class="bi bi-check-circle"></i></div>
        <div class="stat-info">
            <h3><?= $confirmed ?></h3>
            <p>Confirmed</p>
        </div>
    </div>
    <div class="stat-card-admin">
        <div class="stat-icon bg-info"><i class="bi bi-trophy"></i></div>
        <div class="stat-info">
            <h3><?= $completed ?></h3>
            <p>Completed</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Pemesanan Terbaru</h5>
                <a href="<?= base_url('?page=admin_pemesanan') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($recent) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Paket</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent as $r): ?>
                                    <tr>
                                        <td><strong><?= sanitize($r['kode_pemesanan']) ?></strong></td>
                                        <td><?= sanitize($r['nama']) ?></td>
                                        <td><?= sanitize($r['paket_nama']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($r['tanggal_kunjungan'])) ?></td>
                                        <td><span class="badge badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                                        <td>
                                            <a href="https://wa.me/<?= sanitize($r['wa']) ?>?text=Halo <?= urlencode($r['nama']) ?>, terkait reservasi Anda dengan kode <?= $r['kode_pemesanan'] ?> di Desa Wisata Cibuntu..."
                                                class="btn btn-whatsapp-admin btn-sm" target="_blank" title="Chat WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Belum ada pemesanan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center py-4">
                <i class="bi bi-cash-stack text-primary" style="font-size: 2.5rem;"></i>
                <h3 class="mt-2 mb-1"><?= format_harga($total_revenue) ?></h3>
                <p class="text-muted mb-0">Total Pendapatan</p>
            </div>
        </div>

        <div class="card border-0 bg-primary text-white">
            <div class="card-body py-4">
                <h5 class="text-white"><i class="bi bi-lightbulb me-2"></i>Quick Actions</h5>
                <div class="d-grid gap-2 mt-3">
                    <a href="<?= base_url('?page=admin_pemesanan') ?>" class="btn btn-light">
                        <i class="bi bi-receipt me-2"></i>Kelola Pemesanan
                    </a>
                    <a href="<?= base_url('?page=admin_paket') ?>" class="btn btn-light">
                        <i class="bi bi-box-seam me-2"></i>Kelola Paket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>