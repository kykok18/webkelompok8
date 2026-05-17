<?php
$page_title = 'Spot Foto';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();

// Ambil galeri untuk kategori spotfoto
$stmt = $db->prepare("SELECT * FROM galeri WHERE kategori = 'spotfoto' ORDER BY created_at DESC");
$stmt->execute();
$galeri_spotfoto = $stmt->fetchAll();

// Jika tidak ada data, tampilkan pesan
$no_data = empty($galeri_spotfoto);
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Spot Foto</li>
                </ol>
            </nav>
            <h1>Spot Foto Instagramable</h1>
            <p>15+ lokasi foto dengan latar pegunungan yang memukau</p>
        </div>
    </div>
</section>

<!-- Spots Section -->
<section class="section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-camera me-1"></i>Spot Foto</span>
            <h2>Lokasi Foto<br>Instagramable</h2>
            <p>Berbagai spot foto menarik yang siap mempercantik feed Instagram Anda</p>
        </div>

        <?php if ($no_data): ?>
            <div class="text-center py-5">
                <i class="bi bi-camera" style="font-size: 4rem; color: var(--text-muted);"></i>
                <h4 class="mt-3 text-muted">Belum Ada Spot Foto</h4>
                <p class="text-muted">Silakan login sebagai admin untuk menambahkan spot foto.</p>
                <a href="<?= base_url('?page=admin_login') ?>" class="btn btn-primary-custom mt-3">Login Admin</a>
            </div>
        <?php else: ?>
            <div class="row g-4 mt-4">
                <?php foreach ($galeri_spotfoto as $index => $spot): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="destinasi-card h-100">
                            <div class="card-image">
                                <img src="<?= base_url($spot['gambar_url']) ?>" alt="<?= sanitize($spot['judul']) ?>">
                                <div class="card-overlay">
                                    <span class="card-category">
                                        <i class="bi bi-camera me-1"></i><?= sprintf('%02d', $index + 1) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-content">
                                <h4><?= sanitize($spot['judul']) ?></h4>
                                <p><?= sanitize($spot['deskripsi'] ?: 'Spot foto menarik dengan latar alam yang instagramable.') ?></p>
                                <span class="badge bg-light text-primary">Spot Populer</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 bg-light" data-aos="fade-up">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2"><i class="bi bi-lightbulb me-2 text-warning"></i>Tips Foto</h5>
                                <ul class="mb-0 small">
                                    <li>Waktu terbaik: Pagi (06:00-09:00) atau sore (15:00-17:00)</li>
                                    <li>Bawa kamera atau smartphone dengan baterai penuh</li>
                                    <li>Kenakan pakaian yang colorful untuk kontras dengan background hijau</li>
                                </ul>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="<?= base_url('?page=reservasi') ?>" class="btn btn-primary-custom">
                                    <i class="bi bi-calendar-check me-2"></i>Reservasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content text-center" data-aos="zoom-in">
            <h2>Siap Foto-Foto di Cibuntu?</h2>
            <p>Kunjungi sekarang dan abadikan momen indah Anda</p>
            <a href="<?= base_url('?page=paket') ?>" class="btn btn-light-custom">
                <i class="bi bi-box-seam me-2"></i>Lihat Paket Wisata
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>