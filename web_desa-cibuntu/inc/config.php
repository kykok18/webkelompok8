<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'desa_cibuntu');
define('DB_USER', 'root');
define('DB_PASS', '');

// Konfigurasi Website
define('SITE_NAME', 'Desa Wisata Cibuntu');
define('SITE_TAGLINE', 'Keindahan Alam Pegunungan Jawa Barat');

// Upload Path - TAMBAHKAN INI
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL - Fungsi yang diperbaiki untuk support admin folder
function base_url($path = '')
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];

    // Deteksi jika script berjalan di dalam folder admin
    if (strpos($script, '/admin/') !== false) {
        $basePath = substr($script, 0, strpos($script, '/admin/'));
    } else {
        $basePath = dirname($script);
    }

    $basePath = rtrim($basePath, '/\\');
    if ($basePath === '/' || $basePath === '\\') {
        $basePath = '';
    }

    return $protocol . '://' . $host . $basePath . '/' . ltrim($path, '/');
}

// Koneksi Database dengan PDO
function getDB()
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }
    return $pdo;
}

// Cek Admin Login
function is_admin()
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Flash Message
function set_flash($type, $message)
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function flash_message()
{
    $flash = get_flash();
    if ($flash) {
        $alertClass = $flash['type'] === 'success' ? 'alert-success' : ($flash['type'] === 'error' ? 'alert-danger' : 'alert-info');
        return '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">
                    ' . htmlspecialchars($flash['message']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
    }
    return '';
}

// Sanitize Input
function sanitize($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Format Harga
function format_harga($harga)
{
    return 'Rp ' . number_format($harga, 0, ',', '.');
}

// Generate Kode Pemesanan
function generate_kode_pemesanan()
{
    return 'CBT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
}

// Get Current Page
function current_page()
{
    return isset($_GET['page']) ? $_GET['page'] : 'home';
}

// Is Active Page
function is_active($page)
{
    return current_page() === $page ? 'active' : '';
}

// Get Setting
function get_setting($key)
{
    static $settings = null;
    if ($settings === null) {
        $db = getDB();
        $stmt = $db->query("SELECT setting_key, setting_value FROM pengaturan");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $settings[$key] ?? '';
}

// Get WA Admin
function wa_admin()
{
    return get_setting('wa_admin');
}
