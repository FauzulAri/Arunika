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
<form action="/Arunika/controller/user_edit_process.php" method="POST">
    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
    <label>Nama:</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    <!-- Tambahkan field lain sesuai kebutuhan -->
    <button type="submit">Simpan</button>
</form>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php'; 