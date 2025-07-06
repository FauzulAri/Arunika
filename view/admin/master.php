<?php
if (!isset($title)) {
    $title = 'Admin - Arunika';
}
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /Arunika/view/admin/auth/signin.php');
    exit();
}
// Tentukan menu aktif berdasarkan URL
$current = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Arunika/assets/css/style.css">
    <style>
        .sidebar .nav-link {
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Arunika Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/home/index.php">Lihat Website</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/auth/logout_admin.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link<?= strpos($current, '/admin/home') !== false ? ' active' : '' ?>" aria-current="page" href="/Arunika/view/admin/home/index.php">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= strpos($current, '/admin/data_user') !== false ? ' active' : '' ?>" href="/Arunika/view/admin/data_user/index.php">
                                <span data-feather="users"></span>
                                Data User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= strpos($current, '/admin/data_furniture') !== false ? ' active' : '' ?>" href="/Arunika/view/admin/data_furniture/index.php">
                                <span data-feather="file-text"></span>
                                Data Furnitur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= strpos($current, '/admin/data_order') !== false ? ' active' : '' ?>" href="/Arunika/view/admin/data_order/index.php">
                                <span data-feather="file-text"></span>
                                Data Order
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <?php if (isset($content)) { echo $content; } ?>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 