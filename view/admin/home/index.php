<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
// Statistik
$jumlah_user = $conn->query("SELECT COUNT(*) FROM user")->fetch_row()[0];
$jumlah_furniture = $conn->query("SELECT COUNT(*) FROM furniture WHERE is_active=1")->fetch_row()[0];
$jumlah_order = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0];
$jumlah_kategori = $conn->query("SELECT COUNT(*) FROM kategori WHERE is_active=1")->fetch_row()[0];
$jumlah_review = $conn->query("SELECT COUNT(*) FROM review")->fetch_row()[0];
?>
<h2 class="mb-4">Dashboard Admin</h2>
<div class="alert alert-info mb-4">Selamat datang di dashboard admin Arunika!</div>
<div class="row g-4 mb-4">
  <div class="col-md-3 col-6">
    <div class="card shadow-sm text-center p-3">
      <div class="fs-2 fw-bold text-primary"><?= $jumlah_user ?></div>
      <div class="text-muted">User Terdaftar</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="card shadow-sm text-center p-3">
      <div class="fs-2 fw-bold text-success"><?= $jumlah_furniture ?></div>
      <div class="text-muted">Furniture Aktif</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="card shadow-sm text-center p-3">
      <div class="fs-2 fw-bold text-warning"><?= $jumlah_order ?></div>
      <div class="text-muted">Total Order</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="card shadow-sm text-center p-3">
      <div class="fs-2 fw-bold text-info"><?= $jumlah_kategori ?></div>
      <div class="text-muted">Kategori</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="card shadow-sm text-center p-3">
      <div class="fs-2 fw-bold text-danger"><?= $jumlah_review ?></div>
      <div class="text-muted">Review</div>
    </div>
  </div>
</div>
<!-- Konten dashboard bisa dikembangkan di sini -->
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php';
?> 