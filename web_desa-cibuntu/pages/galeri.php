<?php
$page_title = 'Galeri';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'semua';

if ($kategori && $kategori !== 'semua') {
    $stmt = $db->prepare("SELECT * FROM galeri WHERE kategori = ? ORDER BY created_at DESC");
    $stmt->execute([$kategori]);
} else {
    $stmt = $db->query("SELECT * FROM galeri ORDER BY created_at DESC");
}
$galeri = $stmt->fetchAll();
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Galeri</li>
                </ol>
            </nav>
            <h1>Galeri Foto</h1>
            <p>Dokumentasi keindahan Desa Wisata Cibuntu</p>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="section-padding">
    <div class="container">
        <!-- Filter -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4" data-aos="fade-up">
            <a href="<?= base_url('?page=galeri') ?>"
                class="btn <?= $kategori === 'semua' || !$kategori ? 'btn-success' : 'btn-outline-success' ?> rounded-pill">
                Semua
            </a>
            <a href="<?= base_url('?page=galeri&kategori=curug') ?>"
                class="btn <?= $kategori === 'curug' ? 'btn-success' : 'btn-outline-success' ?> rounded-pill">
                <i class="bi bi-water me-1"></i>Curug
            </a>
            <a href="<?= base_url('?page=galeri&kategori=camping') ?>"
                class="btn <?= $kategori === 'camping' ? 'btn-success' : 'btn-outline-success' ?> rounded-pill">
                <i class="bi bi-tent me-1"></i>Camping
            </a>
            <a href="<?= base_url('?page=galeri&kategori=spotfoto') ?>"
                class="btn <?= $kategori === 'spotfoto' ? 'btn-success' : 'btn-outline-success' ?> rounded-pill">
                <i class="bi bi-camera me-1"></i>Spot Foto
            </a>
            <a href="<?= base_url('?page=galeri&kategori=umum') ?>"
                class="btn <?= $kategori === 'umum' ? 'btn-success' : 'btn-outline-success' ?> rounded-pill">
                <i class="bi bi-images me-1"></i>Umum
            </a>
        </div>

        <!-- Gallery Grid -->
        <?php if (count($galeri) > 0): ?>
            <div class="gallery-grid-full">
                <?php foreach ($galeri as $index => $item): ?>
                    <a href="<?= sanitize($item['gambar_url']) ?>"
                        data-lightbox="gallery"
                        data-title="<?= sanitize($item['judul']) ?>"
                        class="gallery-item"
                        data-aos="zoom-in"
                        data-aos-delay="<?= ($index % 6) * 50 ?>">
                        <img src="<?= sanitize($item['gambar_url']) ?>" alt="<?= sanitize($item['judul']) ?>">
                        <div class="gallery-overlay">
                            <i class="bi bi-zoom-in"></i>
                            <span><?= sanitize($item['judul']) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                <p class="mt-3 text-muted">Belum ada foto dalam kategori ini</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content text-center" data-aos="zoom-in">
            <h2>Ingin Mengunjungi Cibuntu?</h2>
            <p>Lihat paket wisata kami dan mulai petualangan Anda</p>
            <a href="<?= base_url('?page=paket') ?>" class="btn btn-light-custom">
                <i class="bi bi-box-seam me-2"></i>Lihat Paket Wisata
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>