<!-- Footer -->
<footer class="footer">
    <div class="footer-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>

    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">
                    <h3><i class="bi bi-tree-fill me-2"></i>Desa Wisata Cibuntu</h3>
                    <p>Nikmati keindahan alam pegunungan Jawa Barat dengan berbagai destinasi wisata menarik. Liburan yang tak terlupakan untuk Anda dan keluarga.</p>
                    <div class="social-links">
                        <a href="<?= get_setting('facebook') ?>" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="<?= get_setting('instagram') ?>" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="<?= get_setting('youtube') ?>" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="<?= get_setting('tiktok') ?>" target="_blank" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="footer-links">
                    <h5>Navigasi</h5>
                    <ul>
                        <li><a href="<?= base_url() ?>">Beranda</a></li>
                        <li><a href="<?= base_url('?page=curug') ?>">Curug</a></li>
                        <li><a href="<?= base_url('?page=camping') ?>">Camping</a></li>
                        <li><a href="<?= base_url('?page=spotfoto') ?>">Spot Foto</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-links">
                    <h5>Informasi</h5>
                    <ul>
                        <li><a href="<?= base_url('?page=paket') ?>">Paket Wisata</a></li>
                        <li><a href="<?= base_url('?page=galeri') ?>">Galeri</a></li>
                        <li><a href="<?= base_url('?page=reservasi') ?>">Reservasi</a></li>
                        <li><a href="<?= base_url('?page=kontak') ?>">Kontak</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-contact">
                    <h5>Kontak Kami</h5>
                    <ul>
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span><?= get_setting('alamat') ?></span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:<?= get_setting('telepon') ?>"><?= get_setting('telepon') ?></a>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:<?= get_setting('email_admin') ?>"><?= get_setting('email_admin') ?></a>
                        </li>
                        <li>
                            <i class="bi bi-clock-fill"></i>
                            <span>Buka: <?= get_setting('jam_buka') ?> - <?= get_setting('jam_tutup') ?> WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Desa Wisata Cibuntu. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp -->
<a href="https://wa.me/<?= wa_admin() ?>?text=Halo, saya ingin bertanya tentang Desa Wisata Cibuntu"
    class="whatsapp-float"
    target="_blank"
    aria-label="Chat WhatsApp">
    <i class="bi bi-whatsapp"></i>
    <span class="tooltip-text">Chat dengan kami</span>
</a>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="<?= base_url('js/main.js') ?>"></script>
</body>

</html>