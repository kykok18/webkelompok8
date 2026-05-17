<?php
$page_title = 'Beranda';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();
$stmt = $db->query("SELECT * FROM paket_wisata WHERE status = 'aktif' ORDER BY urutan ASC");
$pakets = $stmt->fetchAll();

$stmt = $db->query("SELECT * FROM galeri ORDER BY created_at DESC LIMIT 6");
$galeri = $stmt->fetchAll();

$stmt = $db->query("SELECT * FROM testimoni WHERE status = 'approved' ORDER BY created_at DESC LIMIT 3");
$testimoni = $stmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-slider">
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=1920')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1920')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1920')"></div>
    </div>

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <span class="hero-badge" data-aos="fade-down">
            <i class="bi bi-geo-alt-fill me-1"></i> Kuningan, Jawa Barat
        </span>
        <h1 data-aos="fade-up" data-aos-delay="100">Desa Wisata Cibuntu</h1>
        <p data-aos="fade-up" data-aos-delay="200">Temukan keindahan alam pegunungan yang memukau dengan curug menawan, area camping nyaman, dan spot foto instagramable</p>
        <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
            <a href="<?= base_url('?page=paket') ?>" class="btn btn-primary-custom">
                <i class="bi bi-box-seam me-2"></i>Lihat Paket
            </a>
            <a href="<?= base_url('?page=reservasi') ?>" class="btn btn-outline-custom">
                <i class="bi bi-calendar-check me-2"></i>Reservasi Sekarang
            </a>
        </div>
    </div>

    <div class="hero-indicators">
        <button class="active" data-slide="0"></button>
        <button data-slide="1"></button>
        <button data-slide="2"></button>
        <button data-slide="3"></button>
    </div>

    <div class="scroll-indicator">
        <div class="mouse">
            <div class="wheel"></div>
        </div>
        <span>Scroll ke bawah</span>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="0">
                <div class="stat-card">
                    <i class="bi bi-water"></i>
                    <h3 class="counter" data-target="3">0</h3>
                    <p>Curug Indah</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <i class="bi bi-house-door"></i>
                    <h3 class="counter" data-target="50">0</h3>
                    <p>Area Camping</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <i class="bi bi-camera"></i>
                    <h3 class="counter" data-target="15">0</h3>
                    <p>Spot Foto</p>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <i class="bi bi-people"></i>
                    <h3 class="counter" data-target="10000">0</h3>
                    <p>Pengunjung/Tahun</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Destinasi Section -->
<section class="destinasi-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-compass me-1"></i>Destinasi Unggulan</span>
            <h2>Temukan Keindahan<br>Desa Wisata Cibuntu</h2>
            <p>Berbagai pilihan destinasi wisata alam yang siap memanjakan mata dan jiwa Anda</p>
        </div>

        <div class="row g-4 mt-4">
            <!-- Curug Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="destinasi-card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=600&q=80" alt="Curug Cibuntu">
                        <div class="card-overlay">
                            <span class="card-category"><i class="bi bi-water me-1"></i>Curug</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h4>Curug Cibuntu</h4>
                        <p>Air terjun indah dengan ketinggian 15 meter yang dikelilingi hutan pinus alami. Air jernih dan udara sejuk pegunungan.</p>
                        <div class="card-info">
                            <span><i class="bi bi-geo-alt"></i> 500m dari pintu masuk</span>
                            <span><i class="bi bi-clock"></i> 30 menit trekking</span>
                        </div>
                        <a href="<?= base_url('?page=curug') ?>" class="btn-card">
                            Lihat Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Camping Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="destinasi-card featured">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&q=80" alt="Camping Ground">
                        <div class="card-overlay">
                            <span class="card-category"><i class="bi bi-house-door me-1"></i>Camping</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h4>Camping Ground</h4>
                        <p>Area camping luas dengan view pegunungan. Fasilitas lengkap termasuk toilet, mushola, dan area BBQ.</p>
                        <div class="card-info">
                            <span><i class="bi bi-people"></i> Kapasitas 50 tenda</span>
                            <span><i class="bi bi-star-fill"></i> Rating 4.8/5</span>
                        </div>
                        <a href="<?= base_url('?page=camping') ?>" class="btn-card">
                            Lihat Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spot Foto Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="destinasi-card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80" alt="Spot Foto">
                        <div class="card-overlay">
                            <span class="card-category"><i class="bi bi-camera me-1"></i>Spot Foto</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <h4>Spot Foto Instagramable</h4>
                        <p>15+ spot foto dengan latar pegunungan yang memukau. Cocok untuk content creator dan pecinta foto.</p>
                        <div class="card-info">
                            <span><i class="bi bi-camera-fill"></i> 15+ spot</span>
                            <span><i class="bi bi-heart-fill"></i> Instagram ready</span>
                        </div>
                        <a href="<?= base_url('?page=spotfoto') ?>" class="btn-card">
                            Lihat Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-images">
                    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhOLCdFBVIDVT4T3Q4wuVDQbKJOYl5clcALRUJpo6KRhl-Az8O3Ie_WpHHAFuSmJK9OMZ7rhdyuP6UgJpYEDx0HPfeqO8m3DZSCKtm8AOxfpGc236wPrPdMYpmWEhPNbf-xVWpVLsx4qJ_rRlSqoBI8xYyWN2vq7kvUvj3rKRzrara0GrI6b-J8dXjGkYJU/s1600/desa%20wisata%20cibuntu.jpeg" alt="Pegunungan" class="img-main">
                    <img src="https://cdn.visiteliti.com/article/2021-06/02/Q7kJT0u29uYk0Svca5QI_1622617503.jpg" alt="Air Terjun" class="img-secondary">
                    <div class="experience-badge">
                        <span class="number">10+</span>
                        <span class="text">Tahun<br>Pengalaman</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-badge"><i class="bi bi-info-circle me-1"></i>Tentang Kami</span>
                    <h2>Keindahan Alam yang<br>Menyegarkan Jiwa</h2>
                    <p class="lead">Desa Wisata Cibuntu adalah destinasi wisata alam yang terletak di kaki pegunungan Kuningan, Jawa Barat.</p>
                    <p>Dengan udara sejuk, pemandangan hijau yang menyejukkan, dan berbagai fasilitas wisata yang lengkap, kami hadir untuk memberikan pengalaman liburan yang tak terlupakan bagi Anda dan keluarga.</p>

                    <div class="about-features">
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Fasilitas lengkap dan terawat</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Harga terjangkau untuk semua</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Pemandu wisata berpengalaman</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Aman untuk anak-anak</span>
                        </div>
                    </div>

                    <a href="<?= base_url('?page=kontak') ?>" class="btn btn-primary-custom mt-3">
                        <i class="bi bi-telephone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paket Section -->
<section class="paket-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-box-seam me-1"></i>Paket Wisata</span>
            <h2>Pilih Paket<br>Liburan Anda</h2>
            <p>Berbagai pilihan paket wisata dengan harga terjangkau untuk semua kalangan</p>
        </div>

        <div class="row g-4 mt-4">
            <?php foreach ($pakets as $index => $paket): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="paket-card <?= $paket['highlight'] === 'ya' ? 'featured' : '' ?>">
                        <?php if ($paket['highlight'] === 'ya'): ?>
                            <div class="paket-badge">Best Seller</div>
                        <?php endif; ?>
                        <div class="paket-header">
                            <h4><?= sanitize($paket['nama_paket']) ?></h4>
                            <div class="paket-price">
                                <span class="currency">Rp</span>
                                <span class="amount"><?= number_format($paket['harga'], 0, ',', '.') ?></span>
                                <span class="period">/ orang</span>
                            </div>
                        </div>
                        <div class="paket-body">
                            <p><?= sanitize($paket['deskripsi']) ?></p>
                            <div class="paket-info">
                                <i class="bi bi-clock"></i>
                                <span><?= sanitize($paket['durasi']) ?></span>
                            </div>
                            <div class="paket-fasilitas">
                                <h5>Fasilitas:</h5>
                                <ul>
                                    <?php foreach (explode(',', $paket['fasilitas']) as $fas): ?>
                                        <li><i class="bi bi-check2"></i> <?= sanitize(trim($fas)) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="paket-footer">
                            <a href="<?= base_url('?page=reservasi&paket=' . $paket['id']) ?>" class="btn btn-paket">
                                <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('?page=paket') ?>" class="btn btn-outline-custom" style="border-color: var(--primary); color: var(--primary);">
                Lihat Semua Paket <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-images me-1"></i>Galeri</span>
            <h2>Momen Indah<br>di Cibuntu</h2>
            <p>Dokumentasi keindahan dan kegiatan di Desa Wisata Cibuntu</p>
        </div>

        <div class="gallery-grid mt-4">
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

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('?page=galeri') ?>" class="btn btn-primary-custom">
                <i class="bi bi-images me-2"></i>Lihat Semua Galeri
            </a>
        </div>
    </div>
</section>

<!-- Testimoni Section -->
<section class="testimoni-section section-padding">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-chat-quote me-1"></i>Testimoni</span>
            <h2>Kata Mereka<br>Tentang Kami</h2>
            <p>Pengalaman nyata dari pengunjung yang telah menikmati keindahan Cibuntu</p>
        </div>

        <div class="row g-4 mt-4">
            <?php foreach ($testimoni as $index => $t): ?>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="testimoni-card">
                        <div class="testimoni-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $t['rating'] ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="testimoni-text">"<?= sanitize($t['komentar']) ?>"</p>
                        <div class="testimoni-author">
                            <div class="testimoni-avatar">
                                <?= strtoupper(substr($t['nama'], 0, 1)) ?>
                            </div>
                            <div class="testimoni-info">
                                <h5><?= sanitize($t['nama']) ?></h5>
                                <span><?= sanitize($t['lokasi']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>Siap Merencanakan Liburan?</h2>
            <p>Hubungi kami sekarang untuk informasi dan reservasi. Tim kami siap membantu Anda merencanakan liburan impian.</p>
            <div class="cta-buttons">
                <a href="https://wa.me/<?= wa_admin() ?>?text=Halo, saya ingin reservasi di Desa Wisata Cibuntu"
                    class="btn btn-light-custom" target="_blank">
                    <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                </a>
                <a href="<?= base_url('?page=reservasi') ?>" class="btn btn-outline-light-custom">
                    <i class="bi bi-calendar-check me-2"></i>Form Reservasi
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>