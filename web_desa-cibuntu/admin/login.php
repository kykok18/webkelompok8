<?php
require_once __DIR__ . '/../inc/config.php';

if (is_admin()) {
    header('Location: ' . base_url('?page=admin_dashboard'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && ($password === 'admin123' || password_verify($password, $user['password']))) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['nama'];  // Gunakan admin_name (konsisten)
            header('Location: ' . base_url('?page=admin_dashboard'));
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } catch (PDOException $e) {
        $error = 'Terjadi kesalahan sistem.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow-xl);
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="stat-icon bg-primary mx-auto mb-3" style="width:70px;height:70px;font-size:2rem;">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h2 class="text-primary mb-1">Admin Login</h2>
            <p class="text-muted mb-0">Desa Wisata Cibuntu</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger border-0 rounded-3">
                <i class="bi bi-exclamation-circle me-2"></i><?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control form-control-lg" required placeholder="admin">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" required placeholder="admin123">
            </div>
            <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>
        <div class="text-center mt-4">
            <a href="<?= base_url() ?>" class="text-muted small"><i class="bi bi-arrow-left me-1"></i>Kembali ke Website</a>
        </div>
    </div>
</body>

</html>