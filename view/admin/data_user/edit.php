<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows < 1) {
    echo '<div class="alert alert-danger">User tidak ditemukan.</div>';
    exit;
}
$user = $res->fetch_assoc();
?>
<h2>Edit User</h2>
<form action="/Arunika/controller/user_edit_process.php" method="post" class="mb-4" autocomplete="off">
  <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
  <div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password (kosongkan jika tidak ganti)</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea class="form-control" id="alamat" name="alamat"><?= htmlspecialchars($user['alamat']) ?></textarea>
  </div>
  <div class="mb-3">
    <label for="no_hp" class="form-label">No HP</label>
    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($user['no_hp']) ?>">
  </div>
  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
  <a href="index.php" class="btn btn-secondary">Batal</a>
</form>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php'; 