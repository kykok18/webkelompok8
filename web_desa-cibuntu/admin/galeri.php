<?php
require_once __DIR__ . '/../inc/config.php';

// 1. Cek Login (sebelum output HTML)
if (!is_admin()) {
    header('Location: ' . base_url('?page=admin_login'));
    exit;
}

$db = getDB();

function upload_gambar(array $file, string $folder = 'galeri', int $maxSizeMB = 2): array
{
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'error' => 'File tidak valid'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'Ukuran file melebihi batas server',
            UPLOAD_ERR_FORM_SIZE => 'Ukuran file melebihi batas maksimum',
            UPLOAD_ERR_PARTIAL => 'Upload file terputus',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diunggah',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder sementara tidak tersedia',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menyimpan file',
            UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi',
        ];
        $message = $errorMessages[$file['error']] ?? 'Terjadi kesalahan saat mengupload file';
        return ['success' => false, 'error' => $message];
    }

    if ($file['size'] > ($maxSizeMB * 1024 * 1024)) {
        return ['success' => false, 'error' => "Ukuran file maksimal {$maxSizeMB}MB"];
    }

    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        return ['success' => false, 'error' => 'File bukan gambar yang valid'];
    }

    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($allowedTypes[$check['mime']])) {
        return ['success' => false, 'error' => 'Format gambar tidak didukung'];
    }

    $extension = $allowedTypes[$check['mime']];
    $uploadBase = realpath(__DIR__ . '/../uploads');
    if ($uploadBase === false) {
        $uploadBase = __DIR__ . '/../uploads';
    }

    $targetDir = $uploadBase . DIRECTORY_SEPARATOR . trim($folder, '/\\');
    if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
        return ['success' => false, 'error' => 'Tidak dapat membuat folder upload'];
    }

    $fileName = uniqid('galeri_', true) . '.' . $extension;
    $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => false, 'error' => 'Gagal memindahkan file gambar'];
    }

    $relativePath = 'uploads/' . trim($folder, '/\\') . '/' . $fileName;
    $relativePath = str_replace(['\\', '/'], '/', $relativePath);

    return ['success' => true, 'path' => $relativePath];
}

function hapus_file($filePath)
{
    if (!preg_match('#^([a-zA-Z]:\\\\|/|\\\\\\\\)#', $filePath)) {
        $filePath = realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR . ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filePath), DIRECTORY_SEPARATOR);
    }
    if ($filePath && file_exists($filePath) && is_file($filePath)) {
        @unlink($filePath);
    }
}

// 2. Handle All POST/GET requests BEFORE outputting HTML
// Handle Add dengan UPLOAD FILE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $judul = sanitize($_POST['judul']);
    $deskripsi = sanitize($_POST['deskripsi']);
    $kategori = sanitize($_POST['kategori']);

    if (!empty($_FILES['gambar']['name'])) {
        $upload = upload_gambar($_FILES['gambar'], 'galeri', 2);
        if ($upload['success']) {
            $stmt = $db->prepare("INSERT INTO galeri (judul, deskripsi, gambar_url, kategori) VALUES (?, ?, ?, ?)");
            $stmt->execute([$judul, $deskripsi, $upload['path'], $kategori]);
            set_flash('success', 'Foto berhasil ditambahkan');
        } else {
            set_flash('error', $upload['error']);
        }
    } else {
        set_flash('error', 'Pilih file gambar terlebih dahulu');
    }
    header('Location: ' . base_url('?page=admin_galeri'));
    exit;
}

// Handle Edit
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $judul = sanitize($_POST['judul']);
    $deskripsi = sanitize($_POST['deskripsi']);
    $kategori = sanitize($_POST['kategori']);

    // Cek apakah upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $upload = upload_gambar($_FILES['gambar'], 'galeri', 2);
        if ($upload['success']) {
            // Hapus gambar lama
            $stmt = $db->prepare("SELECT gambar_url FROM galeri WHERE id = ?");
            $stmt->execute([$id]);
            $old = $stmt->fetch();
            if ($old && $old['gambar_url']) {
                hapus_file($old['gambar_url']);
            }
            // Update dengan gambar baru
            $stmt = $db->prepare("UPDATE galeri SET judul = ?, deskripsi = ?, gambar_url = ?, kategori = ? WHERE id = ?");
            $stmt->execute([$judul, $deskripsi, $upload['path'], $kategori, $id]);
        } else {
            set_flash('error', $upload['error']);
            header('Location: ' . base_url('?page=admin_galeri'));
            exit;
        }
    } else {
        // Update tanpa mengganti gambar
        $stmt = $db->prepare("UPDATE galeri SET judul = ?, deskripsi = ?, kategori = ? WHERE id = ?");
        $stmt->execute([$judul, $deskripsi, $kategori, $id]);
    }
    set_flash('success', 'Foto berhasil diperbarui');
    header('Location: ' . base_url('?page=admin_galeri'));
    exit;
}

// Handle Delete
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $db->prepare("SELECT gambar_url FROM galeri WHERE id = ?");
    $stmt->execute([$id]);
    $del = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($del) {
        hapus_file($del['gambar_url']);
        $stmt = $db->prepare("DELETE FROM galeri WHERE id = ?");
        $stmt->execute([$id]);
        set_flash('success', 'Foto berhasil dihapus');
    }
    header('Location: ' . base_url('?page=admin_galeri'));
    exit;
}

// 3. Set page title and include header (HTML OUTPUT BEGINS HERE)
$page_title = 'Manajemen Galeri';
require_once __DIR__ . '/includes/header.php';

// 4. Get data untuk edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM galeri WHERE id = ?");
    $stmt->execute([$id]);
    $edit = $stmt->fetch();
}

// 5. Filter kategori dan ambil galeri
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';
if ($filter != 'semua') {
    $stmt = $db->prepare("SELECT * FROM galeri WHERE kategori = ? ORDER BY created_at DESC");
    $stmt->execute([$filter]);
} else {
    $stmt = $db->query("SELECT * FROM galeri ORDER BY created_at DESC");
}
$galeri = $stmt->fetchAll();
?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-<?= $edit ? 'pencil' : 'plus' ?>-circle me-2"></i><?= $edit ? 'Edit Foto' : 'Tambah Foto Baru' ?></h5>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
            <?php endif; ?>

            <div class="col-md-6">
                <label class="form-label">Judul Foto <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" required value="<?= $edit['judul'] ?? '' ?>" placeholder="Contoh: Sky Deck">
            </div>

            <div class="col-md-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select" required>
                    <option value="umum" <?= ($edit['kategori'] ?? '') == 'umum' ? 'selected' : '' ?>>Umum</option>
                    <option value="curug" <?= ($edit['kategori'] ?? '') == 'curug' ? 'selected' : '' ?>>Curug</option>
                    <option value="camping" <?= ($edit['kategori'] ?? '') == 'camping' ? 'selected' : '' ?>>Camping</option>
                    <option value="spotfoto" <?= ($edit['kategori'] ?? '') == 'spotfoto' ? 'selected' : '' ?>>Spot Foto</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Gambar</label>
                <?php if ($edit): ?>
                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this, 'previewGal')">
                    <div class="form-text">Kosongkan jika tidak ingin mengubah gambar</div>
                    <img id="previewGal" class="mt-2 rounded" style="max-width:150px; max-height:100px; display:none;">
                    <?php if ($edit['gambar_url']): ?>
                        <div class="mt-2">
                            <img src="<?= base_url($edit['gambar_url']) ?>" style="max-width:150px; max-height:100px;" class="rounded border">
                            <p class="small text-muted mt-1">Gambar saat ini</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <input type="file" name="gambar" class="form-control" accept="image/*" required onchange="previewImage(this, 'previewGal')">
                    <div class="form-text">Format: JPG, PNG, GIF, WEBP. Maks 2MB</div>
                    <img id="previewGal" class="mt-2 rounded" style="max-width:150px; max-height:100px; display:none;">
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat tentang foto ini..."><?= $edit['deskripsi'] ?? '' ?></textarea>
                <div class="form-text">Deskripsi akan ditampilkan di halaman galeri dan spot foto.</div>
            </div>

            <div class="col-12">
                <button type="submit" name="<?= $edit ? 'edit' : 'tambah' ?>" class="btn btn-primary-custom">
                    <i class="bi bi-<?= $edit ? 'check' : 'plus' ?> me-1"></i><?= $edit ? 'Update' : 'Tambah' ?>
                </button>
                <?php if ($edit): ?>
                    <a href="<?= base_url('?page=admin_galeri') ?>" class="btn btn-outline-secondary">Batal</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="bi bi-images me-2"></i>Daftar Galeri (<?= count($galeri) ?>)</h5>
        <div class="btn-group btn-group-sm">
            <a href="?page=admin_galeri" class="btn btn-outline-secondary <?= $filter == 'semua' ? 'active' : '' ?>">Semua</a>
            <a href="?page=admin_galeri&filter=curug" class="btn btn-outline-secondary <?= $filter == 'curug' ? 'active' : '' ?>">Curug</a>
            <a href="?page=admin_galeri&filter=camping" class="btn btn-outline-secondary <?= $filter == 'camping' ? 'active' : '' ?>">Camping</a>
            <a href="?page=admin_galeri&filter=spotfoto" class="btn btn-outline-secondary <?= $filter == 'spotfoto' ? 'active' : '' ?>">Spot Foto</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (count($galeri) > 0): ?>
            <div class="row g-3">
                <?php foreach ($galeri as $g): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 border">
                            <img src="<?= base_url($g['gambar_url']) ?>" class="card-img-top" style="height:160px;object-fit:cover;" alt="">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 text-truncate"><?= sanitize($g['judul']) ?></h6>
                                <?php if ($g['deskripsi']): ?>
                                    <p class="small text-muted mb-1" style="font-size:11px;"><?= sanitize(substr($g['deskripsi'], 0, 50)) ?>...</p>
                                <?php endif; ?>
                                <span class="badge bg-light text-dark mb-2"><?= ucfirst($g['kategori']) ?></span>
                                <div class="d-flex gap-1">
                                    <a href="?page=admin_galeri&edit=<?= $g['id'] ?>" class="btn btn-sm btn-outline-primary flex-grow-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="?page=admin_galeri&hapus=<?= $g['id'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus foto ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-images" style="font-size: 3rem;"></i>
                <p class="mt-2">Belum ada foto di galeri</p>
                <p class="small">Silakan upload foto menggunakan form di atas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>