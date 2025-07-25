<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$sql = "SELECT o.id_order, o.order_id, u.nama as nama_pemesan, o.alamat_pengiriman, o.tanggal_order, o.status_order 
        FROM orders o 
        JOIN user u ON o.user_id = u.user_id 
        ORDER BY o.tanggal_order DESC";
$result = $conn->query($sql);
?>
<h2>Data Order</h2>
<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Nomor Order</th>
            <th>Nama Pemesan</th>
            <th>Alamat Pengiriman</th>
            <th>Tanggal Order</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_order'] ?></td>
            <td><?= htmlspecialchars($row['order_id']) ?></td>
            <td><?= htmlspecialchars($row['nama_pemesan']) ?></td>
            <td><?= htmlspecialchars($row['alamat_pengiriman']) ?></td>
            <td><?= htmlspecialchars($row['tanggal_order']) ?></td>
            <td><?= htmlspecialchars($row['status_order']) ?></td>
            <td>
                <a href="detail_order.php?id=<?= $row['id_order'] ?>" class="btn btn-sm btn-info">Detail</a>
                <a href="edit_order.php?id=<?= $row['id_order'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="/Arunika/controller/order_delete_process.php?id=<?= $row['id_order'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus order?')">Hapus</a>
                <?php if ($row['status_order'] !== 'Sedang Dikirim'): ?>
                    <a href="/Arunika/controller/order_kirim_process.php?id=<?= $row['id_order'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi kirim order ini?')">Konfirmasi Kirim</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="7" class="text-center">Belum ada data order.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php';
?> 