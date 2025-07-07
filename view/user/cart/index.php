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
// Ambil 16 produk random untuk rekomendasi
$rekom = [];
$rq = $conn->query("SELECT * FROM furniture WHERE is_active=1 ORDER BY RAND() LIMIT 16");
while ($row = $rq->fetch_assoc()) {
    $rekom[] = $row;
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
        </div>
      </div>
      <!-- Section Rekomendasi Untukmu -->
      <div class="card p-3 mb-3 mt-4">
        <h4 class="mb-3">Rekomendasi Untukmu</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
          <?php foreach ($rekom as $r): ?>
            <div class="col">
              <div class="card h-100 shadow-sm border-0">
                <a href="/Arunika/view/user/product/detail.php?id=<?= $r['furniture_id'] ?>" style="text-decoration:none; color:inherit;">
                  <img src="/Arunika/assets/img/<?= htmlspecialchars($r['gambar_furniture'] ?? 'noimage.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($r['nama_furniture']) ?>" style="height:140px;object-fit:cover;">
                  <div class="fw-bold mb-1 text-center" style="font-size:1rem;min-height:38px;">
                    <?= htmlspecialchars($r['nama_furniture']) ?>
                  </div>
                </a>
                <div class="card-body d-flex flex-column">
                  <div class="mb-2 text-muted text-center" style="font-size:0.95rem;">Rp<?= number_format($r['harga'],0,',','.') ?></div>
                  <button type="button" class="btn btn-sm btn-success w-100 mt-auto btn-rekom-add" data-id="<?= $r['furniture_id'] ?>"><i class="fa fa-cart-plus"></i> + Keranjang</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card p-3 sticky-top mt-5" style="top:120px;">
        <h5 class="mb-3">Ringkasan belanja</h5>
        <div class="d-flex justify-content-between mb-2">
          <span>Total</span>
          <span id="cart-total" class="fw-bold">Rp0</span>
        </div>
        <div id="cart-info-promo" class="alert alert-info py-2 small mb-3">Pilih barang dulu sebelum pakai promo</div>
        <form id="checkout-form" method="post" action="/Arunika/view/user/cart/checkout.php">
          <input type="hidden" name="keranjang_ids" id="keranjang-ids">
          <button type="submit" class="btn btn-success w-100" id="checkout-btn" disabled>Beli</button>
        </form>
      </div>
    </div>
  </div>
</div>
<style>
.cart-item { transition: background 0.2s; }
.cart-item:hover { background: #f7f7fa; }
/* Grid rekomendasi agar lebar sama dengan keranjang */
.card .row-cols-md-4 { margin-left: 0; margin-right: 0; }
.card .col { padding-left: 0.5rem; padding-right: 0.5rem; }
/* Card rekomendasi: gambar, nama, harga, tombol urut dan tombol selalu di bawah */
.card-body { display: flex; flex-direction: column; justify-content: flex-start; padding-bottom: 1rem; }
.btn-rekom-add { margin-top: auto; }
@media (max-width: 991px) {
  .card .row-cols-md-4 { row-gap: 1rem; }
}
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

// Update label jumlah jenis barang
function updateJenisBarangLabel() {
  const jenis = document.querySelectorAll('.cart-item').length;
  const label = document.querySelector('label[for="select-all"]');
  if(label) label.innerHTML = `Pilih Semua (${jenis})`;
}

selectAll && selectAll.addEventListener('change', function() {
  document.querySelectorAll('.cart-check').forEach(cb => cb.checked = this.checked);
  updateTotal();
});

// Attach event handler checklist per-item (dan update label) setelah setiap refresh
function attachChecklistEvents() {
  document.querySelectorAll('.cart-check').forEach(cb => {
    cb.addEventListener('change', function() {
      let all = document.querySelectorAll('.cart-check').length;
      let checked = document.querySelectorAll('.cart-check:checked').length;
      selectAll.checked = (all === checked);
      updateTotal();
      updateCheckoutIds();
    });
  });
  updateJenisBarangLabel();
}

// Inisialisasi total dan checklist event
updateTotal();
attachChecklistEvents();
updateCheckoutIds();

// --- AJAX KERANJANG ---
function showToast(msg, type='success') {
  let toast = document.createElement('div');
  toast.className = `toast align-items-center text-bg-${type} border-0 position-fixed top-0 end-0 m-4 show`;
  toast.style.zIndex = 9999; toast.style.minWidth = '280px';
  toast.innerHTML = `<div class='d-flex'><div class='toast-body'>${msg}</div><button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast'></button></div>`;
  document.body.appendChild(toast);
  setTimeout(()=>{toast.classList.remove('show');toast.classList.add('fade');setTimeout(()=>toast.remove(),500);}, 2500);
}
// Event delegation untuk qty plus/minus & delete
cartList.addEventListener('click', async function(e) {
  // Qty plus/minus
  if (e.target.closest('.qty-minus') || e.target.closest('.qty-plus')) {
    const btn = e.target.closest('button');
    const form = btn.closest('form');
    const keranjang_id = form.querySelector('[name=keranjang_id]').value;
    const action = btn.dataset.action;
    btn.disabled = true;
    let res = await fetch('/Arunika/controller/keranjang_update_ajax.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: `keranjang_id=${keranjang_id}&action=${action}`
    });
    let data = await res.json();
    btn.disabled = false;
    if(data.success){
      let qtyInput = form.querySelector('.item-qty');
      qtyInput.value = data.jumlah;
      showToast(data.message, 'success');
      updateTotal();
      attachChecklistEvents();
    }else{
      showToast(data.message, 'danger');
    }
  }
  // Hapus item
  if (e.target.closest('.btn-delete')) {
    if(!confirm('Hapus barang dari keranjang?')) return;
    const btn = e.target.closest('.btn-delete');
    const keranjang_id = btn.dataset.id;
    btn.disabled = true;
    let res = await fetch('/Arunika/controller/keranjang_delete_ajax.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: `keranjang_id=${keranjang_id}`
    });
    let data = await res.json();
    btn.disabled = false;
    if(data.success){
      btn.closest('.cart-item').remove();
      showToast(data.message, 'success');
      updateTotal();
      attachChecklistEvents();
      // Tambahan: jika sudah tidak ada cart-item, tampilkan pesan keranjang kosong
      if(document.querySelectorAll('.cart-item').length === 0) {
        cartList.innerHTML = '<div class="alert alert-info">Keranjang kosong.</div>';
        cartTotal.innerText = 'Rp0';
        checkoutBtn.disabled = true;
      }
    }else{
      showToast(data.message, 'danger');
    }
  }
});
// Tambah dari rekomendasi
const rekomBtns = document.querySelectorAll('.btn-rekom-add');
rekomBtns.forEach(btn => {
  btn.addEventListener('click', async function(){
    btn.disabled = true;
    let id = btn.dataset.id;
    let res = await fetch('/Arunika/controller/keranjang_add_ajax.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: `furniture_id=${id}&jumlah=1`
    });
    let data = await res.json();
    btn.disabled = false;
    showToast(data.message, data.success ? 'success' : 'danger');
    if(data.success){
      // Fetch ulang isi keranjang dan update DOM
      let cartRes = await fetch('/Arunika/controller/keranjang_list_ajax.php');
      let cartHtml = await cartRes.text();
      cartList.innerHTML = cartHtml;
      updateTotal();
      attachChecklistEvents();
      updateCheckoutIds();
    }
  });
});

function getCheckedKeranjangIds() {
  let ids = [];
  document.querySelectorAll('.cart-check:checked').forEach(cb => {
    const item = cb.closest('.cart-item');
    if(item) ids.push(item.getAttribute('data-id'));
  });
  return ids;
}
// Update hidden input setiap kali checklist berubah
function updateCheckoutIds() {
  const ids = getCheckedKeranjangIds();
  document.getElementById('keranjang-ids').value = ids.join(',');
}
document.querySelectorAll('.cart-check').forEach(cb => {
  cb.addEventListener('change', updateCheckoutIds);
});
selectAll && selectAll.addEventListener('change', updateCheckoutIds);
// Juga update saat halaman load
updateCheckoutIds();
// Validasi sebelum submit
const checkoutForm = document.getElementById('checkout-form');
checkoutForm && checkoutForm.addEventListener('submit', function(e){
  if(!document.getElementById('keranjang-ids').value) {
    e.preventDefault();
    alert('Pilih minimal 1 barang untuk checkout!');
  }
});
</script>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 