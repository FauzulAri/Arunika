<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
ob_start();
?>
<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
    <h2 class="mb-5 text-center">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h2>
    <div class="row justify-content-center w-100" style="max-width: 700px;">
        <div class="col-md-8 mb-4">
            <div class="card text-center shadow h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa fa-user fa-3x mb-3" style="color:#827AC4;"></i>
                    <h5 class="card-title mb-3">Getting Started Sebagai Client</h5>
                    <p class="card-text mb-4">Anda siap memulai perjalanan desain interior bersama Arunika. Klik tombol di bawah untuk mulai konsultasi dengan desainer kami dan wujudkan ruang impian Anda!</p>
                    <a href="/Arunika/view/user/services/detail_work.php" class="btn btn-primary w-100">Mulai Konsultasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?>
