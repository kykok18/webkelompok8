<?php
$page_title = 'Pengaturan Website';
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key !== 'submit') {
            $stmt = $db->prepare("UPDATE pengaturan SET setting_value = ? WHERE setting_key = ?");
            $stmt->execute([sanitize($value), sanitize($key)]);
        }
    }
    set_flash('success', 'Pengaturan berhasil disimpan');
    header('Location: ' . base_url('?page=admin_pengaturan'));
    exit;
}

// Get Settings
$settings = [];
$stmt = $db->query("SELECT * FROM pengaturan");
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Pengaturan Umum</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor WhatsApp Admin</label>
                    <input type="text" name="wa_admin" class="form-control" value="<?= $settings['wa_admin'] ?? '' ?>" placeholder="628xxx">
                    <small class="text-muted">Format: 62812345678 (tanpa + atau 0)</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Admin</label>
                    <input type="email" name="email_admin" class="form-control" value="<?= $settings['email_admin'] ?? '' ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= $settings['alamat'] ?? '' ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="<?= $settings['telepon'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jam Buka</label>
                    <input type="time" name="jam_buka" class="form-control" value="<?= $settings['jam_buka'] ?? '07:00' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jam Tutup</label>
                    <input type="time" name="jam_tutup" class="form-control" value="<?= $settings['jam_tutup'] ?? '17:00' ?>">
                </div>

                <hr class="my-4">
                <h5>Sosial Media</h5>

                <div class="col-md-6">
                    <label class="form-label">Facebook URL</label>
                    <input type="url" name="facebook" class="form-control" value="<?= $settings['facebook'] ?? '' ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Instagram URL</label>
                    <input type="url" name="instagram" class="form-control" value="<?= $settings['instagram'] ?? '' ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">YouTube URL</label>
                    <input type="url" name="youtube" class="form-control" value="<?= $settings['youtube'] ?? '' ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">TikTok URL</label>
                    <input type="url" name="tiktok" class="form-control" value="<?= $settings['tiktok'] ?? '' ?>">
                </div>

                <div class="col-12">
                    <button type="submit" name="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check me-1"></i>Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>