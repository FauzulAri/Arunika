<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Unauthorized');
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];
$q = $conn->query("SELECT k.*, f.nama_furniture, f.gambar_furniture, f.harga, f.stok FROM keranjang k JOIN furniture f ON k.furniture_id = f.furniture_id WHERE k.user_id = $user_id");
$cart = [];
while ($row = $q->fetch_assoc()) {
    $cart[] = $row;
}
?>
<?php if (empty($cart)): ?>
  <div class="alert alert-info">Keranjang kosong.</div>
<?php else: ?>
  <?php foreach ($cart as $item): ?>
    <div class="cart-item d-flex align-items-center border-bottom py-3" data-id="<?= $item['keranjang_id'] ?>">
      <input type="checkbox" class="form-check-input cart-check me-3">
      <img src="/Arunika/assets/img/<?= htmlspecialchars($item['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($item['nama_furniture']) ?>" style="width:64px; height:64px; object-fit:cover; border-radius:8px; margin-right:16px;">
      <div class="flex-grow-1">
        <div class="fw-bold mb-1"><?= htmlspecialchars($item['nama_furniture']) ?></div>
        <div class="text-muted small mb-1">Stok: <?= $item['stok'] ?></div>
        <form class="d-flex align-items-center gap-2 mb-0" style="max-width:200px;">
          <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id'] ?>">
          <button type="button" data-action="minus" class="btn btn-outline-secondary btn-sm qty-minus">-</button>
          <input type="text" name="jumlah" class="form-control form-control-sm text-center item-qty" value="<?= $item['jumlah'] ?>" style="width:48px;" readonly>
          <button type="button" data-action="plus" class="btn btn-outline-secondary btn-sm qty-plus">+</button>
        </form>
      </div>
      <div class="text-end me-3">
        <div class="fw-bold item-price" data-price="<?= $item['harga'] ?>">Rp<?= number_format($item['harga'],0,',','.') ?></div>
        <?php if ($item['harga_satuan'] > $item['harga']): ?>
          <div class="text-decoration-line-through text-muted small">Rp<?= number_format($item['harga_satuan'],0,',','.') ?></div>
        <?php endif; ?>
      </div>
      <button type="button" class="btn btn-link text-danger btn-delete ms-2" data-id="<?= $item['keranjang_id'] ?>" title="Hapus"><i class="fa fa-trash"></i></button>
    </div>
  <?php endforeach; ?>
<?php endif; ?> 