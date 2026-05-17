<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Desa Wisata Cibuntu - Destinasi wisata alam dengan keindahan curug, camping ground, dan spot foto instagramable di Jawa Barat">
    <title><?= isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (Versi Terbaru) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Lightbox -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-tree-fill me-2"></i>
                <span>Cibuntu</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('home') ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Destinasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('?page=curug') ?>">
                                    <i class="bi bi-water me-2"></i>Curug
                                </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('?page=camping') ?>">
                                    <i class="bi bi-house-door-fill me-2"></i>Camping
                                </a></li>
                            <li><a class="dropdown-item" href="<?= base_url('?page=spotfoto') ?>">
                                    <i class="bi bi-camera me-2"></i>Spot Foto
                                </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('paket') ?>" href="<?= base_url('?page=paket') ?>">Paket Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('galeri') ?>" href="<?= base_url('?page=galeri') ?>">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('kontak') ?>" href="<?= base_url('?page=kontak') ?>">Kontak</a>
                    </li>
                </ul>
                <a href="<?= base_url('?page=reservasi') ?>" class="btn btn-reservasi ms-lg-3">
                    <i class="bi bi-calendar-check"></i> Reservasi
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Message -->
    <?php if ($flash = get_flash()): ?>
        <div class="container mt-5 pt-4">
            <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : $flash['type'] ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>