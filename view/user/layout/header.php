<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

?>

<!DOCTYPE html>
<html lang="en">
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
        <div class="container">
            <a class="navbar-brand font-sansita" href="/Arunika/view/user/home/index.php">Arunika Interior</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/services/index.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/product/index.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Arunika/view/user/about/index.php">About Us</a>
                    </li>
                </ul>
                <div class="d-flex ms-auto gap-2">
                    <a href="../../auth/login.php" class="btn btn-login-custom">Login</a>
                    <a href="#" class="btn btn-custom">Get Started</a>
                </div>
            </div>
        </div>
    </nav>
</body>
    
</html>