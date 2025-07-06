<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /Arunika/view/user/product/furniture.php');
    exit();
}
$id = (int)$_GET['id'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Query detail furniture + kategori
$stmt = $conn->prepare("SELECT f.*, k.nama_kategori FROM furniture f LEFT JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.furniture_id = ? AND f.is_active = 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows < 1) {
    echo '<div class="container py-5 text-center"><h3>Produk tidak ditemukan.</h3></div>';
    exit();
}
$f = $res->fetch_assoc();

// Query diskon jika ada
$diskon = null;
$dq = $conn->prepare("SELECT * FROM diskon WHERE furniture_id = ? AND is_active = 1 AND NOW() BETWEEN tanggal_mulai AND tanggal_selesai LIMIT 1");
$dq->bind_param("i", $id);
$dq->execute();
$dr = $dq->get_result();
if ($dr->num_rows > 0) $diskon = $dr->fetch_assoc();

// Hitung harga lama jika diskon
$harga_lama = null;
$badge_diskon = '';
if ($diskon) {
    if ($diskon['tipe'] == 'persen') {
        $harga_lama = $f['harga'] / (1 - $diskon['nilai']/100);
        $badge_diskon = 'Diskon ' . number_format($diskon['nilai'],0) . '%';
    } else {
        $harga_lama = $f['harga'] + $diskon['nilai'];
        $badge_diskon = 'Hemat Rp' . number_format($diskon['nilai'],0,',','.');
    }
}
ob_start();
?>
<div class="container py-4">
  <div class="row g-4 align-items-start">
    <div class="col-md-6">
      <div class="detail-img-wrap mb-3">
        <img src="/Arunika/assets/img/<?= htmlspecialchars($f['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($f['nama_furniture']) ?>" class="img-fluid rounded shadow-sm" style="max-height:400px;object-fit:cover;width:100%;">
      </div>
    </div>
    <div class="col-md-6">
      <h2 class="mb-2" style="font-weight:700;"><?= htmlspecialchars($f['nama_furniture']) ?></h2>
      <div class="mb-2 text-muted">Kategori: <b><?= htmlspecialchars($f['nama_kategori']) ?></b></div>
      <?php if ($badge_diskon): ?>
        <span class="badge bg-danger mb-2" style="font-size:1rem;"> <?= $badge_diskon ?> </span>
      <?php endif; ?>
      <div class="mb-3">
        <?php if ($harga_lama): ?>
          <span class="text-muted text-decoration-line-through" style="font-size:1.2rem;">Rp<?= number_format($harga_lama,0,',','.') ?></span>
        <?php endif; ?>
        <span class="ms-2" style="font-size:2rem;font-weight:700;color:#e07b87;">Rp<?= number_format($f['harga'],0,',','.') ?></span>
      </div>
      <div class="mb-3">Stok: <b><?= (int)$f['stok'] ?></b></div>
      <div class="mb-3">Material: <b><?= htmlspecialchars($f['material']) ?></b></div>
      <div class="mb-3">Dimensi: <b><?= htmlspecialchars($f['dimensi']) ?></b></div>
      <div class="mb-3">Berat: <b><?= htmlspecialchars($f['berat']) ?> kg</b></div>
      <div class="mb-4">
        <button class="btn btn-lg btn-success me-2"><i class="fas fa-shopping-cart"></i> + Keranjang</button>
        <button class="btn btn-lg btn-primary"><i class="fas fa-bolt"></i> Beli Sekarang</button>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-12">
      <h4>Deskripsi Produk</h4>
      <div><?= nl2br(htmlspecialchars($f['deskripsi'])) ?></div>
    </div>
  </div>
</div>
<style>
.detail-img-wrap {background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;padding:1rem;}
</style>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 