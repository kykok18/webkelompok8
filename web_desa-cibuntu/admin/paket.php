<?php
$page_title = 'Manajemen Paket Wisata';

$db = getDB();

function upload_gambar(array $file, string $folder, int $maxSizeMB = 2): array
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Gagal mengunggah gambar.'];
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        return ['success' => false, 'error' => 'Format gambar tidak valid.'];
    }

    if ($file['size'] > $maxSizeMB * 1024 * 1024) {
        return ['success' => false, 'error' => 'Ukuran gambar tidak boleh lebih dari ' . $maxSizeMB . 'MB.'];
    }

    $uploadDir = rtrim(UPLOAD_PATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($folder, DIRECTORY_SEPARATOR);
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid('img_', true) . '.' . $extension;
    $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => false, 'error' => 'Gagal memindahkan file gambar.'];
    }

    return ['success' => true, 'file' => $filename];
}

// Handle Add/Edit dengan UPLOAD GAMBAR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nama_paket = sanitize($_POST['nama_paket']);
    $deskripsi = sanitize($_POST['deskripsi']);
    $harga = (int)str_replace(['.', ','], '', $_POST['harga']);
    $fasilitas = sanitize($_POST['fasilitas']);
    $durasi = sanitize($_POST['durasi']);
    $highlight = sanitize($_POST['highlight']);
    $status = sanitize($_POST['status']);
    $urutan = (int)($_POST['urutan'] ?? 0);

    // Ambil gambar lama jika edit
    $gambar = '';
    if ($id > 0) {
        $stmt = $db->prepare("SELECT gambar FROM paket_wisata WHERE id = ?");
        $stmt->execute([$id]);
        $old = $stmt->fetch(PDO::FETCH_ASSOC);
        $gambar = $old['gambar'] ?? '';
    }

    // Upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $upload = upload_gambar($_FILES['gambar'], 'paket', 2);
        if ($upload['success']) {
            // Hapus gambar lama jika ada
            if ($gambar && file_exists(UPLOAD_PATH . 'paket/' . $gambar)) {
                unlink(UPLOAD_PATH . 'paket/' . $gambar);
            }
            $gambar = $upload['file'];
        } else {
            set_flash('error', $upload['error']);
            header('Location: ' . base_url('?ade=admin_paket'));
            exit;
        }
    }

    try {
        if ($id > 0) {
            $stmt = $db->prepare("UPDATE paket_wisata SET nama_paket=?, deskripsi=?, harga=?, fasilitas=?, durasi=?, gambar=?, highlight=?, status=?, urutan=? WHERE id=?");
            $stmt->execute([$nama_paket, $deskripsi, $harga, $fasilitas, $durasi, $gambar, $highlight, $status, $urutan, $id]);
            set_flash('success', 'Paket berhasil diperbarui');
        } else {
            $stmt = $db->prepare("INSERT INTO paket_wisata (nama_paket, deskripsi, harga, fasilitas, durasi, gambar, highlight, status, urutan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama_paket, $deskripsi, $harga, $fasilitas, $durasi, $gambar, $highlight, $status, $urutan]);
            set_flash('success', 'Paket berhasil ditambahkan');
        }
    } catch (PDOException $e) {
        set_flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    header('Location: ' . base_url('?admin=admin_paket'));
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("SELECT gambar FROM paket_wisata WHERE id = ?");
    $stmt->execute([$id]);
    $del = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($del && $del['gambar'] && file_exists(UPLOAD_PATH . 'paket/' . $del['gambar'])) {
        unlink(UPLOAD_PATH . 'paket/' . $del['gambar']);
    }

    $stmt = $db->prepare("DELETE FROM paket_wisata WHERE id = ?");
    $stmt->execute([$id]);
    set_flash('success', 'Paket berhasil dihapus');
    header('Location: ' . base_url('?page=admin_paket'));
    exit;
}

require_once __DIR__ . '/includes/header.php';

// Get Data
$pakets = $db->query("SELECT * FROM paket_wisata ORDER BY urutan ASC, id DESC")->fetchAll();
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM paket_wisata WHERE id = ?");
    $stmt->execute([$id]);
    $edit = $stmt->fetch();
}

?>



<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-<?= $edit ? 'pencil' : 'plus' ?>-circle me-2"></i><?= $edit ? 'Edit Paket' : 'Tambah Paket Baru' ?></h5>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Paket <span class="text-danger">*</span></label>
                    <input type="text" name="nama_paket" class="form-control" required value="<?= $edit['nama_paket'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                    <input type="text" name="harga" class="form-control" required value="<?= isset($edit['harga']) ? number_format($edit['harga'], 0, ',', '.') : '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="durasi" class="form-control" placeholder="cth: 3-4 Jam" value="<?= $edit['durasi'] ?? '' ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= $edit['deskripsi'] ?? '' ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Fasilitas <small class="text-muted">(pisahkan dengan koma)</small></label>
                    <input type="text" name="fasilitas" class="form-control" placeholder="Tiket masuk, Pemandu, Makan siang" value="<?= $edit['fasilitas'] ?? '' ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gambar Paket</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this, 'previewPaket')">
                    <div class="form-text">Format: JPG, PNG, GIF, WEBP. Maks 2MB</div>
                    <?php if ($edit && $edit['gambar'] && file_exists(UPLOAD_PATH . 'paket/' . $edit['gambar'])): ?>
                        <div class="mt-2">
                            <img src="<?= base_url('uploads/paket/' . $edit['gambar']) ?>" id="previewPaket" class="rounded" style="max-width:150px; max-height:100px;">
                            <p class="small text-muted mt-1">Gambar saat ini</p>
                        </div>
                    <?php else: ?>
                        <img id="previewPaket" class="mt-2 rounded" style="max-width:150px; max-height:100px; display:none;">
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="<?= $edit['urutan'] ?? '1' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Highlight</label>
                    <select name="highlight" class="form-select">
                        <option value="tidak" <?= ($edit['highlight'] ?? '') === 'tidak' ? 'selected' : '' ?>>Tidak</option>
                        <option value="ya" <?= ($edit['highlight'] ?? '') === 'ya' ? 'selected' : '' ?>>Ya</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" <?= ($edit['status'] ?? '') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= ($edit['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check me-1"></i>Simpan
                    </button>
                    <?php if ($edit): ?>
                        <a href="<?= base_url('?page=admin_paket') ?>" class="btn btn-outline-secondary">Batal</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Paket (<?= count($pakets) ?>)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Gambar</th>
                        <th>Paket</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pakets as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <?php if ($p['gambar'] && file_exists(UPLOAD_PATH . 'paket/' . $p['gambar'])): ?>
                                    <img src="<?= base_url('uploads/paket/' . $p['gambar']) ?>" style="width:60px;height:40px;object-fit:cover;border-radius:6px">
                                <?php else: ?>
                                    <div style="width:60px;height:40px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#999;font-size:10px;">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= sanitize($p['nama_paket']) ?></strong>
                                <?php if ($p['highlight'] === 'ya'): ?>
                                    <span class="badge bg-warning text-dark ms-1">Populer</span>
                                <?php endif; ?>
                                <br><small class="text-muted"><?= sanitize($p['durasi']) ?></small>
                            </td>
                            <td><?= format_harga($p['harga']) ?></td>
                            <td>
                                <?php if ($p['status'] === 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?page=admin_paket&edit=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="?page=admin_paket&delete=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus paket ini?')">
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