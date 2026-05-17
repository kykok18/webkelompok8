<?php
$page_title = 'Camping Ground';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();

// Ambil galeri untuk kategori camping
$stmt = $db->prepare("SELECT * FROM galeri WHERE kategori = 'camping' ORDER BY created_at DESC");
$stmt->execute();
$galeri_camping = $stmt->fetchAll();
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Camping</li>
                </ol>
            </nav>
            <h1>Camping Ground</h1>
            <p>Pengalaman menginap di alam terbuka dengan view pegunungan yang memukau</p>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="info-section section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="content-block" data-aos="fade-up">
                    <h2>Camping Ground Cibuntu</h2>
                    <p class="lead">Nikmati pengalaman menginap di alam terbuka dengan fasilitas lengkap dan pemandangan pegunungan yang spektakuler.</p>
                    <p>Camping Ground Cibuntu menyediakan area camping yang luas dan rata, cocok untuk pemula maupun camping enthusiast berpengalaman. Dengan kapasitas hingga 50 tenda, kami siap menampung rombongan besar maupun keluarga.</p>
                    <p>Bangun pagi dan sambut sunrise yang memukau dari atas pegunungan. Udara sejuk dan panorama hijau yang menyejukkan mata akan menjadi pengalaman yang tak terlupakan.</p>
                </div>

                <div class="mt-4" data-aos="fade-up">
                    <h4 class="mb-3">Fasilitas Tersedia</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center py-3">
                                    <i class="bi bi-house-door fs-2 text-primary"></i>
                                    <p class="mb-0 mt-2 small">Toilet Bersih</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center py-3">
                                    <i class="bi bi-moon-stars fs-2 text-primary"></i>
                                    <p class="mb-0 mt-2 small">Mushola</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center py-3">
                                    <i class="bi bi-fire fs-2 text-primary"></i>
                                    <p class="mb-0 mt-2 small">Area BBQ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center py-3">
                                    <i class="bi bi-car-front fs-2 text-primary"></i>
                                    <p class="mb-0 mt-2 small">Parkir Luas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center py-3">
                                    <i class="bi bi-lightning fs-2 text-primary"></i>
                                    <p class="mb-0 mt-2 small">Listrik</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center py-3">
                                    <i class="bi bi-wifi fs-2 text-primary"></i>
                                    <p class="mb-0 mt-2 small">WiFi Area</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Galeri dari Database -->
                <div class="mt-5" data-aos="fade-up">
                    <h3>Galeri Camping</h3>
                    <?php if (count($galeri_camping) > 0): ?>
                        <div class="row g-3 mt-2">
                            <?php foreach ($galeri_camping as $index => $g): ?>
                                <div class="col-6 col-md-4">
                                    <a href="<?= base_url($g['gambar_url']) ?>" data-lightbox="camping" data-title="<?= sanitize($g['judul']) ?>" class="gallery-item">
                                        <img src="<?= base_url($g['gambar_url']) ?>" alt="<?= sanitize($g['judul']) ?>" style="height:200px; width:100%; object-fit:cover;">
                                        <div class="gallery-overlay">
                                            <i class="bi bi-zoom-in"></i>
                                            <span><?= sanitize($g['judul']) ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-images" style="font-size: 2rem;"></i>
                            <p class="mt-2">Belum ada foto galeri camping. Silakan tambahkan melalui admin panel.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" data-aos="fade-left">
                    <div class="card-body p-4">
                        <h4 class="mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi</h4>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-ticket-perforated text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Biaya Camping</strong><span class="text-muted">Mulai Rp 50.000/malam</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-clock text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Jam Check-in</strong><span class="text-muted">14:00 WIB</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-people text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Kapasitas</strong><span class="text-muted">50 tenda</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <i class="bi bi-geo-alt text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Lokasi</strong><span class="text-muted">Area utama desa wisata</span></div>
                        </div>
                        <a href="<?= base_url('?page=reservasi') ?>" class="btn btn-primary-custom w-100">
                            <i class="bi bi-calendar-check me-2"></i>Reservasi Sekarang
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-4" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="bi bi-box-seam me-2 text-primary"></i>Sewa Perlengkapan</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span>Tenda 4 orang</span><strong>Rp 75.000</strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span>Sleeping bag</span><strong>Rp 25.000</strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span>Matras</span><strong>Rp 15.000</strong>
                            </li>
                            <li class="d-flex justify-content-between py-2">
                                <span>Peralatan masak</span><strong>Rp 35.000</strong>
                            </li>
                        </ul>
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
            <h2>Siap Camping di Cibuntu?</h2>
            <p>Book sekarang untuk pengalaman menginap di alam yang tak terlupakan</p>
            <a href="<?= base_url('?page=paket') ?>" class="btn btn-light-custom">
                <i class="bi bi-box-seam me-2"></i>Lihat Paket Camping
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>