<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];

// Ambil data user
$stmt = $conn->prepare('SELECT nama, alamat, no_hp FROM user WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($nama, $alamat, $no_hp);
$stmt->fetch();
$stmt->close();

// Ambil keranjang terpilih
if (isset($_POST['keranjang_ids']) && $_POST['keranjang_ids']) {
    $keranjang_ids = array_filter(explode(',', $_POST['keranjang_ids']));
} elseif (isset($_GET['keranjang_ids']) && $_GET['keranjang_ids']) {
    $keranjang_ids = array_filter(explode(',', $_GET['keranjang_ids']));
} else {
    $keranjang_ids = [];
}
if (empty($keranjang_ids)) {
    echo '<div class="container py-5 text-center"><h3>Tidak ada barang yang dipilih untuk checkout.</h3><a href="index.php" class="btn btn-primary mt-3">Kembali ke Keranjang</a></div>';
    exit();
}
$placeholders = implode(',', array_fill(0, count($keranjang_ids), '?'));
$types = str_repeat('i', count($keranjang_ids));
$params = $keranjang_ids;
$sql = "SELECT k.*, f.nama_furniture, f.gambar_furniture, f.harga FROM keranjang k JOIN furniture f ON k.furniture_id = f.furniture_id WHERE k.keranjang_id IN ($placeholders) AND k.user_id = ?";
$params[] = $user_id;
$types .= 'i';
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
$items = [];
$total = 0;
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
    $total += $row['subtotal'];
}
$stmt->close();
if (empty($items)) {
    echo '<div class="container py-5 text-center"><h3>Barang tidak ditemukan di keranjang.</h3><a href="index.php" class="btn btn-primary mt-3">Kembali ke Keranjang</a></div>';
    exit();
}
ob_start();
?>
<div class="container py-5">
  <h2 class="mb-4 text-center">Checkout</h2>
  <form method="post" action="/Arunika/controller/checkout_process.php">
    <input type="hidden" name="keranjang_ids" value="<?= htmlspecialchars(implode(',', $keranjang_ids)) ?>">
    <div class="row g-4">
      <!-- KIRI: Alamat & Pesanan -->
      <div class="col-lg-8">
        <!-- Alamat Pengiriman -->
        <div class="card p-3 mb-4">
          <div class="d-flex align-items-center mb-2">
            <i class="fa fa-map-marker-alt text-success me-2"></i>
            <div>
              <b><?= htmlspecialchars($nama) ?></b> <span class="text-muted">| <?= htmlspecialchars($no_hp) ?></span>
            </div>
          </div>
          <div class="mb-2" style="white-space:pre-line;"> <?= htmlspecialchars($alamat) ?> </div>
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#editAlamat">Ganti Alamat</button>
          <div class="collapse mt-3" id="editAlamat">
            <textarea name="alamat_pengiriman" class="form-control mb-2" rows="2" required><?= htmlspecialchars($alamat) ?></textarea>
            <input type="text" name="nama_penerima" class="form-control mb-2" value="<?= htmlspecialchars($nama) ?>" placeholder="Nama Penerima" required>
            <input type="text" name="no_hp_penerima" class="form-control mb-2" value="<?= htmlspecialchars($no_hp) ?>" placeholder="No. HP Penerima" required maxlength="15">
          </div>
        </div>
        <!-- Daftar Pesanan -->
        <div class="card p-3 mb-4">
          <h5 class="mb-3">Pesanan Anda</h5>
          <?php foreach ($items as $item): ?>
            <div class="d-flex align-items-center border-bottom py-2">
              <img src="/Arunika/assets/img/<?= htmlspecialchars($item['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($item['nama_furniture']) ?>" style="width:56px; height:56px; object-fit:cover; border-radius:8px; margin-right:14px;">
              <div class="flex-grow-1">
                <div class="fw-bold mb-1"><?= htmlspecialchars($item['nama_furniture']) ?></div>
                <div class="text-muted small">Jumlah: <?= $item['jumlah'] ?></div>
              </div>
              <div class="fw-bold">Rp<?= number_format($item['subtotal'],0,',','.') ?></div>
            </div>
          <?php endforeach; ?>
          <div class="mt-3">
            <label class="form-label">Catatan untuk penjual (opsional)</label>
            <input type="text" name="catatan" class="form-control" maxlength="100" placeholder="Contoh: warna coklat, kirim siang, dsb">
          </div>
        </div>
      </div>
      <!-- KANAN: Ringkasan & Metode Pembayaran -->
      <div class="col-lg-4">
        <div class="card p-3 sticky-top" style="top:120px;">
          <h5 class="mb-3">Ringkasan Belanja</h5>
          <div class="d-flex justify-content-between mb-2">
            <span>Total</span>
            <span class="fw-bold fs-5 text-success">Rp<?= number_format($total,0,',','.') ?></span>
          </div>
          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required>
              <option value="transfer_bank">Transfer Bank</option>
              <option value="e_wallet">E-Wallet</option>
              <option value="cod">Bayar di Tempat (COD)</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success btn-lg w-100">Konfirmasi & Bayar</button>
          <a href="index.php" class="btn btn-secondary w-100 mt-2">Kembali ke Keranjang</a>
        </div>
      </div>
    </div>
  </form>
</div>
<style>
@media (max-width: 991px) {
  .sticky-top { position: static !important; }
}
</style>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 