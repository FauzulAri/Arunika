<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($search !== '') {
    $stmt = $conn->prepare("SELECT f.*, k.nama_kategori FROM furniture f LEFT JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.nama_furniture LIKE ? ORDER BY f.furniture_id DESC");
    $like = "%$search%";
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT f.*, k.nama_kategori FROM furniture f LEFT JOIN kategori k ON f.kategori_id = k.kategori_id ORDER BY f.furniture_id DESC");
}
ob_start();
?>

<form method="GET" class="mb-3" action="">
    <div class="input-group" style="max-width: 400px;">
        <input type="text" class="form-control" name="q" placeholder="Cari nama furniture..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
    </div>
</form>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Furniture</h2>
        <a href="add_furniture.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Furniture
        </a>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Furniture</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = $result->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if ($row['gambar_furniture']): ?>
                                    <img src="/Arunika/assets/img/<?= htmlspecialchars($row['gambar_furniture']) ?>" 
                                         alt="<?= htmlspecialchars($row['nama_furniture']) ?>" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['nama_furniture']) ?></td>
                            <td>
                                <span class="badge bg-info"><?= htmlspecialchars($row['nama_kategori']) ?></span>
                            </td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td>
                                <?= strlen($row['deskripsi']) > 50 ? substr(htmlspecialchars($row['deskripsi']), 0, 50) . '...' : htmlspecialchars($row['deskripsi']) ?>
                            </td>
                            <td>
                                <a href="edit_furniture.php?id=<?= $row['furniture_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_furniture.php?id=<?= $row['furniture_id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus furniture ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php';
?> 