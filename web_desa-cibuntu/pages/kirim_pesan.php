<?php
require_once __DIR__ . '/../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = sanitize($_POST['nama'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subjek = sanitize($_POST['subjek'] ?? 'Informasi Umum');
    $pesan = sanitize($_POST['pesan'] ?? '');

    $errors = [];

    if (empty($nama)) $errors[] = 'Nama harus diisi';
    if (empty($email)) $errors[] = 'Email harus diisi';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid';
    if (empty($pesan)) $errors[] = 'Pesan harus diisi';

    if (count($errors) > 0) {
        set_flash('error', implode(', ', $errors));
    } else {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO kontak_messages (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nama, $email, $subjek, $pesan]);
            set_flash('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
        } catch (PDOException $e) {
            set_flash('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}

header('Location: ' . base_url('?page=kontak'));
exit;
