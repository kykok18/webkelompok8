<?php
$page_title = 'Kontak';
require_once __DIR__ . '/../inc/header.php';
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Kontak</li>
                </ol>
            </nav>
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu merencanakan liburan impian Anda</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" data-aos="fade-right">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4">Kirim Pesan</h3>
                        <p class="text-muted mb-4">Isi form di bawah ini dan tim kami akan menghubungi Anda dalam waktu 1x24 jam.</p>

                        <form action="<?= base_url('?page=kirim_pesan') ?>" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan email">
                            </div>

                            <div class="mb-3">
                                <label for="subjek" class="form-label">Subjek</label>
                                <select class="form-select" id="subjek" name="subjek">
                                    <option value="Informasi Umum">Informasi Umum</option>
                                    <option value="Reservasi">Reservasi</option>
                                    <option value="Paket Wisata">Paket Wisata</option>
                                    <option value="Kerjasama">Kerjasama</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="5" required placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="bi bi-send me-2"></i>Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- CARD INFORMASI KONTAK - WARNANYA DIGANTI -->
                <div class="card border-0 text-white mb-4" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);" data-aos="fade-left">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="text-white mb-4">Informasi Kontak</h3>

                        <div class="d-flex align-items-start mb-4">
                            <div class="stat-icon bg-white bg-opacity-25 me-3" style="width:50px;height:50px;font-size:1.25rem;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h5 class="text-white mb-1">Alamat</h5>
                                <p class="mb-0 opacity-75"><?= get_setting('alamat') ?></p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="stat-icon bg-white bg-opacity-25 me-3" style="width:50px;height:50px;font-size:1.25rem;">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h5 class="text-white mb-1">Telepon</h5>
                                <a href="tel:<?= get_setting('telepon') ?>" class="text-white opacity-75"><?= get_setting('telepon') ?></a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="stat-icon bg-white bg-opacity-25 me-3" style="width:50px;height:50px;font-size:1.25rem;">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div>
                                <h5 class="text-white mb-1">WhatsApp</h5>
                                <a href="https://wa.me/<?= wa_admin() ?>" target="_blank" class="text-white opacity-75">Chat Sekarang</a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="stat-icon bg-white bg-opacity-25 me-3" style="width:50px;height:50px;font-size:1.25rem;">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h5 class="text-white mb-1">Email</h5>
                                <a href="mailto:<?= get_setting('email_admin') ?>" class="text-white opacity-75"><?= get_setting('email_admin') ?></a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-white bg-opacity-25 me-3" style="width:50px;height:50px;font-size:1.25rem;">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h5 class="text-white mb-1">Jam Operasional</h5>
                                <p class="mb-0 opacity-75">Senin - Minggu<br><?= get_setting('jam_buka') ?> - <?= get_setting('jam_tutup') ?> WIB</p>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <a href="https://wa.me/<?= wa_admin() ?>?text=Halo, saya ingin bertanya tentang Desa Wisata Cibuntu"
                            class="btn btn-light w-100" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>