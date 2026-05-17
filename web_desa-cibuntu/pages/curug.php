<?php
$page_title = 'Curug Cibuntu';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();

// Ambil galeri untuk kategori curug
$stmt = $db->prepare("SELECT * FROM galeri WHERE kategori = 'curug' ORDER BY created_at DESC");
$stmt->execute();
$galeri_curug = $stmt->fetchAll();
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Curug</li>
                </ol>
            </nav>
            <h1>Curug Cibuntu</h1>
            <p>Air terjun indah di tengah hutan pinus dengan udara sejuk pegunungan</p>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="info-section section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="content-block" data-aos="fade-up">
                    <h2>Keindahan Curug Cibuntu</h2>
                    <p class="lead">Curug Cibuntu adalah air terjun alami dengan ketinggian sekitar 15 meter yang terletak di kawasan hutan pinus Desa Cibuntu, Kuningan.</p>
                    <p>Tersembunyi di balik pepohonan pinus yang rimbun, curug ini menawarkan pengalaman wisata alam yang tak terlupakan. Air yang jernih dan segar mengalir dari ketinggian, membentuk kolam alami di bawahnya yang cocok untuk bermain air atau sekadar merendam kaki.</p>
                    <p>Perjalanan menuju curug ini sendiri sudah merupakan pengalaman yang menyenangkan. Anda akan melewati jalur setapak yang dikelilingi pepohonan rimbun dengan kicauan burung yang menemani perjalanan.</p>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="0">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-primary me-3" style="width:50px;height:50px;font-size:1.25rem;"><i class="bi bi-water"></i></div>
                                    <h5 class="mb-0">Air Jernih</h5>
                                </div>
                                <p class="text-muted mb-0">Air terjun dengan kualitas air jernih dan segar langsung dari mata air pegunungan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-success me-3" style="width:50px;height:50px;font-size:1.25rem;"><i class="bi bi-tree-fill"></i></div>
                                    <h5 class="mb-0">Hutan Pinus</h5>
                                </div>
                                <p class="text-muted mb-0">Dikelilingi hutan pinus yang rimbun dan sejuk, cocok untuk healing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-warning me-3" style="width:50px;height:50px;font-size:1.25rem;"><i class="bi bi-camera"></i></div>
                                    <h5 class="mb-0">Spot Foto</h5>
                                </div>
                                <p class="text-muted mb-0">Banyak sudut foto yang instagramable dengan latar air terjun yang memukau.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-info me-3" style="width:50px;height:50px;font-size:1.25rem;"><i class="bi bi-shield-check"></i></div>
                                    <h5 class="mb-0">Aman</h5>
                                </div>
                                <p class="text-muted mb-0">Kawasan aman untuk seluruh keluarga dengan pemandu yang berpengalaman.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Galeri dari Database -->
                <div class="mt-5" data-aos="fade-up">
                    <h3>Galeri Curug</h3>
                    <?php if (count($galeri_curug) > 0): ?>
                        <div class="row g-3 mt-2">
                            <?php foreach ($galeri_curug as $index => $g): ?>
                                <div class="col-6 col-md-4">
                                    <a href="<?= base_url($g['gambar_url']) ?>" data-lightbox="curug" data-title="<?= sanitize($g['judul']) ?>" class="gallery-item">
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
                            <p class="mt-2">Belum ada foto galeri curug. Silakan tambahkan melalui admin panel.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-left">
                    <div class="card-body p-4">
                        <h4 class="mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi</h4>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-ticket-perforated text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Tiket Masuk</strong><span class="text-muted">Rp 15.000/orang</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-clock text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Jam Operasional</strong><span class="text-muted">07:00 - 17:00 WIB</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-geo-alt text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Lokasi</strong><span class="text-muted">500m dari pintu masuk</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <i class="bi bi-signpost-2 text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Waktu Tempuh</strong><span class="text-muted">30 menit trekking</span></div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <i class="bi bi-person-walking text-primary fs-4 me-3"></i>
                            <div><strong class="d-block">Tingkat Kesulitan</strong><span class="text-muted">Mudah - Sedang</span></div>
                        </div>
                        <a href="<?= base_url('?page=reservasi') ?>" class="btn btn-primary-custom w-100">
                            <i class="bi bi-calendar-check me-2"></i>Reservasi Sekarang
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="bi bi-lightbulb me-2 text-warning"></i>Tips Berkunjung</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Bawa pakaian ganti</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Gunakan sepatu nyaman</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Bawa kamera</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Jaga kebersihan</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Kunjungi pagi hari</li>
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
            <h2>Ingin Mengunjungi Curug Cibuntu?</h2>
            <p>Hubungi kami untuk informasi lebih lanjut atau reservasi paket wisata</p>
            <a href="<?= base_url('?page=paket') ?>" class="btn btn-light-custom">
                <i class="bi bi-box-seam me-2"></i>Lihat Paket Wisata
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>