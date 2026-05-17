<?php
require_once __DIR__ . '/../../inc/config.php';

if (!is_admin()) {
    header('Location: ' . base_url('?page=admin_login'));
    exit;
}

$db = getDB();
$pending_count = $db->query("SELECT COUNT(*) FROM pemesanan WHERE status = 'pending'")->fetchColumn();
?>
<!DOCTYPE html> <!-- ← LANGSUNG, TANPA SPASI ATAU ENTER -->
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - Admin <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body class="admin-body">
    <div class="admin-wrapper">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="<?= base_url('?page=admin_dashboard') ?>" class="sidebar-brand">
                    <i class="bi bi-tree-fill"></i>
                    <span>Cibuntu Admin</span>
                </a>
            </div>
            <nav class="sidebar-menu">
                <div class="sidebar-menu-label">Menu Utama</div>
                <a href="<?= base_url('?page=admin_dashboard') ?>" class="sidebar-menu-item <?= current_page() === 'admin_dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>

                <div class="sidebar-menu-label">Manajemen</div>
                <a href="<?= base_url('?page=admin_pemesanan') ?>" class="sidebar-menu-item <?= current_page() === 'admin_pemesanan' ? 'active' : '' ?>">
                    <i class="bi bi-receipt"></i>
                    <span>Pemesanan</span>
                    <?php if ($pending_count > 0): ?>
                        <span class="badge bg-danger ms-auto"><?= $pending_count ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?= base_url('?page=admin_paket') ?>" class="sidebar-menu-item <?= current_page() === 'admin_paket' ? 'active' : '' ?>">
                    <i class="bi bi-box-seam"></i><span>Paket Wisata</span>
                </a>
                <a href="<?= base_url('?page=admin_galeri') ?>" class="sidebar-menu-item <?= current_page() === 'admin_galeri' ? 'active' : '' ?>">
                    <i class="bi bi-images"></i><span>Galeri</span>
                </a>
                <a href="<?= base_url('?page=admin_testimoni') ?>" class="sidebar-menu-item <?= current_page() === 'admin_testimoni' ? 'active' : '' ?>">
                    <i class="bi bi-chat-quote"></i><span>Testimoni</span>
                </a>

                <div class="sidebar-menu-label">Lainnya</div>
                <a href="<?= base_url() ?>" class="sidebar-menu-item" target="_blank">
                    <i class="bi bi-globe"></i><span>Lihat Website</span>
                </a>
                <a href="<?= base_url('?page=admin_logout') ?>" class="sidebar-menu-item">
                    <i class="bi bi-box-arrow-left"></i><span>Logout</span>
                </a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-link d-lg-none p-0 text-dark" id="sidebarToggle">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <h1 class="topbar-title mb-0 h5"><?= $page_title ?></h1>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-dark text-decoration-none" data-bs-toggle="dropdown">
                        <div class="stat-icon bg-primary" style="width:36px;height:36px;font-size:0.9rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="d-none d-sm-block">
                            <div class="fw-semibold small"><?= sanitize($_SESSION['admin_name'] ?? $_SESSION['admin_nama'] ?? 'Admin') ?></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="<?= base_url() ?>" target="_blank"><i class="bi bi-globe me-2"></i>Lihat Website</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('?page=admin_logout') ?>"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </header>
            <div class="admin-content">
                <?= flash_message() ?>