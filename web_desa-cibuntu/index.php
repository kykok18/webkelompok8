<?php
require_once __DIR__ . '/inc/config.php';

// Get requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Define allowed pages
$allowed_pages = [
    'home' => 'pages/home.php',
    'curug' => 'pages/curug.php',
    'camping' => 'pages/camping.php',
    'spotfoto' => 'pages/spotfoto.php',
    'paket' => 'pages/paket.php',
    'galeri' => 'pages/galeri.php',
    'kontak' => 'pages/kontak.php',
    'reservasi' => 'pages/reservasi.php',
    'kirim_pesan' => 'pages/kirim_pesan.php',
    'kirim_reservasi' => 'pages/kirim_reservasi.php',
    // Admin pages
    'admin_login' => 'admin/login.php',
    'admin_logout' => 'admin/logout.php',
    'admin_dashboard' => 'admin/dashboard.php',
    'admin_pemesanan' => 'admin/pemesanan.php',
    'admin_paket' => 'admin/paket.php',
    'admin_galeri' => 'admin/galeri.php',
    'admin_testimoni' => 'admin/testimoni.php',
    'admin_pengaturan' => 'admin/pengaturan.php',
];

// Check if page exists
if (array_key_exists($page, $allowed_pages)) {
    $file = $allowed_pages[$page];
    if (file_exists(__DIR__ . '/' . $file)) {
        include __DIR__ . '/' . $file;
    } else {
        http_response_code(404);
        $page_title = 'Halaman Tidak Ditemukan';
        include __DIR__ . '/inc/header.php';
        echo '<div class="container text-center py-5 mt-5"><h1>404 - Halaman Tidak Ditemukan</h1></div>';
        include __DIR__ . '/inc/footer.php';
    }
} else {
    http_response_code(404);
    $page_title = 'Halaman Tidak Ditemukan';
    include __DIR__ . '/inc/header.php';
    echo '<div class="container text-center py-5 mt-5"><h1>404 - Halaman Tidak Ditemukan</h1></div>';
    include __DIR__ . '/inc/footer.php';
}
