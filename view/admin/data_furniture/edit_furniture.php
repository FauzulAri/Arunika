<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /Arunika/view/admin/auth/signin.php');
    exit();
}

include '../../../config/connect.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM furniture WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit();
}

$furniture = $result->fetch_assoc();
ob_start();
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
                <input type="hidden" name="id" value="<?= $furniture['id'] ?>">
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Furniture <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($furniture['nama']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Sofa" <?= $furniture['kategori'] == 'Sofa' ? 'selected' : '' ?>>Sofa</option>
                                <option value="Meja" <?= $furniture['kategori'] == 'Meja' ? 'selected' : '' ?>>Meja</option>
                                <option value="Kursi" <?= $furniture['kategori'] == 'Kursi' ? 'selected' : '' ?>>Kursi</option>
                                <option value="Lemari" <?= $furniture['kategori'] == 'Lemari' ? 'selected' : '' ?>>Lemari</option>
                                <option value="Tempat Tidur" <?= $furniture['kategori'] == 'Tempat Tidur' ? 'selected' : '' ?>>Tempat Tidur</option>
                                <option value="Dekorasi" <?= $furniture['kategori'] == 'Dekorasi' ? 'selected' : '' ?>>Dekorasi</option>
                                <option value="Lainnya" <?= $furniture['kategori'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
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
                            <label for="gambar" class="form-label">Gambar Furniture</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div id="imagePreview" class="border rounded p-3 text-center" style="min-height: 200px; background: #f8f9fa;">
                                <?php if ($furniture['gambar']): ?>
                                    <img src="/Arunika/assets/img/furniture/<?= htmlspecialchars($furniture['gambar']) ?>" 
                                         class="img-fluid" style="max-height: 200px;">
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
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 200px;">`;
        }
        reader.readAsDataURL(file);
    } else {
        // Kembalikan ke gambar asli
        <?php if ($furniture['gambar']): ?>
            preview.innerHTML = `<img src="/Arunika/assets/img/furniture/<?= htmlspecialchars($furniture['gambar']) ?>" class="img-fluid" style="max-height: 200px;">`;
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
