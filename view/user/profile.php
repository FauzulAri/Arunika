<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$stmt = $conn->prepare('SELECT nama, email, alamat, foto, tanggal_daftar, no_hp FROM user WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($nama, $email, $alamat, $foto, $tanggal_daftar, $no_hp);
$stmt->fetch();
$stmt->close();

$foto_url = $foto ? "/Arunika/assets/img/profile/" . htmlspecialchars($foto) : "https://ui-avatars.com/api/?name=" . urlencode($nama);

ob_start();
?>
<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh; padding-top: 7rem; padding-bottom: 7rem;">
    <div class="card shadow p-4" style="max-width: 480px; width: 100%;">
        <h3 class="mb-4 text-center">Edit Profil Pengguna</h3>
        <form action="/Arunika/controller/user_update_profile.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 text-center">
                <img src="<?= $foto_url ?>" id="foto-preview" alt="Foto Profil" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                <div>
                    <input type="file" name="foto" accept="image/*" class="form-control mt-2" style="max-width: 220px; margin: 0 auto;" id="foto-input">
                </div>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru <small>(kosongkan jika tidak ingin ganti)</small></label>
                <input type="password" class="form-control" id="password" name="password" minlength="6">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= htmlspecialchars($alamat) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($no_hp) ?>" maxlength="15">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Daftar</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tanggal_daftar) ?>" disabled>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="/Arunika/view/user/home/index.php" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('foto-input');
    const preview = document.getElementById('foto-preview');
    input.addEventListener('change', function(e) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.src = ev.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
});
</script> 