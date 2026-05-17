<?php
require_once __DIR__ . '/../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = sanitize($_POST['nama'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $wa = sanitize($_POST['wa'] ?? '');
    $paket_id = (int)($_POST['paket_id'] ?? 0);
    $tanggal_kunjungan = sanitize($_POST['tanggal_kunjungan'] ?? '');
    $jumlah_orang = (int)($_POST['jumlah_orang'] ?? 0);
    $total_harga = (int)($_POST['total_harga'] ?? 0);
    $catatan = sanitize($_POST['catatan'] ?? '');

    $errors = [];

    if (empty($nama)) $errors[] = 'Nama harus diisi';
    if (empty($email)) $errors[] = 'Email harus diisi';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid';
    if (empty($wa)) $errors[] = 'Nomor WhatsApp harus diisi';
    if ($paket_id === 0) $errors[] = 'Paket wisata harus dipilih';
    if (empty($tanggal_kunjungan)) $errors[] = 'Tanggal kunjungan harus diisi';
    if ($jumlah_orang < 1) $errors[] = 'Jumlah orang minimal 1';

    if (count($errors) > 0) {
        set_flash('error', implode(', ', $errors));
        header('Location: ' . base_url('?page=reservasi'));
        exit;
    }

    try {
        $db = getDB();

        // Get paket name
        $stmt = $db->prepare("SELECT nama_paket FROM paket_wisata WHERE id = ?");
        $stmt->execute([$paket_id]);
        $paket = $stmt->fetch();
        $paket_nama = $paket ? $paket['nama_paket'] : '';

        // Generate kode pemesanan
        $kode_pemesanan = generate_kode_pemesanan();

        // Format WA number
        $wa_formatted = $wa;
        if (substr($wa, 0, 1) === '0') {
            $wa_formatted = '62' . substr($wa, 1);
        }

        // Insert pemesanan
        $stmt = $db->prepare("INSERT INTO pemesanan (kode_pemesanan, nama, email, wa, paket_id, paket_nama, tanggal_kunjungan, jumlah_orang, total_harga, catatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$kode_pemesanan, $nama, $email, $wa_formatted, $paket_id, $paket_nama, $tanggal_kunjungan, $jumlah_orang, $total_harga, $catatan]);

        set_flash('success', "Reservasi berhasil! Kode pemesanan Anda: <strong>$kode_pemesanan</strong>. Silakan tunggu konfirmasi dari tim kami.");

        // Redirect to WhatsApp for confirmation
        $wa_message = "Halo, saya telah melakukan reservasi dengan detail:\n\n";
        $wa_message .= "Kode: $kode_pemesanan\n";
        $wa_message .= "Nama: $nama\n";
        $wa_message .= "Paket: $paket_nama\n";
        $wa_message .= "Tanggal: $tanggal_kunjungan\n";
        $wa_message .= "Jumlah: $jumlah_orang orang\n";
        $wa_message .= "Total: Rp " . number_format($total_harga, 0, ',', '.') . "\n\n";
        $wa_message .= "Mohon konfirmasi. Terima kasih.";

        header('Location: https://wa.me/' . wa_admin() . '?text=' . urlencode($wa_message));
        exit;
    } catch (PDOException $e) {
        set_flash('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        header('Location: ' . base_url('?page=reservasi'));
        exit;
    }
}

header('Location: ' . base_url('?page=reservasi'));
exit;
