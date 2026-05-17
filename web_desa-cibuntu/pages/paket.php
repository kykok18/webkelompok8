<?php
$page_title = 'Paket Wisata';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();
$stmt = $db->query("SELECT * FROM paket_wisata WHERE status = 'aktif' ORDER BY urutan ASC");
$pakets = $stmt->fetchAll();
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Paket Wisata</li>
                </ol>
            </nav>
            <h1>Paket Wisata</h1>
            <p>Pilih paket yang sesuai dengan kebutuhan dan budget Anda</p>
        </div>
    </div>
</section>

<!-- Paket Section -->
<section class="section-padding">
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

                        <div class="card-image" style="height: 200px;">
                            <img src="<?= sanitize($paket['gambar'] ?: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600') ?>"
                                alt="<?= sanitize($paket['nama_paket']) ?>">
                        </div>

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
                                <h5>Fasilitas Termasuk:</h5>
                                <ul>
                                    <?php foreach (explode(',', $paket['fasilitas']) as $fas): ?>
                                        <li><i class="bi bi-check-circle-fill"></i> <?= sanitize(trim($fas)) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <a href="<?= base_url('?page=reservasi&paket=' . $paket['id']) ?>" class="btn btn-paket">
                                <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Custom Paket -->
        <div class="mt-5" data-aos="fade-up">
            <div class="card border-0 bg-light">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3><i class="bi bi-lightbulb me-2 text-warning"></i>Butuh Paket Custom?</h3>
                            <p class="mb-0">Kami juga menyediakan paket custom sesuai kebutuhan Anda. Hubungi kami untuk konsultasi gratis!</p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="https://wa.me/<?= wa_admin() ?>?text=Halo, saya ingin membuat paket wisata custom di Desa Wisata Cibuntu"
                                class="btn btn-primary-custom" target="_blank">
                                <i class="bi bi-whatsapp me-2"></i>Konsultasi Gratis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-question-circle me-1"></i>FAQ</span>
            <h2>Pertanyaan<br>yang Sering Diajukan</h2>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara melakukan reservasi?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat melakukan reservasi dengan mengisi form reservasi di website ini atau langsung menghubungi kami via WhatsApp. Tim kami akan merespons dalam waktu 1x24 jam.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apakah bisa membatalkan reservasi?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, pembatalan dapat dilakukan maksimal H-3 sebelum tanggal kunjungan dengan pengembalian dana 100%. Pembatalan kurang dari H-3 akan dikenakan biaya pembatalan 50%.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Fasilitas apa saja yang tersedia?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami menyediakan berbagai fasilitas seperti toilet bersih, mushola, area parkir luas, kantin, dan gazebo. Untuk camping, tersedia area camping dengan listrik dan WiFi.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Apakah aman untuk anak-anak?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sangat aman! Area wisata kami ramah anak dengan jalur yang mudah diakses dan pemandu yang berpengalaman. Kami juga menyediakan pelampung untuk bermain air.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Metode pembayaran apa saja yang diterima?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami menerima pembayaran melalui transfer bank, e-wallet (GoPay, OVO, DANA), dan pembayaran tunai di lokasi untuk reservasi last minute.
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
            <h2>Masih Punya Pertanyaan?</h2>
            <p>Hubungi tim kami untuk informasi lebih lanjut</p>
            <div class="cta-buttons">
                <a href="https://wa.me/<?= wa_admin() ?>" class="btn btn-light-custom" target="_blank">
                    <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                </a>
                <a href="<?= base_url('?page=kontak') ?>" class="btn btn-outline-light-custom">
                    <i class="bi bi-envelope me-2"></i>Kirim Pesan
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>