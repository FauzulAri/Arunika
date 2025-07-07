<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    // Selalu include koneksi di sini
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
    // Hitung jumlah item keranjang user (jika login)
    $cart_count = 0;
    if (isset($_SESSION['user_id'])) {
        $uid = $_SESSION['user_id'];
        $cart_count = $conn->query("SELECT SUM(jumlah) FROM keranjang WHERE user_id=$uid")->fetch_row()[0] ?? 0;
    }
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
    <style>
        .navbar-arunika { background: #a48ad4; }
        .navbar-brand { font-family: 'Sansita Swashed', cursive; font-size: 2rem; font-weight: bold; }
        .nav-link.active, .nav-link:focus, .nav-link:hover { color: #fff !important; }
        .search-bar { min-width: 260px; max-width: 400px; }
        .icon-btn { background: none; border: none; position: relative; }
        .icon-badge { position: absolute; top: -6px; right: -8px; background: #e07b87; color: #fff; border-radius: 50%; font-size: 0.8rem; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; }
        .dropdown-menu { min-width: 180px; }
        .sticky-top { z-index: 1030; }
        .btn-pink {
          background: #FEA5AD !important;
          color: #fff !important;
          border: none !important;
          border-radius: 40px;
          font-weight: 500;
          padding: 0.5rem 1.5rem;
          transition: background 0.2s;
        }
        .btn-pink:hover, .btn-pink:focus {
          background: #e07b87 !important;
          color: #fff !important;
        }
        .btn-outline-pink {
          background: #fff !important;
          color: #FEA5AD !important;
          border: 2px solid #FEA5AD !important;
          border-radius: 40px;
          font-weight: 500;
          padding: 0.5rem 1.5rem;
          transition: background 0.2s, color 0.2s;
        }
        .btn-outline-pink:hover, .btn-outline-pink:focus {
          background: #FEA5AD !important;
          color: #fff !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-arunika sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/Arunika/view/user/home/index.php">Arunika Interior</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/Arunika/view/user/home/index.php">Beranda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Furniture</a>
                        <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                            <?php $kq = $conn->query("SELECT * FROM kategori WHERE is_active=1 ORDER BY kategori_id ASC"); while($k = $kq->fetch_assoc()): ?>
                                <li><a class="dropdown-item" href="/Arunika/view/user/product/furniture.php?cat=<?= urlencode($k['nama_kategori']) ?>"><?= htmlspecialchars($k['nama_kategori']) ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#promo">Promo</a></li>
                    <li class="nav-item"><a class="nav-link" href="#inspirasi">Inspirasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Arunika/view/user/product/furniture.php">Ulasan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Kami</a></li>
                </ul>
                <form class="d-flex mx-auto search-bar" role="search" action="/Arunika/view/user/product/furniture.php" method="get">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari produk..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit"><i class="fa fa-search"></i></button>
                </form>
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="#" class="icon-btn" title="Wishlist"><i class="fa fa-heart fa-lg"></i></a>
                    <a href="/Arunika/view/user/cart/index.php" class="icon-btn position-relative" title="Keranjang">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                        <?php if($cart_count>0): ?><span class="icon-badge"><?= $cart_count ?></span><?php endif; ?>
                    </a>
                    <a href="#" class="icon-btn" title="Notifikasi"><i class="fa fa-bell fa-lg"></i></a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/Arunika/view/auth/login.php" class="btn btn-pink ms-2">Login</a>
                        <a href="/Arunika/view/auth/registeruser.php" class="btn btn-outline-pink ms-2">Daftar</a>
                    <?php else: ?>
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
                        <div class="dropdown ms-2">
                            <a class="btn btn-light dropdown-toggle p-0" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background:transparent; border:none; box-shadow:none; min-width:unset;">
                            <img src="<?= $foto_url ?>" alt="Foto Profil" class="rounded-circle" style="width:40px; height:40px; object-fit:cover; display:block;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="/Arunika/view/user/profile.php">Profil Saya</a></li>
                                <li><a class="dropdown-item" href="#">Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="#">Wishlist</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/Arunika/auth/logout.php">Logout</a></li>
                        </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
    
</html>