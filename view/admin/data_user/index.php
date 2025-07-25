<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Ambil data user dari database
$sql = "SELECT user_id, nama, email, tanggal_daftar, alamat FROM user ORDER BY tanggal_daftar DESC";
$result = $conn->query($sql);
?>
<h2>Data User</h2>
<div class="mb-3 text-end">
    <!-- Tombol tambah user jika ingin, bisa diaktifkan nanti -->
    <!-- <a href="tambah.php" class="btn btn-success">Tambah User</a> -->
</div>
<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Daftar</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): $no=1; while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['tanggal_daftar']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['user_id'] ?>" class="btn btn-warning">Edit</a>
                <!-- Hapus tombol hapus user -->
            </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="6" class="text-center">Belum ada data user.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php';
?> 