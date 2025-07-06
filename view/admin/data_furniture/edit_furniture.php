<?php
ob_start();
include '../../../config/connect.php';
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}
$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM furniture WHERE furniture_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header('Location: index.php');
    exit();
}
$furniture = $result->fetch_assoc();
// Ambil kategori
$kategori = [];
$kq = $conn->query("SELECT * FROM kategori WHERE is_active = 1 ORDER BY nama_kategori ASC");
while ($row = $kq->fetch_assoc()) {
    $kategori[] = $row;
}
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Furniture</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="../../../controller/furniture_admin_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="furniture_id" value="<?= $furniture['furniture_id'] ?>">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nama_furniture" class="form-label">Nama Furniture <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_furniture" name="nama_furniture" value="<?= htmlspecialchars($furniture['nama_furniture']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['kategori_id'] ?>" <?= $furniture['kategori_id'] == $k['kategori_id'] ? 'selected' : '' ?>><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="harga" name="harga" value="<?= $furniture['harga'] ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi furniture..."><?= htmlspecialchars($furniture['deskripsi']) ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="gambar_furniture" class="form-label">Gambar Furniture</label>
                            <input type="file" class="form-control" id="gambar_furniture" name="gambar_furniture" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div id="imagePreview" class="border rounded p-3 text-center" style="min-height: 200px; background: #f8f9fa;">
                                <?php if ($furniture['gambar_furniture']): ?>
                                    <img src="/Arunika/assets/img/<?= htmlspecialchars($furniture['gambar_furniture']) ?>" class="img-fluid" style="max-height: 200px;">
                                <?php else: ?>
                                    <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Tidak ada gambar</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="edit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('gambar_furniture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 200px;">`;
        }
        reader.readAsDataURL(file);
    } else {
        <?php if ($furniture['gambar_furniture']): ?>
            preview.innerHTML = `<img src="/Arunika/assets/img/<?= htmlspecialchars($furniture['gambar_furniture']) ?>" class="img-fluid" style="max-height: 200px;">`;
        <?php else: ?>
            preview.innerHTML = `
                <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-2">Tidak ada gambar</p>
            `;
        <?php endif; ?>
    }
});
</script>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php';
?>
