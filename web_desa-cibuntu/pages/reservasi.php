<?php
$page_title = 'Reservasi';
require_once __DIR__ . '/../inc/header.php';

$db = getDB();
$stmt = $db->query("SELECT * FROM paket_wisata WHERE status = 'aktif' ORDER BY urutan ASC");
$pakets = $stmt->fetchAll();
$selected_paket = isset($_GET['paket']) ? (int)$_GET['paket'] : '';
?>

<!-- Hero Page -->
<section class="hero-page" style="background-image: url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1920')">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Reservasi</li>
                </ol>
            </nav>
            <h1>Form Reservasi</h1>
            <p>Isi form di bawah untuk melakukan reservasi</p>
        </div>
    </div>
</section>

<!-- Reservasi Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm" data-aos="fade-right">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4">Form Reservasi</h3>

                        <form action="<?= base_url('?page=kirim_reservasi') ?>" method="POST" id="reservasiForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap Anda">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required placeholder="email@contoh.com">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" name="wa" class="form-control" required placeholder="08xxxxxxxxxx">
                                    <small class="text-muted">Contoh: 083116519626</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Paket Wisata <span class="text-danger">*</span></label>
                                    <select name="paket_id" id="paketSelect" class="form-select" required>
                                        <option value="">-- Pilih Paket --</option>
                                        <?php foreach ($pakets as $p): ?>
                                            <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga'] ?>" <?= $selected_paket == $p['id'] ? 'selected' : '' ?>>
                                                <?= sanitize($p['nama_paket']) ?> - <?= format_harga($p['harga']) ?>/orang
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal_kunjungan" id="tanggalPicker" class="form-control" required placeholder="Pilih tanggal">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jumlah Orang <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_orang" id="jumlahOrang" class="form-control" required min="1" value="1" placeholder="Minimal 1 orang">
                                </div>

                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body py-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-semibold">Total Harga:</span>
                                                <span class="h4 mb-0 text-primary" id="totalHarga">Rp 0</span>
                                            </div>
                                            <input type="hidden" name="total_harga" id="totalHargaInput">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Catatan Tambahan</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Permintaan khusus, alergi makanan, dll"></textarea>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            Saya menyetujui <a href="#" class="text-primary">syarat dan ketentuan</a> yang berlaku
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom w-100 btn-lg">
                                        <i class="bi bi-send me-2"></i>Kirim Reservasi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <!-- CARD INFORMASI PENTING - WARNANYA DIGANTI -->
                <div class="card border-0 text-white mb-4" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);" data-aos="fade-left">
                    <div class="card-body p-4">
                        <h4 class="text-white mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Penting</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="bi bi-check-circle me-2"></i>
                                Reservasi dikonfirmasi maksimal 1x24 jam
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle me-2"></i>
                                Pembatalan gratis H-3 sebelum kunjungan
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle me-2"></i>
                                Pembayaran bisa dilakukan di lokasi
                            </li>
                            <li>
                                <i class="bi bi-check-circle me-2"></i>
                                Hubungi kami jika ada pertanyaan
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Butuh Bantuan?</h5>
                        <p class="text-muted mb-3">Hubungi kami langsung via WhatsApp untuk bantuan reservasi.</p>
                        <a href="https://wa.me/<?= wa_admin() ?>?text=Halo, saya butuh bantuan untuk reservasi di Desa Wisata Cibuntu"
                            class="btn btn-success w-100" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#tanggalPicker", {
            locale: "id",
            minDate: "today",
            dateFormat: "Y-m-d",
            disableMobile: "true"
        });

        const paketSelect = document.getElementById('paketSelect');
        const jumlahOrang = document.getElementById('jumlahOrang');
        const totalHarga = document.getElementById('totalHarga');
        const totalHargaInput = document.getElementById('totalHargaInput');

        function calculateTotal() {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            const harga = parseInt(selectedOption.dataset.harga) || 0;
            const jumlah = parseInt(jumlahOrang.value) || 0;
            const total = harga * jumlah;

            totalHarga.textContent = 'Rp ' + total.toLocaleString('id-ID');
            totalHargaInput.value = total;
        }

        paketSelect.addEventListener('change', calculateTotal);
        jumlahOrang.addEventListener('input', calculateTotal);
        calculateTotal();
    });
</script>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>