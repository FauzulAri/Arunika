<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];
// Ambil data keranjang user
$q = $conn->query("SELECT k.*, f.nama_furniture, f.gambar_furniture, f.harga, f.stok FROM keranjang k JOIN furniture f ON k.furniture_id = f.furniture_id WHERE k.user_id = $user_id");
$cart = [];
while ($row = $q->fetch_assoc()) {
    $cart[] = $row;
}
ob_start();
?>
<div class="container py-4">
  <div class="row">
    <div class="col-lg-8 mb-4">
      <h2 class="mb-3">Keranjang</h2>
      <?php if (isset($_SESSION['message'])): ?>
        <div id="toast-msg" class="toast align-items-center text-bg-<?= $_SESSION['message_type'] ?? 'info' ?> border-0 position-fixed top-0 end-0 m-4 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index:9999; min-width:280px;">
          <div class="d-flex">
            <div class="toast-body">
              <?= $_SESSION['message'] ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
        <script>
          setTimeout(function(){
            var toast = document.getElementById('toast-msg');
            if(toast){ toast.classList.remove('show'); toast.classList.add('fade'); setTimeout(()=>toast.remove(), 500); }
          }, 2500);
        </script>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
      <?php endif; ?>
      <div class="card p-3 mb-3">
        <div class="d-flex align-items-center mb-2">
          <input type="checkbox" id="select-all" class="form-check-input me-2">
          <label for="select-all" class="form-label mb-0">Pilih Semua (<?= count($cart) ?>)</label>
        </div>
        <div id="cart-list">
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
                  <form method="post" action="/Arunika/controller/keranjang_update.php" class="d-flex align-items-center gap-2 mb-0" style="max-width:200px;">
                    <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id'] ?>">
                    <button type="submit" name="action" value="minus" class="btn btn-outline-secondary btn-sm qty-minus">-</button>
                    <input type="text" name="jumlah" class="form-control form-control-sm text-center item-qty" value="<?= $item['jumlah'] ?>" style="width:48px;" readonly>
                    <button type="submit" name="action" value="plus" class="btn btn-outline-secondary btn-sm qty-plus">+</button>
                  </form>
                </div>
                <div class="text-end me-3">
                  <div class="fw-bold item-price" data-price="<?= $item['harga'] ?>">Rp<?= number_format($item['harga'],0,',','.') ?></div>
                  <?php if ($item['harga_satuan'] > $item['harga']): ?>
                    <div class="text-decoration-line-through text-muted small">Rp<?= number_format($item['harga_satuan'],0,',','.') ?></div>
                  <?php endif; ?>
                </div>
                <form method="post" action="/Arunika/controller/keranjang_delete.php" onsubmit="return confirm('Hapus barang dari keranjang?')">
                  <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id'] ?>">
                  <button type="submit" class="btn btn-link text-danger btn-delete ms-2" title="Hapus"><i class="fa fa-trash"></i></button>
                </form>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card p-3 sticky-top" style="top:90px;">
        <h5 class="mb-3">Ringkasan belanja</h5>
        <div class="d-flex justify-content-between mb-2">
          <span>Total</span>
          <span id="cart-total" class="fw-bold">Rp0</span>
        </div>
        <div id="cart-info-promo" class="alert alert-info py-2 small mb-3">Pilih barang dulu sebelum pakai promo</div>
        <button class="btn btn-success w-100" id="checkout-btn" disabled>Beli</button>
      </div>
    </div>
  </div>
</div>
<style>
.cart-item { transition: background 0.2s; }
.cart-item:hover { background: #f7f7fa; }
@media (max-width: 600px) {
  .cart-item { flex-direction: column; align-items: flex-start !important; }
  .cart-item img { margin-bottom: 8px; }
}
</style>
<script>
// Checklist logic
const selectAll = document.getElementById('select-all');
const cartChecks = document.querySelectorAll('.cart-check');
const cartList = document.getElementById('cart-list');
const cartTotal = document.getElementById('cart-total');
const checkoutBtn = document.getElementById('checkout-btn');
function updateTotal() {
  let total = 0;
  let checked = 0;
  document.querySelectorAll('.cart-check').forEach((cb, i) => {
    if (cb.checked) {
      const item = cb.closest('.cart-item');
      const price = parseInt(item.querySelector('.item-price').dataset.price);
      const qty = parseInt(item.querySelector('.item-qty').value);
      total += price * qty;
      checked++;
    }
  });
  cartTotal.innerText = 'Rp' + total.toLocaleString('id-ID');
  checkoutBtn.disabled = (checked === 0);
}
selectAll && selectAll.addEventListener('change', function() {
  document.querySelectorAll('.cart-check').forEach(cb => cb.checked = this.checked);
  updateTotal();
});
document.querySelectorAll('.cart-check').forEach(cb => {
  cb.addEventListener('change', function() {
    let all = document.querySelectorAll('.cart-check').length;
    let checked = document.querySelectorAll('.cart-check:checked').length;
    selectAll.checked = (all === checked);
    updateTotal();
  });
});
// Inisialisasi total
updateTotal();
</script>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 