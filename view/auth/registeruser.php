<?php
ob_start();
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3 class="mb-4 text-center">Registrasi Pengguna</h3>
        <form action="/Arunika/controller/user_register_process.php" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="konfirmasi_password" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <div class="mt-3 text-center">
            Sudah punya akun? <a href="/Arunika/view/auth/login.php">Masuk di sini</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?>
