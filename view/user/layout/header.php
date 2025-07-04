<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    // Selalu include koneksi di sini
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Arunika/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Arunika Interior</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand font-sansita" href="/Arunika/view/user/home/index.php">Arunika Interior</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/services/detail_work.php">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/services/desainer.php">Desain</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/product/furniture.php">Furniture</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/product/portofolio.php">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ulasan</a>
                    </li>
                </ul>
                <div class="d-flex ms-auto align-items-center gap-3">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/Arunika/view/user/get_start/getting_start.php" class="btn btn-custom">Mulai Sekarang</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                            $foto_url = null;
                            $nama_user = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
                            $user_id = $_SESSION['user_id'];
                            $stmt = $conn->prepare('SELECT foto FROM user WHERE user_id = ?');
                            $stmt->bind_param('i', $user_id);
                            $stmt->execute();
                            $stmt->bind_result($foto);
                            $stmt->fetch();
                            $stmt->close();
                            if ($foto) {
                                $foto_url = "/Arunika/assets/img/profile/" . htmlspecialchars($foto);
                            } else {
                                $foto_url = "https://ui-avatars.com/api/?name=" . urlencode($nama_user);
                            }
                        ?>
                        <a class="btn btn-login-custom dropdown-toggle p-0 me-2" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background:transparent; border:none; box-shadow:none; min-width:unset;">
                            <img src="<?= $foto_url ?>" alt="Foto Profil" class="rounded-circle" style="width:40px; height:40px; object-fit:cover; display:block;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="/Arunika/view/user/profile.php">Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/Arunika/auth/logout.php">Logout</a></li>
                        </ul>
                        <a href="#" class="ms-2" style="display:inline-flex; align-items:center; text-decoration:none;">
                            <i class="fa fa-shopping-cart" style="font-size: 2rem;"></i>
                        </a>
                    <?php else: ?>
                        <a href="/Arunika/auth/login.php" class="btn btn-login-custom">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
    
</html>