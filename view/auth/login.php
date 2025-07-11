<?php
ob_start();
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3 class="mb-4 text-center">Masuk Pengguna</h3>
        <form action="/Arunika/controller/user_login_process.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        <div class="mt-3 text-center">
            Belum punya akun? <a href="/Arunika/view/auth/registeruser.php">Daftar di sini</a>
        </div>
        <div class="mt-2 text-center">
            <a href="/Arunika/view/user/home/index.php">Kembali ke blablabla Beranda</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?>
